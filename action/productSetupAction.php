<?php
session_start();
require('../database.php');
include_once('../necessaryClass/user.php');
if(!$obj->userType()){
	$_SESSION['proInMsg']="<p class='alert alert-danger'>You are not permited person !</p>";
	header('Location:../index.php?page=productSetup&folder=products');
	//header('Location:../index.php');
 exit();
}
$uploader=$obj->userType();//This variable person is uploader
$userId=$obj->userLoginId();	
$proName=trim(htmlspecialchars($_POST['proName']));
$proPrice=trim((int)$_POST['proPrice']);
$proQuantity=trim((int)$_POST['proQuantity']);
$totalPrice=($proPrice*$proQuantity);
$catId=trim((int)($_POST['catName']));
$selectProName=$db->prepare("SELECT * FROM products WHERE pro_name=?");//Check the duplicate product name
$selectProName->bindParam(1,$proName);
$selectProName->execute();
$nameRow=$selectProName->fetch(PDO::FETCH_ASSOC);
$checkName=$nameRow['pro_name'];
if($checkName==$proName){
	$_SESSION['proInMsg']="<p class='alert alert-warning'>Don't allowed duplicate name !</p>";
		header('Location:../index.php?page=productSetup&folder=products');
}else{
	if(!empty($proName) && !empty($proPrice) && !empty($proQuantity) && !empty($catId)){
		$insertProduct=$db->prepare('INSERT INTO `products` SET `user_id`=?,`cat_id`=?,`pro_name`=?,`pro_price`=?,`quantity`=?,`total_price`=?,`uploader`=?');
		$insertProduct->bindParam(1,$userId);
		$insertProduct->bindParam(2,$catId);
		$insertProduct->bindParam(3,$proName);
		$insertProduct->bindParam(4,$proPrice);
		$insertProduct->bindParam(5,$proQuantity);
		$insertProduct->bindParam(6,$totalPrice);
		$insertProduct->bindParam(7,$uploader);
		if($insertProduct->execute()){
			$_SESSION['proInMsg']="<p class='alert alert-success'>Your data has been successfully inserted</p>";
			header('Location:../index.php?page=productSetup&folder=products');
		}else{
			$_SESSION['proInMsg']="<p class='alert alert-danger'>System error !</p>";
			header('Location:../index.php?page=productSetup&folder=products');
		}
	}else{
		$_SESSION['proInMsg']="<p class='alert alert-warning'>Please fill up all input fields !</p>";
		header('Location:../index.php?page=productSetup&folder=products');
	}
}


?>