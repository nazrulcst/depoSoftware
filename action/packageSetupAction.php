<?php
	session_start();
	require('../database.php');
	$productNameId=$_POST['productName'];
	$productQuantity=$_POST['proQuantity'];
	echo"<pre>";

	
	$info = array('coffee', 'brown', 'caffeine');

	// Listing all the variables
	list($drink, $color, $power) = $info;
	echo "$drink is $color and $power makes it special.\n";
	echo"<hr>";
	$packageName=$_POST['packageName'];
	
	// package offer selection
	$packageSel=$db->prepare("SELECT * FROM pack_name WHERE package_name=?");
	$packageSel->bindParam(1,$packageName);
	$packageSel->execute();
	$packageRow=$packageSel->fetch(PDO::FETCH_OBJ);
	echo"<br>";
	echo $percent=$packageRow->percentage;
	// product price select query for percentage sales
	$productPriceSel=$db->prepare("SELECT * FROM products WHERE id=?");
	$productPriceSel->bindParam(1,$productNameId);
	$productPriceSel->execute();
	$priceRow=$productPriceSel->fetch(PDO::FETCH_OBJ);
	$proUnitPrice=$priceRow->pro_price;
	$totalPackagePrice=$proUnitPrice*$packageName;
	$totalPrice=($totalPackagePrice*$percent)/100;


?>