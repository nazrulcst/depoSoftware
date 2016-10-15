<?php
$dsn="mysql:host=localhost;dbname=depo_management;charset=utf8";
$userName="root"; 
$password="";
	try{
		$db = new PDO($dsn,$userName,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//die("Database connection successfully");
	}catch(PDOException $error){
		echo "Database connection is failed".$error->getMessage();
	}

?>