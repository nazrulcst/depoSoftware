<?php
	date_default_timezone_set("Asia/Dhaka");
	require("../database.php");
	session_start();
	$depoId=$_POST['depoName'];
	$proId=$_POST['proName'];
	$proPrice=$_POST['proPrice'];
	$repQuantity=$_POST['repQuantity'];
	$repTotalPrice=$repQuantity*$proPrice;
	$currentDate=date("Y-m-d");
	$strCurrentDate=strtotime($currentDate);
	$warUpExe='';
	$warInsExe='';
	$totalWarUpExe='';
	$totalWarInsExe='';
	if(!empty($depoId) && !empty($proId) && !empty($proPrice) && !empty($repQuantity)){
		$db->beginTransaction();
		// Product id selet for warranty table data insert & update operation
		$selWarTableData=$db->prepare("SELECT * FROM warranty WHERE depo_id=? AND pro_id=? AND replace_date=?");
		$selWarTableData->bindParam(1,$depoId);
		$selWarTableData->bindParam(2,$proId);
		$selWarTableData->bindParam(3,$currentDate);
		$selWarTableData->execute();
		$selWarRow=$selWarTableData->fetch(PDO::FETCH_ASSOC);
		$existProId=$selWarRow['pro_id'];
		$existDepoId=$selWarRow['depo_id'];
		$existRepDate=$selWarRow['replace_date'];
		$existStrDate=strtotime($existRepDate);
		$existQuantity=$selWarRow['quantity'];
		$updateQuantity=$repQuantity+$existQuantity; // Update warranty Quantity Variable
		$existTotalPrice=$selWarRow['total_price'];
		$updateTotalPrice=$existTotalPrice+$repTotalPrice;
		
	// At first Checking the warranty table data then the insert & update Query the below 	
		if($existProId==$proId && $existDepoId==$depoId && $strCurrentDate==$existStrDate){
			// Update Warranty Table data Query
			$warrantyUpdate=$db->prepare("UPDATE warranty SET quantity=?,total_price=? WHERE depo_id=? AND pro_id=? AND replace_date=?");
			$warrantyUpdate->bindParam(1,$updateQuantity);
			$warrantyUpdate->bindParam(2,$updateTotalPrice);
			$warrantyUpdate->bindParam(3,$existDepoId);
			$warrantyUpdate->bindParam(4,$existProId);
			$warrantyUpdate->bindParam(5,$existRepDate);
			$warUpExe=$warrantyUpdate->execute();
		}else{
			// Insert warranty table data Query
			$warrantyInsert=$db->prepare("INSERT INTO warranty SET depo_id=?,pro_id=?,pro_price=?,quantity=?,total_price=?,replace_date=?");
			$warrantyInsert->bindParam(1,$depoId);
			$warrantyInsert->bindParam(2,$proId);
			$warrantyInsert->bindParam(3,$proPrice);
			$warrantyInsert->bindParam(4,$repQuantity);
			$warrantyInsert->bindParam(5,$repTotalPrice);
			$warrantyInsert->bindParam(6,$currentDate);
			$warInsExe=$warrantyInsert->execute();
		}
	// Warranty table data select for Total warranty table inser & update
		$proIdSelect=$db->prepare("SELECT warranty.*,warranty.id AS warrantyId,depo.* FROM warranty LEFT JOIN depo ON warranty.depo_id=depo.id WHERE depo_id=? AND replace_date=?");
		$proIdSelect->bindParam(1,$depoId);
		$proIdSelect->bindParam(2,$currentDate);
		$proIdSelect->execute();
		$totalQuantity="";
		$totalPrice="";
		$i=0;
		while($selProRow=$proIdSelect->fetch(PDO::FETCH_ASSOC)){
			$totalPrice+=$selProRow['total_price'];
			$totalQuantity+=$selProRow['quantity'];
			$i++;
		}
		ECHO"<BR>";
		echo "warranty table total quantity".$totalQuantity."<br>";
		echo "warranty table total taka".$totalPrice."<br>";
	// Total_warranty table data select
		$selecTotalWarranty=$db->prepare("SELECT total_warranty.*,total_warranty.depo_id AS depoId,depo.id FROM total_warranty LEFT JOIN depo ON total_warranty.depo_id=depo.id WHERE total_warranty.depo_id=? AND total_warranty.warranty_date=?");
		$selecTotalWarranty->bindParam(1,$depoId);
		$selecTotalWarranty->bindParam(2,$currentDate);
		$selecTotalWarranty->execute();
		$totalWarrantyRow=$selecTotalWarranty->fetch(PDO::FETCH_ASSOC);
		$totalWarrExistDepoId=$totalWarrantyRow['depo_id'];
		$totalWarrExistQuantity=$totalWarrantyRow['warranty_quantity'];
		$totalWarrExistTotalTaka=$totalWarrantyRow['total_warranty_tk'];
		$totalWarrExistDate=$totalWarrantyRow['warranty_date'];
		$strExistDate=strtotime($totalWarrExistDate);
		$updateTotalQuantity=$totalWarrExistQuantity+$repQuantity;
		$updateTotalWarrantyTaka=$repTotalPrice+$totalWarrExistTotalTaka;
		// total warranty table data select query
		if($totalWarrExistDepoId==$depoId && $strCurrentDate==$strExistDate){
			// Total warranty table data Update
			$totalWarrantyUpdate=$db->prepare("UPDATE total_warranty SET warranty_quantity=?,total_warranty_tk=? WHERE depo_id=? AND warranty_date=?");
			$totalWarrantyUpdate->bindParam(1,$updateTotalQuantity);
			$totalWarrantyUpdate->bindParam(2,$updateTotalWarrantyTaka);
			$totalWarrantyUpdate->bindParam(3,$existDepoId);
			$totalWarrantyUpdate->bindParam(4,$totalWarrExistDate);
			$totalWarUpExe=$totalWarrantyUpdate->execute();
		}else{
			// Total warranty table data insert Query
			$totalWarrantyInser=$db->prepare("INSERT INTO total_warranty SET depo_id=?,warranty_quantity=?, 	total_warranty_tk=?,warranty_date=?");
			$totalWarrantyInser->bindParam(1,$depoId);	
			$totalWarrantyInser->bindParam(2,$totalQuantity);	
			$totalWarrantyInser->bindParam(3,$totalPrice);	
			$totalWarrantyInser->bindParam(4,$currentDate);
			$totalWarInsExe=$totalWarrantyInser->execute();
		}
		if($warUpExe && $totalWarUpExe OR $totalWarInsExe){
			$db->commit();
			$_SESSION['rplsMsg']="<p class='alert alert-success'>Your query has been success</p>";
			header("Location:../index.php?page=replaceSetup&folder=replace");
		}elseif($warInsExe && $totalWarUpExe OR $totalWarInsExe){
			$db->commit();
			$_SESSION['rplsMsg']="<p class='alert alert-success'>Your query has been success</p>";
			header("Location:../index.php?page=replaceSetup&folder=replace");
		}else{
			$db->rollback();
			$_SESSION['rplsMsg']="<p class='alert alert-danger'>Your operations failed !</p>";
			header("Location:../index.php?page=replaceSetup&folder=replace");
		}
	}else{
		$_SESSION['rplsMsg']="<p class='alert alert-warning'>Please insert all fields !</p>";
		header("Location:../index.php?page=replaceSetup&folder=replace");
	}
?>

