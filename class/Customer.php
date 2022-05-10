<?php
class Customer {	

	private $customerTable = 'food';	
	protected $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }

	public function login(){
		if($this->email && $this->password) {
			$sql = "SELECT * FROM ".$this->customerTable." WHERE email = '$this->email' AND password = '$this->password'";			
			$result = $this->conn->query($sql);
			if($result->num_rows > 0){
				$user = $result->fetch_assoc();
				$_SESSION["userid"] = $user['id'];				
				$_SESSION["name"] = $user['name'];					
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	public function signup($address,$name,$email,$phone,$password){
		$sql="INSERT INTO food (`name`, `email`, `password`, `phone`, `address`) VALUES('$name','$email','$password','$phone','$address');";
		if($this->conn->query($sql)===TRUE){
			return 1;
		}else return 0;
	}
	
	public function loggedIn (){
		if(!empty($_SESSION["userid"])) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function getAddress(){
		if($_SESSION["userid"]) {
			$sql = "SELECT email, phone, address FROM ".$this->customerTable." WHERE id = '".$_SESSION["userid"]."'";
			return $this->conn->query($sql);	
		}
	}
}
?>