<?php
 require('../database.php');
 session_start();
 require('../necessaryClass/user.php');

 if($obj->userType()){
	$cat=trim(htmlspecialchars($_POST['cat']));
	$catId=(int)$_POST['catId'];
	if(!empty($cat)){
		$catEdit=$db->prepare("UPDATE `category` SET catName=? WHERE id=?");
		$catEdit->bindParam(1,$cat);
		$catEdit->bindParam(2,$catId);
		if($catEdit->execute()){
			$_SESSION['cateditMsg']="<p class='alert alert-success'>Successfully update your data</p>";
			header('Location:../index.php?page=categoryEdit&folder=category&id=$catId');
		}else{
			$_SESSION['cateditMsg']="<p class='alert alert-danger'>System Error</p>";
			header('Location:../index.php?page=categoryEdit&folder=category&id=$catId');
		}
	}else{
		$_SESSION['cateditMsg']="<p class='alert alert-warning'>Please enter edit name</p>";
		header('Location:../index.php?page=categoryEdit&folder=category&id=$catId');
	}
 }else{
 	exit();
 }