<?php
session_start();
require('../database.php');
require_once('../necessaryClass/user.php');
$catName=trim(htmlspecialchars($_POST['catName']));
$checkCategory=$db->prepare("SELECT `catName` FROM `category` where catName=?");
$checkCategory->bindParam(1,$catName);
$checkCategory->execute();
$checkCatRow=$checkCategory->fetch(PDO::FETCH_OBJ);
if($obj->userType()){
	$catName=trim(htmlspecialchars($_POST['catName']));
	if(!empty($catName)){
		if($catName===$checkCatRow->catName){//this line use for checking duplicate value insert
			$_SESSION['catMsg']="<p class='alert alert-warning'>Don't allowed duplicat category name</p>";
			header('Location:../index.php?page=categorySetup&folder=setup');
		}else{
			$catInsert=$db->prepare("INSERT INTO `category` SET `catName`=?");
			$catInsert->bindParam(1,$catName);
				if($catInsert->execute()){
				$_SESSION['catMsg']="<p class='alert alert-success'>Your data has been successfully inserted";
				header('Location:../index.php?page=categorySetup&folder=setup');
				}
			}
	}else{
		$_SESSION['catMsg']="<p class='alert alert-warning'>Please insert your category name</p>";
		header('Location:../index.php?page=categorySetup&folder=setup');
		}
}else{
	$_SESSION['catMsg']="<p class='alert alert-danger'>Your are not permited to access this system</p>";
	header('Location:../index.php?page=categorySetup&folder=setup');
}
header('Location:../index.php?page=categorySetup&folder=setup');
