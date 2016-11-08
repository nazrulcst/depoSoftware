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
	$offPercent=$_POST['offPercent'];
	$packageName=trim($_POST['packageName']);
	echo $packageName;
	$curDate=date('Y-m-d');
	$curStrDate=strtotime($curDate);

	$existTotalProTaka='';
	$updateQuantity='';
	$packagePrice='';
	$packageQuantity='';
	$updatePackExe='';
	$packInsertExe='';
	// Depo Id select Query complete
		$depoIdSel=$db->prepare("SELECT depo.*,depo.id AS depoId,user.id FROM depo LEFT JOIN user ON depo.user_id=user.id WHERE depo.user_id=?");
		$depoIdSel->bindParam(1,$userLoginId);
		$depoIdSel->execute();
		$depoIdRow=$depoIdSel->fetch(PDO::FETCH_ASSOC);
		$depId=$depoIdRow['depoId'];
	//if(!empty($depoStoreId) && !empty($productQuantity)){
		//$db->beginTransaction();// Transaction start
		foreach($depoStoreId as $key=>$value){

			$depoStore=$db->prepare("SELECT * FROM depo_store WHERE id=?");
			$depoStore->bindParam(1,$value);
			$depoStore->execute();
			$depoStoreRow=$depoStore->fetch(PDO::FETCH_OBJ);
			$existPrice=$depoStoreRow->pro_price;
			$existTotalProQuan=$depoStoreRow->pro_quantity;
			$existTotalProTaka=$depoStoreRow->total_price;
			$entTotalQuan=$productQuantity[$key]+$offPercent[$key];//input total Quantity
			$packageQuantity=$entTotalQuan;//package total quantity
			$sinProPrice=$productQuantity[$key]*$existPrice;//input single pro_price
			$sinProPerPrice=$offPercent[$key]*$existPrice;//input single percentage
			$toalTak=$sinProPrice+$sinProPerPrice;//input total taka
			$percentageOff=($offPercent[$key]/100);//single pro_percentage
			echo $percentageOff;
			$totalProPrice=$toalTak-$sinProPerPrice;//product Totalprice

			$updateQuantity=$existTotalProQuan-$entTotalQuan;//depo_store update quantity
			$depoUpdateTk=$updateQuantity*$existPrice;//depo_store update taka
			// depo_store update query
			$depoStoreUp=$db->prepare("UPDATE depo_store SET pro_quantity=?,total_price=? WHERE id=?");
			$depoStoreUp->bindParam(1,$updateQuantity);
			$depoStoreUp->bindParam(2,$depoUpdateTk);
			$depoStoreUp->bindParam(3,$value);
			$depoStoreUp->execute();

			if(empty($packageName)){
				//select all data from package
				$selectPackage=$db->prepare("SELECT * FROM package WHERE store_id=? AND package_date=?");
				$selectPackage->bindParam(1,$value);
				$selectPackage->bindParam(2,$curDate);
				$selectPackage->execute();
				$rowPackage=$selectPackage->fetch(PDO::FETCH_ASSOC);
				$existDepoId=$rowPackage['depo_id'];
				$existStoreId=$rowPackage['store_id'];
				$existDate=$rowPackage['package_date'];
				$existItem=$rowPackage['total_item'];
				$existTaka=$rowPackage['total_sales_taka'];
				$existPercentage=$rowPackage['percentageOff'];
				$strExistDate=strtotime($existDate);
				$updateItem=$existItem+$entTotalQuan;
				$updateTotalTk=$existTaka+$totalProPrice;
				$updatePercentage=$existPercentage+$percentageOff;
				if($existStoreId==$value && $strExistDate==$curStrDate){
					// package table data update
					$packageUpdate=$db->prepare("UPDATE package SET total_item=?,percentageOff=?,total_sales_taka=? WHERE store_id=? AND package_date=?");
					$packageUpdate->bindParam(1,$updateItem);
					$packageUpdate->bindParam(2,$updatePercentage);
					$packageUpdate->bindParam(3,$updateTotalTk);
					$packageUpdate->bindParam(4,$value);
					$packageUpdate->bindParam(5,$curDate);
					$updatePackExe=$packageUpdate->execute();
					//
					echo"update";
				}else{
					//single product insert Query
					$packageInsert=$db->prepare("INSERT INTO package SET depo_id=?,store_id=?,total_item=?,percentageOff=?,total_sales_taka=?,package_date=?");
					$packageInsert->bindParam(1,$depId);
					$packageInsert->bindParam(2,$value);
					$packageInsert->bindParam(3,$entTotalQuan);
					$packageInsert->bindParam(4,$percentageOff);
					$packageInsert->bindParam(5,$totalProPrice);
					$packageInsert->bindParam(6,$curDate);
					$packInsertExe=$packageInsert->execute();
					echo"insert";
				}
				
			}//first if condition

		}//foreach

	/*/  pack_name id select query complete
		$pack_nameSel=$db->prepare("SELECT * FROM pack_name WHERE package_name=?");
		$pack_nameSel->bindParam(1,$packageName);
		$pack_nameSel->execute();
		$pack_NameRow=$pack_nameSel->fetch(PDO::FETCH_ASSOC);
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
			$packageInsert=$db->prepare("INSERT INTO package SET depo_id=?,total_item=?,percentageOff=?,total_sales_taka=?,package_date=?");
			$packageInsert->bindParam(1,$depId);
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