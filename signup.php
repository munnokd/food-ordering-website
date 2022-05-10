<?php
include_once 'data/Database.php';
include_once 'class/Customer.php';

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);
include('html/header.php');
if ($customer->loggedIn()) {
	header("Location: index.php");
}

$signupMessage = '';
if (!empty($_POST["signup"]) && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["phone"]) && !empty($_POST["password"]) && !empty($_POST["cpassword"]) && !empty($_POST["address"])) {

	$email_Exist = 0;
	$email = $db->query("SELECT email FROM food WHERE email='" . $_POST['email'] . "'");
	foreach ($email as $row) {
		foreach ($row as $key)
			$email_Exist = 1;
	}

	if (strlen(strval($_POST['phone'])) != 10 || substr(strval($_POST['phone']), 0, 1) == 0) {
		$signupMessage = 'Phone Number must contain 10 digits';
	} else if ($email_Exist) {
		$signupMessage = 'User Already Exist with Entered Email id.';
	} else if (strlen($_POST['password']) < 8) {
		$signupMessage = 'Password must contain atleast 8 characters.';
	} else if (!preg_match('/[a-z]/', $_POST['password']) || !preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[0-9]/', $_POST['password']) || !strpos($_POST['password'], '@')) {
		$signupMessage = 'Password must contain atleast one number, one uppercase character, one lowercase character and @.';
	} else if ($_POST["password"] != $_POST["cpassword"]) {
		$signupMessage = 'Password Mismatch.';
	} else if ($customer->signup($_POST["address"], $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["password"])) {
		header("Location: index.php");
	} else {
		alert("Invalid Signup Please try again");

		function alert($msg)
		{
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	}
} else {
	$signupMessage = 'Fill all fields.';
}

?>
<title>Signup</title>
<?php include('html/container.php'); ?>

<div class="content">
	<div class="col-md-8">
		<div class="panel panel-info">
			<div class="panel-heading" style="background:black;color:white;">
				<div class="panel-title">Sign Up</div>
			</div>
			<div style="padding-top:30px" class="panel-body">
				<?php if ($signupMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $signupMessage; ?></div>
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="text" class="form-control" id="name" name="name" value="<?php if (!empty($_POST["name"])) {
																									echo $_POST["name"];
																								} ?>" placeholder="Enter name" style="background:white;" required>
					</div>
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="number" class="form-control" id="phone" name="phone" value="<?php if (!empty($_POST["phone"])) {
																										echo $_POST["phone"];
																									} ?>" placeholder="Enter phone number" style="background:white;" required>
					</div>
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="email" class="form-control" id="email" name="email" value="<?php if (!empty($_POST["email"])) {
																									echo $_POST["email"];
																								} ?>" placeholder="Enter email" style="background:white;" required>
					</div>
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="password" class="form-control" id="password" name="password" value="<?php if (!empty($_POST["password"])) {
																												echo $_POST["password"];
																											} ?>" placeholder="Enter password" required>
					</div>
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="password" class="form-control" id="cpassword" name="cpassword" value="<?php if (!empty($_POST["cpassword"])) {
																												echo $_POST["cpassword"];
																											} ?>" placeholder="Enter confirm password" required>
					</div>
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="text" class="form-control" id="address" name="address" value="<?php if (!empty($_POST["address"])) {
																										echo $_POST["address"];
																									} ?>" placeholder="Enter address" style="background:white;" required>
					</div>

					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<input type="submit" name="signup" style="background-color: black; color:white" value="Signup" class="btn btn-info">
						</div>
					</div>
					<div>
						<p>Already have account <a href="login.php" style="background-color: black; color:white" class="btn btn-info">Login</a></p>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<?php include('html/footer.php'); ?>