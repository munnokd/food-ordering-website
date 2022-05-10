<?php
include_once 'data/Database.php';
include_once 'class/Customer.php';
include_once 'class/Food.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);
$food = new Food($db);


// $sql="CREATE TABLE `foodList` (
// 	`id` INT(30) PRIMARY KEY NOT NULL AUTO_INCREMENT,
// 	`name` VARCHAR(30) NOT NULL,
// 	`price` INT(30) NOT NULL,
// 	`description` VARCHAR(200) NOT NULL,
// 	`images` VARCHAR(200) NOT NULL,
// 	`status` VARCHAR(10) NOT NULL DEFAULT 'ENABLE'
// 	) ";
// $sql="CREATE TABLE `foodOrder` (
// 		`id` INT(30) PRIMARY KEY NOT NULL AUTO_INCREMENT,
// 		`name` VARCHAR(30) NOT NULL,
// 		`price` INT(30) NOT NULL,
// 		`quantity` INT(30) NOT NULL,
// 		`order_date`DATE NOT NULL DEFAULT CURRENT_DATE(),
// 		`order_id` VARCHAR(50) NOT NULL
// 	) ";

// if($db->query($sql)===TRUE){
// 	echo "Table created suceesfully";
// }else{
// 	echo "error";
// }


if (!$customer->loggedIn()) {
	header("Location: login.php");
}
include('html/header.php');
?>
<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/foods.css">
<?php include('html/container.php'); ?>
<div class="content">
	<div class="container-fluid">
		<div class='row'>
			<?php
			$result = $food->itemsList();
			$count = 0;
			while ($item = $result->fetch_assoc()) {
				if ($count == 0) {
					echo "<div class='row'>";
				}
			?>
				<div class="col-md-3">
					<form method="post" action="cart.php?action=add&id=<?php echo $item["id"]; ?>">
						<div class="mypanel" id="card_x" align="center" style="margin: 1rem;" >
							<img src="<?php echo $item["images"]; ?>" width="200px" height="130px" >
							<h4 class="text-dark" style="font-weight: bold;"><?php echo $item["name"]; ?></h4>
							<h5 class="text-dark"><?php echo $item["description"]; ?></h5>
							<h5 class="text-success">₹ <?php echo $item["price"]; ?>/-</h5>
							<h5 class="text-primary">Quantity: <input type="number" min="1" max="25" name="quantity" class="form-control" value="1" style="width: 60px;"> </h5>
							<input type="hidden" name="item_name" value="<?php echo $item["name"]; ?>">
							<input type="hidden" name="item_price" value="<?php echo $item["price"]; ?>">
							<input type="hidden" name="item_id" value="<?php echo $item["id"]; ?>">
							<input type="submit" name="add" style="margin-top:5px;" class="btn btn-danger" value="Add to Cart">
						</div>
					</form>
				</div>

			<?php
				$count++;
				if ($count == 4) {
					echo "</div>";
					$count = 0;
				}
			}
			?>
		</div>
	</div>

	<?php include('html/footer.php'); ?>

	<!-- INSERT INTO `foodlist`(`name`, `price`, `description`, `images`) VALUES ('Italian Pizza','200','this is italian special pizza','https://www.vegrecipesofindia.com/wp-content/uploads/2020/11/pizza-recipe-2-500x375.jpg') -->