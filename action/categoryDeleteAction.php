<?php
session_start();
require('../database.php'); 
require_once('../necessaryClass/user.php');
if(!$obj->userType()){//check this he/she is a not valid user
	exit();
}else{
	if(isset($_GET['deleteId'])){
		$catDeleteId=$_GET['deleteId'];
		$catDelId=$db->prepare('DELETE FROM `category` WHERE `id`=?');
		$catDelId->bindParam(1,$catDeleteId);
		$execute=$catDelId->execute();
			if($execute){
				$_SESSION['catDelMsg']="<p class='alert alert-success'>Successfully deleted</p>";
				header('Location:../index.php?page=categoryView&folder=category');
			}else{
				$_SESSION['catDelMsg']="<p class='alert alert-warning'>Something wrong</p>";
				header('Location:../index.php?page=categoryView&folder=category');
			}
	}else{
		$_SESSION['catDelMsg']="<p class='alert alert-danger'>System done</p>";
		header('Location:../index.php?page=categoryView&folder=category');
	}
}
