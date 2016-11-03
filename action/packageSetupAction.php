<?php
	date_default_timezone_set('Asia/Dhaka');
	session_start();
	require('../database.php');
	include_once('../necessaryClass/user.php');
	//if(!$obj->userLoginId()){
		//$_SESSION['packMsg']="<p class='alert alert-success'>Not found identify</p>";
		//header("Location:../index.php?page=packageSetup&folder=depoinfo");
		//exit();
	//}
	$userLoginId=$obj->userLoginId();
	$depoStoreId=$_POST['productName'];
	$productQuantity=$_POST['proQuantity'];
	echo"<pre>";
	print_r($productQuantity);
	$offPercent=$_POST['offPercent'];
	$packageName=trim(htmlspecialchars($_POST['packageName']));
	$curDate=date('Y-m-d');
	$curStrDate=strtotime($curDate);

	$existTotalProTaka='';
	$updateQuantity='';
	$packagePrice='';
	$packageQuantity='';
	$updatePackExe='';
	$packInsertExe='';
	//if(!empty($packageName) && !empty($depoStoreId) && !empty($productQuantity)){
		//$db->beginTransaction();// Transaction start
		foreach($depoStoreId as $key=>$value){
			$depoStore=$db->prepare("SELECT * FROM depo_store WHERE id=?");
			$depoStore->bindParam(1,$value);
			$depoStore->execute();
			$depoStoreRow=$depoStore->fetch(PDO::FETCH_OBJ);
			$existPrice=$depoStoreRow->pro_price;
			$existTotalProQuan=$depoStoreRow->pro_quantity;
			$existTotalProTaka=$depoStoreRow->total_price;
			$updateQuantity=$existTotalProQuan-$productQuantity[$key];//for depo_store update quantity 
			print_r($productQuantity[$key]);
			
			
			$lastTaka=$updateQuantity*$existPrice;// it's for depo_store update taka 
			echo $lastTaka;
			$packagePrice+=$existPrice*$productQuantity[$key]; // use for package sales table
			$packageQuantity+=$productQuantity[$key];// use for package sales table
			$indTotalTaka=$productQuantity[$key]*$existPrice;// indivisula total price per product
			$indPercentage=($offPercent[$key]/100)*$indTotalTaka;// indivisul percentage
		// depo_store update query
			$depoStoreUp=$db->prepare("UPDATE depo_store SET pro_quantity=?,total_price=? WHERE id=?");
			$depoStoreUp->bindParam(1,$updateQuantity);
			$depoStoreUp->bindParam(2,$lastTaka);
			$depoStoreUp->bindParam(3,$value);
			$depoStoreUp->execute();
		}
	/*/ Depo Id select Query
		$depoIdSel=$db->prepare("SELECT depo.*,depo.id AS depoId,user.id FROM depo LEFT JOIN user ON depo.user_id=user.id WHERE depo.user_id=?");
		$depoIdSel->bindParam(1,$userLoginId);
		$depoIdSel->execute();
		$depoIdRow=$depoIdSel->fetch(PDO::FETCH_ASSOC);
		$depId=$depoIdRow['depoId'];
	//  pack_name id select query
		$pack_nameSel=$db->prepare("SELECT * FROM pack_name WHERE package_name=?");
		$pack_nameSel->bindParam(1,$packageName);
		$pack_nameSel->execute();
		$pack_NameRow=$pack_nameSel->fetch(PDO::FETCH_ASSOC);
		$packNameId=$pack_NameRow['id'];
		$packNamePercentage=$pack_NameRow['percentage'];
	// select all data from package
		$selectPackage=$db->prepare("SELECT * FROM package WHERE pack_name_id=? AND package_date=?");
		$selectPackage->bindParam(1,$packNameId);
		$selectPackage->bindParam(2,$curDate);
		$selectPackage->execute();
		$rowPackage=$selectPackage->fetch(PDO::FETCH_ASSOC);
		$existPackNameId=$rowPackage['pack_name_id'];
		$existPackDate=$rowPackage['package_date'];
		$strPackExistDate=strtotime($existPackDate);
		$existTotalItem=$rowPackage['total_item'];
		$existTotalTaka=$rowPackage['total_sales_taka'];
		$updateTotalItem=$existTotalItem+$packageQuantity;// update totalITem Varia
		$totalSalesTaka=($packNamePercentage/100)*$packagePrice;
		$updateTotalTaka=$existTotalTaka+$totalSalesTaka;

		//if($existPackNameId==$packNameId && $strPackExistDate==$curStrDate){
			// package table data update
			$packageUpdate=$db->prepare("UPDATE package SET total_item=?,total_sales_taka=? WHERE depo_id=? AND pack_name_id=? AND package_date=?");
			$packageUpdate->bindParam(1,$updateTotalItem);
			$packageUpdate->bindParam(2,$updateTotalTaka);
			$packageUpdate->bindParam(3,$depId);
			$packageUpdate->bindParam(4,$packNameId);
			$packageUpdate->bindParam(5,$curDate);
			$updatePackExe=$packageUpdate->execute();
		//}else{
			// package table data insert	
			$totalSalesTaka=($packNamePercentage/100)*$packagePrice;
			$packageInsert=$db->prepare("INSERT INTO package SET depo_id=?,pack_name_id=?,total_item=?,percentageOff=?,total_sales_taka=?,package_date=?");
			$packageInsert->bindParam(1,$depId);
			$packageInsert->bindParam(2,$packNameId);
			$packageInsert->bindParam(3,$packageQuantity);
			$packageInsert->bindParam(4,$packNamePercentage);
			$packageInsert->bindParam(5,$totalSalesTaka);
			$packageInsert->bindParam(6,$curDate);
			$packInsertExe=$packageInsert->execute();
		//}
	/*
		if($updatePackExe){
			$db->commit();
			$_SESSION['packMsg']="<p class='alert alert-success'>Update Success</p>";
			header("Location:../index.php?page=packageSetup&folder=depoinfo");
		}elseif($packInsertExe){
			$db->commit();
			$_SESSION['packMsg']="<p class='alert alert-success'>Insert Success</p>";
			header("Location:../index.php?page=packageSetup&folder=depoinfo");
		}else{
			$db->rollback();
			$_SESSION['packMsg']="<p class='alert alert-danger'>Failed!</p>";
			header("Location:../index.php?page=packageSetup&folder=depoinfo");
		}
	}else{
		$_SESSION['packMsg']="<p class='alert alert-danger'>Please enter your package name</p>";
		header("Location:../index.php?page=packageSetup&folder=depoinfo");
	}
*/
?>