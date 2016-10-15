<?php
	header('Content-Type: application/json');
	require("../database.php");
	$proName=$_POST['nameVal'];
	$selProName=$db->prepare("SELECT * FROM depo_store WHERE pro_id=?");
	$selProName->bindParam(1,$proName);
	$selProName->execute();
	$proRow=$selProName->fetch(PDO::FETCH_ASSOC);
	$price=$proRow['pro_price'];
	$data['price']=$price;
	echo json_encode($data);



	

?>