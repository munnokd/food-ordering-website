<?php
include_once 'data/Database.php';
include_once 'class/Customer.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

if (!$customer->loggedIn()) {
	header("Location: login.php");
}

if (isset($_POST["add"])) {
	if (isset($_SESSION["cart"])) {
		$item_array_id = array_column($_SESSION["cart"], "food_id");
		if (!in_array($_GET["id"], $item_array_id)) {
			$count = count($_SESSION["cart"]);
			$item_array = array(
				'food_id' => $_GET["id"],
				'item_name' => $_POST["item_name"],
				'item_price' => $_POST["item_price"],
				'item_id' => $_POST["item_id"],
				'item_quantity' => $_POST["quantity"]
			);
			$_SESSION["cart"][$count] = $item_array;
			echo '<script>window.location="cart.php"</script>';
		} else {
			echo '<script>window.location="cart.php"</script>';
		}
	} else {
		$item_array = array(
			'food_id' => $_GET["id"],
			'item_name' => $_POST["item_name"],
			'item_price' => $_POST["item_price"],
			'item_id' => $_POST["item_id"],
			'item_quantity' => $_POST["quantity"]
		);
		$_SESSION["cart"][0] = $item_array;
	}
}

if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		foreach ($_SESSION["cart"] as $keys => $values) {
			if ($values["food_id"] == $_GET["id"]) {
				unset($_SESSION["cart"][$keys]);
				echo '<script>window.location="cart.php"</script>';
			}
		}
	}
}

if (isset($_GET["action"])) {
	if ($_GET["action"] == "empty") {
		foreach ($_SESSION["cart"] as $keys => $values) {
			unset($_SESSION["cart"]);
			echo '<script>window.location="cart.php"</script>';
		}
	}
}

include('html/header.php');
?>
<title>Cart</title>
<?php include('html/container.php'); ?>
<div class="content">
	<div class="container-fluid">
		<div class='row'>
			<?php
			if (!empty($_SESSION["cart"])) {
			?>
				<h3><?php echo $_SESSION['name']; ?> Cart</h3>
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th width="40%">Food Name</th>
							<th width="10%">Quantity</th>
							<th width="20%">Price Details</th>
							<th width="15%">Order Total</th>
							<th width="5%">Action</th>
						</tr>
					</thead>
					<?php
					$total = 0;
					foreach ($_SESSION["cart"] as $keys => $values) {
					?>
						<tr>
							<td><?php echo $values["item_name"]; ?></td>
							<td><?php echo $values["item_quantity"] ?></td>
							<td>₹ <?php echo $values["item_price"]; ?></td>
							<td>₹ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
							<td><a href="cart.php?action=delete&id=<?php echo $values["food_id"]; ?>"><span class="text-danger">Remove</span></a></td>
						</tr>
					<?php
						$total = $total + ($values["item_quantity"] * $values["item_price"]);
					}
					?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">₹ <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
				</table>
				<?php
				echo '<a href="cart.php?action=empty"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Empty Cart</button></a>&nbsp;<a href="index.php"><button class="btn btn-success">Add more items</button></a>&nbsp;<a href="checkout.php"><button class="btn pull-right" style="background-color: black; color:white">Check Out</button></a>';
				?>
			<?php
			} elseif (empty($_SESSION["cart"])) {
			?>
				<div class="container">
					<div class="jumbotron">
						<h3>Your cart is empty. Please add food from <a href="index.php">food list</a> here.</h3>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</div>
<?php include('html/footer.php'); ?>