<?php
	session_start();
	date_default_timezone_set('Asia/Dhaka');
	require('../database.php');
	include('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['bookMsg']="<p class='alert alert-danger'>You are not permited user !</p>";
		header('Location:../index.php?page=orderBookSetup&folder=officeUtilities');
		exit();
	}
	$bookQuantity=trim(htmlspecialchars($_POST['bookQuantity']));
	$totalCost=(int)trim($_POST['totalCost']);
	$perBookCost=(int)($totalCost/$bookQuantity);
	$currentDate=date('Y-m-d');
	$currentDateStr=strtotime($currentDate);
	$insertExe='';
	$upDateExe='';

	if(!empty($bookQuantity) && !empty($bookQuantity)){
		$db->beginTransaction();
		$bookSelect=$db->prepare("SELECT * FROM order_book WHERE book_date=?");
		$bookSelect->bindParam(1,$currentDate);
		$bookSelect->execute();
		$bookRow=$bookSelect->fetch(PDO::FETCH_OBJ);
		$existDate=$bookRow->book_date;
		$existQuantity=$bookRow->book_quantity;
		$existCost=$bookRow->book_cost;
		$updateQuan=$existQuantity+$bookQuantity;
		$updateCost=$existCost+$totalCost;
		$upDatePercost=($updateCost/$updateQuan);
		$strExistDate=strtotime($existDate);
		if($currentDateStr==$strExistDate){
			$bookUpdate=$db->prepare('UPDATE order_book SET book_quantity=?,book_cost=?,per_book_cost=? WHERE book_date=?');
			$bookUpdate->bindParam(1,$updateQuan);
			$bookUpdate->bindParam(2,$updateCost);
			$bookUpdate->bindParam(3,$upDatePercost);
			$bookUpdate->bindParam(4,$currentDate);
			$upDateExe=$bookUpdate->execute();
		}else{
			// Order book insert Query
			$orderBookInsert=$db->prepare('INSERT INTO order_book SET book_quantity=?,book_cost=?,per_book_cost=?,book_date=?');
			$orderBookInsert->bindParam(1,$bookQuantity);
			$orderBookInsert->bindParam(2,$totalCost);
			$orderBookInsert->bindParam(3,$perBookCost);
			$orderBookInsert->bindParam(4,$currentDate);
			$insertExe=$orderBookInsert->execute();
		}
		
		if($upDateExe){
			$db->commit();
			$_SESSION['bookMsg']="<p class='alert alert-success'>Your data successfully update</p>";
			header('Location:../index.php?page=orderBookSetup&folder=officeUtilities');
		}elseif($insertExe){
			$db->commit();
			$_SESSION['bookMsg']="<p class='alert alert-success'>Your data successfully save</p>";
			header('Location:../index.php?page=orderBookSetup&folder=officeUtilities');
		}else{
			$db->rollback();
			$_SESSION['bookMsg']="<p class='alert alert-danger'>Your query has been faild !</p>";
			header('Location:../index.php?page=orderBookSetup&folder=officeUtilities');
		}
	}else{
		$_SESSION['bookMsg']="<p class='alert alert-warning'>Please insert all input fields</p>";
			header('Location:../index.php?page=orderBookSetup&folder=officeUtilities');
	}
?>