<?php
	header('Content-Type: application/json');
	require("../database.php");
	$proName=$_POST['nameVal'];
	$proInfoQuery=$db->prepare("SELECT * FROM products WHERE id=?");
	$proInfoQuery->bindParam(1,$proName);
	$proInfoQuery->execute();
	$fetchData=$proInfoQuery->fetch(PDO::FETCH_ASSOC);
	$price=$fetchData['pro_price'];
	$quantity=$fetchData['quantity'];
	$data=[];
	$data['price']=$price;
	$data['quantity']=$quantity;
	echo json_encode($data);

?>