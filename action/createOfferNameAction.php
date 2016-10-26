<?php
	session_start();
	require('../database.php');
	include_once('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['offMsg']="<p class='alert alert-danger'>You are not permited user</p>";
		header("Location:../index.php?page=createPackageName&folder=setup");
		exit();
	}
	$packageName=trim(htmlspecialchars($_POST['packageName']));
	$percentage=(int)trim($_POST['percentage']);
	if(!empty($packageName) && !empty($percentage)){
		$offerInsertQuery=$db->prepare("INSERT INTO pack_name SET package_name=?,percentage=?");
		$offerInsertQuery->bindParam(1,$packageName);
		$offerInsertQuery->bindParam(2,$percentage);
		if($offerInsertQuery->execute()){
			$_SESSION['offMsg']="<p class='alert alert-success'>Query has been success</p>";
		}else{
			$_SESSION['offMsg']="<p class='alert alert-danger'>System error!</p>";
		}
	}else{
		$_SESSION['offMsg']="<p class='alert alert-warning'>Please insert input fields !</p>";
	}
header("Location:../index.php?page=createPackageName&folder=setup");
?>