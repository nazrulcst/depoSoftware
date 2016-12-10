<?php
	date_default_timezone_set('Asia/Dhaka');
	session_start();
	require('../database.php');
	include('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['bookDist']="<p class='alert alert-danger'>You are not permited user !</p>";
		header('Location:../index.php?page=orderBookDistribution&folder=officeUtilities');
		exit();
	}
	$depoNameId=(int)trim($_POST['depoName']);
	$bookNumber=(int)trim($_POST['bookNumber']);
	$curDate=date('Y-m-d');
	if(!empty($depoNameId) && !empty($bookNumber)){
		// Book number sleect query
		$db->beginTransaction();
		$book_select=$db->prepare('SELECT * FROM book_distribution WHERE book_number=?');
		$book_select->bindParam(1,$bookNumber);
		$book_select->execute();
		$bookRow=$book_select->fetch(PDO::FETCH_ASSOC);
		$exitBoorNumber=$bookRow['book_number'];
		if($exitBoorNumber==null){
			$book_dist=$db->prepare('INSERT INTO book_distribution SET depo_id=?,book_number=?,enter_date=?');
			$book_dist->bindParam(1,$depoNameId);
			$book_dist->bindParam(2,$bookNumber);
			$book_dist->bindParam(3,$curDate);
			if($book_dist->execute()){
				$_SESSION['bookDist']="<p class='alert alert-success'>Your data has been successfully save</p>";
				header('Location:../index.php?page=orderBookDistribution&folder=officeUtilities');
			}else{
				$_SESSION['bookDist']="<p class='alert alert-danger'>Your insertion has been failed!</p>";
				header('Location:../index.php?page=orderBookDistribution&folder=officeUtilities');
			}	
		}else{
			$_SESSION['bookDist']="<p class='alert alert-info'>You enter already exist book number !</p>";
			header('Location:../index.php?page=orderBookDistribution&folder=officeUtilities');
		}
	}else{
		$_SESSION['bookDist']="<p class='alert alert-warning'>Please insert all input fileds !</p>";
		header('Location:../index.php?page=orderBookDistribution&folder=officeUtilities');
	}
?>