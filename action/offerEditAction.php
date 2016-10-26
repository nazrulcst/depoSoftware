<?php
	require('../database.php');
	session_start();
	include_once('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['offMsg']="<p class='alert alert-danger'>You are not permited user</p>";
		header("Location:../index.php?page=offerEdit&folder=setup&offerEid=3");
		exit();
	}
	$packageName=$_POST['packageName'];
	$percentage=$_POST['percentage'];
	$editId=$_POST['editId'];
	if(!empty($packageName) && !empty($percentage) && !empty($editId)){
		$offerUp=$db->prepare("UPDATE pack_name SET package_name=?,percentage=? WHERE id=?");
		$offerUp->bindParam(1,$packageName);
		$offerUp->bindParam(2,$percentage);
		$offerUp->bindParam(3,$editId);
		if($offerUp->execute()){
			$_SESSION['offMsg']="<p class='alert alert-success'>Successfully Edited</p>";
		}else{
			$_SESSION['offMsg']="<p class='alert alert-danger'>System Error</p>";
			header("Location:../index.php?page=offerEdit&folder=setup&offerEid=$editId");
		}
	}else{
		$_SESSION['offMsg']="<p class='alert alert-warning'>Please insert input fields</p>";
	}
	header("Location:../index.php?page=offerEdit&folder=setup&offerEid=$editId");



?>