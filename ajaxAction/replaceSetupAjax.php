<?php
	header('Content-Type: application/json');
	require("../database.php");
	$protIdVal=$_POST['protIdVal'];
	$selectProPrice=$db->prepare("SELECT * FROM depo_store WHERE pro_id=?");
	$selectProPrice->bindParam(1,$protIdVal);
	$selectProPrice->execute();
	$fetchRowData=$selectProPrice->fetch(PDO::FETCH_OBJ);
	$Unitprice=$fetchRowData->pro_price;
	$price['price']=$Unitprice;
	echo json_encode($price);
?>