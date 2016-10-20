<?php
	header('Content-Type: application/json');
	require("../database.php");
	$proNameId=$_POST['proNameVal'];
	$selProduct=$db->prepare("SELECT * FROM products WHERE id=?");
	$selProduct->bindParam(1,$proNameId);
	$selProduct->execute();
	$proRow=$selProduct->fetch(PDO::FETCH_ASSOC);
	$data['price']=$proRow['pro_price'];
	echo json_encode($data);
?>