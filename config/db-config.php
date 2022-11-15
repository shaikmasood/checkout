<?php
	// DB Param
	$host = 'localhost';
	$db_name = 'phptutorials';
	$username = 'root';
	$password = 'rooT@123';
	
	// DB connect method 
	$conn = mysqli_connect($host,$username,$password,$db_name);
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

?>

