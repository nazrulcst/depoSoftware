<?php
	session_start();
	require('../database.php');
	include('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['loginMsg']="<p class='alert alert-danger'>You are not permited user</p>";
		header("Location:../index.php?page=userCreateSetup&folder=setup");
		exit();
	}
	$userName=trim(htmlspecialchars($_POST['userName']));
	$userType=trim(htmlspecialchars($_POST['userType']));
	$userPass=trim($_POST['userPass']);
	$confirmPass=trim($_POST['userConfirmPass']);
	$sha1pass=sha1($userPass);
	$status=trim(htmlspecialchars($_POST['status']));
	if(!empty($userName) && !empty($userType) && !empty($userPass) && !empty($confirmPass) && !empty($status)){
		if($userPass===$confirmPass){
			$userCreate=$db->prepare("INSERT INTO user SET userName=?,password=?,userType=?,status=?");
			$userCreate->bindParam(1,$userName);
			$userCreate->bindParam(2,$sha1pass);
			$userCreate->bindParam(3,$userType);
			$userCreate->bindParam(4,$status);
			if($userCreate->execute()){
				$_SESSION['loginMsg']="<p class='alert alert-success'>User has been successfully creaated</p>";
				header("Location:../index.php?page=userCreateSetup&folder=setup");
			}else{
				$_SESSION['loginMsg']="<p class='alert alert-danger'>System Error !</p>";
				header("Location:../index.php?page=userCreateSetup&folder=setup");
			}
		}else{
			$_SESSION['loginMsg']="<p class='alert alert-warning'>Confirm password doesn't match !</p>";
			header("Location:../index.php?page=userCreateSetup&folder=setup");
		}
	}else{
		$_SESSION['loginMsg']="<p class='alert alert-warning'>Please insert all input field !</p>";
		header("Location:../index.php?page=userCreateSetup&folder=setup");
	}
?>