<?php

namespace database;

Class Database
{
	// DB Param
	private $host = 'localhost';
	private $db_name = 'checkout';
	private $username = 'root';
	private $password = 'rooT@123';
	private $conn;
	
	public function __construct(){
		//echo "ytest";
	}
	// DB connect method 
	public function connect()
	{
		$this->conn = null;
		
		$this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db_name);
		//echo "<pre>";print_r($this->conn);exit;
		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		// OR
		/*if (!$this->conn)
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}*/
		
		return $this->conn;
	}
}
?>

