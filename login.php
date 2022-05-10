<?php
include_once 'data/Database.php';
include_once 'class/Customer.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

if ($customer->loggedIn()) {
	header("Location: index.php");
}

$loginMessage = '';
if (!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
	$customer->email = $_POST["email"];
	$customer->password = $_POST["password"];
	if ($customer->login()) {
		header("Location: index.php");
	} else {
		$loginMessage = 'Invalid login! Please try again.';
	}
} else {
	$loginMessage = 'Fill all fields.';
}
include('html/header.php');
?>
<title>Login</title>
<?php include('html/container.php'); ?>
<div class="container">
	<div class="col-md-8">
		<div class="panel panel-info">
			<div class="panel-heading" style="background:black;color:white;">
				<div class="panel-title">Login</div>
			</div>
			<div style="padding-top:30px" class="panel-body">
				<?php if ($loginMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $loginMessage; ?></div>
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="text" class="form-control" id="email" name="email" value="<?php if (!empty($_POST["email"])) {
																									echo $_POST["email"];
																								} ?>" placeholder="Enter email" style="background:white;" required>
					</div>
					<div style="margin-bottom: 25px" class="mb-3">
						<input type="password" class="form-control" id="password" name="password" value="<?php if (!empty($_POST["password"])) {
																												echo $_POST["password"];
																											} ?>" placeholder="Enter password" required>
					</div>

					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<input type="submit" name="login" value="Login" class="btn 
								btn-dark" style="background-color: black; color:white">
						</div>
					</div>
					<div>
						<p>Do not have account <a href="signup.php" class="btn btn-dark" style="background-color: black; color:white">Signup</a></p>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<?php include('html/footer.php'); ?>