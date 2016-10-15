<?php
	session_start();
	require('../database.php');
	include_once('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['proDelMsg']="<p class='alert alert-danger'>You are not permitted user !</p>";
		header("Location:../index.php?page=productViewList&folder=products");
		exit();
	}
	$proDelid=$_GET['ProdelId'];
	$proDelelteQuery=$db->prepare("DELETE FROM products WHERE id=?");
	$proDelelteQuery->bindParam(1,$proDelid);
	if($proDelelteQuery->execute()){
		$_SESSION['proDelMsg']="<p class='alert alert-success'>Delete has been success</p>";
		header("Location:../index.php?page=productViewList&folder=products");
	}else{
		$_SESSION['proDelMsg']="<p class='alert alert-warnig'>Delete failed !</p>";
		header("Location:../index.php?page=productViewList&folder=products");
	}

