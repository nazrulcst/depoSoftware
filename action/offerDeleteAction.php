<?php
	require('../database.php');
	session_start();
	include_once('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['delMsg']="<p class='alert alert-danger'>You are not permited user!</p>";
		header("Location:../index.php?page=viewPackageName&folder=setup");
		exit();
	}
	$deleteId=$_GET['deleteId'];
	$offDelete=$db->prepare("DELETE FROM pack_name WHERE id=?");
	$offDelete->bindParam(1,$deleteId);
	if($offDelete->execute()){
		$_SESSION['delMsg']="<p class='alert alert-success'>Successfully Delete</p>";
		header("Location:../index.php?page=viewPackageName&folder=setup");
	}else{
		$_SESSION['delMsg']="<p class='alert alert-warning'>Delete Failed!</p>";
		header("Location:../index.php?page=viewPackageName&folder=setup");
	}
?>