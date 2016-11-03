<?php
	date_default_timezone_set("Asia/Dhaka");
	session_start();
	require('../database.php');
	$depoId=$_POST['depoNameId'];
	$proId=$_POST['proNameId'];
	$proUnitPrice=$_POST['UnitPrice'];
	$ProQuantity=$_POST['ProQuantity'];
	$entQuantity=$_POST['entQuantity'];
	$totalPrice=$proUnitPrice*$entQuantity;// total price for depo store table
	$upQuantity=$ProQuantity-$entQuantity;// update quantity for pruduct table
	$updatePrice=$proUnitPrice*$upQuantity;// update total price for pruduct table
	$currentDate=date("Y-m-d");
	$currentDateStr=strtotime($currentDate);
	if($ProQuantity>=$entQuantity){ // Checking the suficient Quantity
		//depo store update query
		$proNameFromstore=$db->prepare("SELECT depo_store.*,depo_store.id AS depoStoreId,products.pro_name AS productName FROM depo_store LEFT JOIN products ON depo_store.pro_id=products.id LEFT JOIN depo ON depo_store.depo_id=depo.id WHERE depo_store.pro_id=?");
		$proNameFromstore->bindParam(1,$proId);
		$proNameFromstore->execute();
		$fetchDepoStoreId=$proNameFromstore->fetch(PDO::FETCH_ASSOC);
		$depoStoreId=$fetchDepoStoreId['depoStoreId'];
		$depoStoreUpdateId=$fetchDepoStoreId['pro_id'];
		$depoStoreProQuantity=$fetchDepoStoreId['pro_quantity'];//end select update query
		$updateQuantity=$entQuantity+$depoStoreProQuantity;// update quantity for depo store table
		$upTotalPrice=$updateQuantity*$proUnitPrice; // update total price ofr depo store table
		$existDate=$fetchDepoStoreId['store_date'];
		$strExistDate=strtotime($existDate);

		if(!empty($depoId) && !empty($proId) && !empty($entQuantity)){
			$db->beginTransaction();//Begin Transaction  connect and start
		
			if($proId==$depoStoreUpdateId){// Depo Store update Query
				$soreUpdate=$db->prepare("UPDATE depo_store SET pro_quantity=?,total_price=?,store_date=? WHERE id=?");
				$soreUpdate->bindParam(1,$updateQuantity);
				$soreUpdate->bindParam(2,$upTotalPrice);
				$soreUpdate->bindParam(3,$currentDate);
				$soreUpdate->bindParam(4,$depoStoreId);
				$storeUpExe=$soreUpdate->execute();
			}else{// Depo Store insert Query
				$storeInsertQuery=$db->prepare("INSERT INTO depo_store SET depo_id=?,pro_id=?,pro_quantity=?,pro_price=?,total_price=?,store_date=?");
				$storeInsertQuery->bindParam(1,$depoId);
				$storeInsertQuery->bindParam(2,$proId);
				$storeInsertQuery->bindParam(3,$entQuantity);
				$storeInsertQuery->bindParam(4,$proUnitPrice);
				$storeInsertQuery->bindParam(5,$totalPrice);
				$storeInsertQuery->bindParam(6,$currentDate);
				$insertExe=$storeInsertQuery->execute();
			}
			//Product Quantity update Query
			$upQuery=$db->prepare("UPDATE products SET quantity=?,total_price=? WHERE id=?");
			$upQuery->bindParam(1,$upQuantity);
			$upQuery->bindParam(2,$updatePrice);
			$upQuery->bindParam(3,$proId);
			$upExecute=$upQuery->execute();
		
			// Message return script
			if($upExecute && $insertExe OR $upExecute && $storeUpExe){
		 		$db->commit();
		 		$_SESSION['storeMsg']="<p class='alert alert-success'>Query has been successful</p>";
		 		header("Location:../index.php?page=depoStoreSetup&folder=depoinfo");
			}else{
		 		$db->rollback();
		 		$_SESSION['storeMsg']="<p class='alert alert-warning'>System error !</p>";
		 		header("Location:../index.php?page=depoStoreSetup&folder=depoinfo");
			}
		 
		}else{
			$_SESSION['storeMsg']="<p class='alert alert-warning'>Please insert input field !</p>";
			header("Location:../index.php?page=depoStoreSetup&folder=depoinfo");	
		}

	}else{
		$_SESSION['storeMsg']="<p class='alert alert-warning'>Please enter available Quantity !</p>";
		header("Location:../index.php?page=depoStoreSetup&folder=depoinfo");
	}
?>