<?php
class Order {	
	private $ordersTable = 'foodOrder';	
	protected $conn;
	
	public function __construct($db){
        $this->conn = $db;
	}
	
	public function insert(){		
		if($this->item_name) {
			$this->item_name = htmlspecialchars(strip_tags($this->item_name));
			$this->item_price = htmlspecialchars(strip_tags($this->item_price));
			$this->quantity = htmlspecialchars(strip_tags($this->quantity));
			$this->order_date = htmlspecialchars(strip_tags($this->order_date));
			$this->order_id = htmlspecialchars(strip_tags($this->order_id));		
		$values = "VALUES('" . $this->item_name . "', '" . $this->item_price . "', '" . $this->quantity . "', '" . $this->order_date . "', '" . $this->order_id . "');" ;
		$sql="INSERT INTO ".$this->ordersTable."( `name`, `price`, `quantity`, `order_date`, `order_id`) " . $values;
		if($this->conn->query($sql) === TRUE){
			return true;
		}
		}
	}
}
?>