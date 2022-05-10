<?php
class Food {	

	private $foodItemsTable = 'foodList';
	protected $conn;
	
	public function __construct($db){
        $this->conn = $db;
	}
	
	public function itemsList(){
		$sql = "SELECT id, name, price, description, images, status FROM " . $this->foodItemsTable;
		return $this->conn->query($sql);
	}
}
?>