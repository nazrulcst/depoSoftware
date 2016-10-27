<?php
	session_start();
	require('../database.php');
	$productNameId=$_POST['productName'];
	$productQuantity=$_POST['proQuantity'];
	$totalTaka='';
	$totalQuantity='';
	$enterTotalQuantity='';
	foreach($productNameId as $value){
			$proname=$db->prepare("SELECT * FROM depo_store WHERE id=?");
			$proname->bindParam(1,$value);
			$proname->execute();
			$row=$proname->fetch(PDO::FETCH_OBJ);
			$totalTaka+=$row->pro_price; 
			$totalQuantity+=$row->quantity;
		
	}


foreach($productQuantity as $quantityValue){
	$updateProduct=$db->prepare("UPDATE products SET quantity=?,total_price=? WHERE id=?");

}



	echo $totalTaka;
	
	

	
	
	








	
	//$totalPrice=($totalPackagePrice*$percent)/100;


?>