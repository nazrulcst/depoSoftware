<?php
	date_default_timezone_set('Asia/Dhaka');
	session_start();
	require('../database.php');
	include_once('../necessaryClass/user.php');
	if(!$obj->userLoginId()){
		$_SESSION['packMsg']="<p class='alert alert-danger'>You are not permited user!</p>";
		header("Location:../index.php?page=packageSetup&folder=depoinfo");
		exit();
	}
	$userLoginId=$obj->userLoginId();
	$depoStoreId=$_POST['productName'];
	$productQuantity=$_POST['proQuantity'];
	$offPercent=$_POST['offPercent'];
	$packageName=trim($_POST['packageName']);
	$curDate=date('Y-m-d');
	$curStrDate=strtotime($curDate);
	$wholeTotalQuan='';
	$wholeTotalTk='';
	$updateQuantity='';
	$packagePrice='';
	$packageQuantity='';
	$updatePackExe='';
	$packInsertExe='';
	$wholeUpExe='';
	$wholeInsert='';
	$wholeQuan='';
	$totalSIng='';
	$totalWSales='';
	$toalWquan='';
	
	// Depo Id select Query complete
		$depoIdSel=$db->prepare("SELECT depo.*,depo.id AS depoId,user.id FROM depo LEFT JOIN user ON depo.user_id=user.id WHERE depo.user_id=?");
		$depoIdSel->bindParam(1,$userLoginId);
		$depoIdSel->execute();
		$depoIdRow=$depoIdSel->fetch(PDO::FETCH_ASSOC);
		$depId=$depoIdRow['depoId'];
	if(!empty($depoStoreId)){
		$db->beginTransaction();// Transaction start
		foreach($depoStoreId as $key=>$value){
			$depoStore=$db->prepare("SELECT * FROM depo_store WHERE id=?");
			$depoStore->bindParam(1,$value);
			$depoStore->execute();
			$depoStoreRow=$depoStore->fetch(PDO::FETCH_OBJ);
			$existPrice=$depoStoreRow->pro_price;
			$existTotalProQuan=$depoStoreRow->pro_quantity;
			$existTotalProTaka=$depoStoreRow->total_price;
			$entTotalQuan=$productQuantity[$key]+$offPercent[$key];//input total Quantity
			$wholeTotalQuan+=$productQuantity[$key];//whole sales product quantity
			$wholeTotalTk+=$productQuantity[$key]*$existPrice;//whole total taka
			$packageQuantity+=$entTotalQuan;//package total quantity
			$sinProPrice=$productQuantity[$key]*$existPrice;//input single pro_price
			$totalSIng+=$sinProPrice;//its for depototal sales
			$sinProPerPrice=$offPercent[$key]*$existPrice;//input single percentage
			$toalTak=$sinProPrice+$sinProPerPrice;//input total taka
			//single percentage
			$mainProTaka=$productQuantity[$key]*$existPrice;
			$perProTaka=$offPercent[$key]*$existPrice;
			$per=$mainProTaka/$perProTaka;
			$percentageOff=($offPercent[$key]/100);//single pro_percentage
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
				if(!empty($productQuantity)){
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
					}
				}else{
					$_SESSION['packMsg']="<p class='alert alert-warning'>Please enter your package name</p>";
					header("Location:../index.php?page=packageSetup&folder=depoinfo");
				}
			}//first if condition

		}//foreach

	//  pack_name id select query complete
		$pack_nameSel=$db->prepare("SELECT * FROM pack_name WHERE package_name=?");
		$pack_nameSel->bindParam(1,$packageName);
		$pack_nameSel->execute();
		$pack_NameRow=$pack_nameSel->fetch(PDO::FETCH_ASSOC);
		$packNamePercentage=$pack_NameRow['percentage'];
		$packNameId=$pack_NameRow['id'];
	// select all data from package
		$selectPackage=$db->prepare("SELECT * FROM whole_sales WHERE pack_name_id=? AND whole_date=?");
		$selectPackage->bindParam(1,$packNameId);
		$selectPackage->bindParam(2,$curDate);
		$selectPackage->execute();
		$rowPackage=$selectPackage->fetch(PDO::FETCH_ASSOC);
		$existPackNameId=$rowPackage['pack_name_id'];
		$existPackDate=$rowPackage['whole_date'];
		$strPackExistDate=strtotime($existPackDate);
		$existTotalItem=$rowPackage['total_item'];
		$existTotalTaka=$rowPackage['whole_sales_tk'];
		$updateTotalItem=$existTotalItem+$wholeTotalQuan;// update totalITem Variable
		$totalSalesTaka=($packNamePercentage/100)*$wholeTotalTk;
		$updateTotalTaka=$existTotalTaka+$totalSalesTaka;
		if(!empty($packageName)){
			foreach($depoStoreId as $wKey=>$wVal){
				$depoStore=$db->prepare("SELECT * FROM depo_store WHERE id=?");
				$depoStore->bindParam(1,$wVal);
				$depoStore->execute();
				$depoStoreRow=$depoStore->fetch(PDO::FETCH_OBJ);
				$existPrice=$depoStoreRow->pro_price;
				$totalWSales+=$productQuantity[$wKey]*$existPrice;
				$toalWquan+=$productQuantity[$wKey];
			}
			if($existPackNameId==$packNameId && $strPackExistDate==$curStrDate){
				// package table data update
				$wholeSalesUP=$db->prepare("UPDATE whole_sales SET total_item=?,whole_sales_tk=? WHERE depo_id=? AND pack_name_id=? AND whole_date=?");
				$wholeSalesUP->bindParam(1,$updateTotalItem);
				$wholeSalesUP->bindParam(2,$updateTotalTaka);
				$wholeSalesUP->bindParam(3,$depId);
				$wholeSalesUP->bindParam(4,$packNameId);
				$wholeSalesUP->bindParam(5,$curDate);
				$wholeUpExe=$wholeSalesUP->execute();
			}else{
				// wholeSalesInsert table data insert	
				$totalSalesTaka=($packNamePercentage/100)*$wholeTotalTk;
				$wholeSalesInsert=$db->prepare("INSERT INTO whole_sales SET depo_id=?,pack_name_id=?,total_item=?,percentage=?,whole_sales_tk=?,whole_date=?");
				$wholeSalesInsert->bindParam(1,$depId);
				$wholeSalesInsert->bindParam(2,$packNameId);
				$wholeSalesInsert->bindParam(3,$wholeTotalQuan);
				$wholeSalesInsert->bindParam(4,$packNamePercentage);
				$wholeSalesInsert->bindParam(5,$totalSalesTaka);
				$wholeSalesInsert->bindParam(6,$curDate);
				$wholeInsert=$wholeSalesInsert->execute();
			}
		}//empty cheking end
		// select all package data
			$package=$db->prepare("SELECT * FROM package WHERE depo_id=? AND package_date=?");
			$package->bindParam(1,$depId);
			$package->bindParam(2,$curDate);
			$package->execute();
			$i='';
			$pTotalQuan='';
			$pTotalTk='';
			while($pRow=$package->fetch(PDO::FETCH_ASSOC)){
				$i++;
				$pTotalQuan+=$pRow['total_item'];
				$pTotalTk+=$pRow['total_sales_taka'];
			}
		//select all whole sales data
			$wholeSales=$db->prepare("SELECT * FROM whole_sales WHERE depo_id=? AND whole_date=?");
			$wholeSales->bindParam(1,$depId);
			$wholeSales->bindParam(2,$curDate);
			$wholeSales->execute();
			$inc='';
			$wTotalQuantity='';
			$wTotalTk='';
			while($wRow=$wholeSales->fetch(PDO::FETCH_ASSOC)){
				$inc++;
				$wTotalQuantity+=$wRow['total_item'];
				$wTotalTk+=$wRow['whole_sales_tk'];
			}
		// Exitst depo id in depo total sales table
		$selDepoTotalSales=$db->prepare("SELECT * FROM depo_total_sales WHERE depo_id=? AND date_time=?");
		$selDepoTotalSales->bindParam(1,$depId);
		$selDepoTotalSales->bindParam(2,$curDate);
		$selDepoTotalSales->execute();
		$selRow=$selDepoTotalSales->fetch(PDO::FETCH_ASSOC);
		$exist_depo_id=$selRow['depo_id'];	
		$exist_depo_Quan=$selRow['depo_total_sales_quantity'];	
		$exist_depo_taka=$selRow['today_sales_tk'];	
		$totalSalesQuantity=$pTotalQuan+$wTotalQuantity;
		$depoTotalSales=$pTotalTk+$wTotalTk;
		$updateQuanPackage=$packageQuantity+$exist_depo_Quan;
		$updateTakaPackage=$totalSIng+$exist_depo_taka;
		$updateQuanWhole=$exist_depo_Quan+$toalWquan;
		$updateTkWhole=$totalWSales+$exist_depo_taka;
		if($exist_depo_id){ // if Exist depo id in same date then execute update query else insert query
			// Depo total sales update Query
			if(!empty($packageName)){
				$depoTotalSaleUp=$db->prepare("UPDATE depo_total_sales SET depo_total_sales_quantity=?,today_sales_tk=? WHERE depo_id=? AND date_time=?");
				$depoTotalSaleUp->bindParam(1,$updateQuanWhole);
				$depoTotalSaleUp->bindParam(2,$updateTkWhole);
				$depoTotalSaleUp->bindParam(3,$exist_depo_id);
				$depoTotalSaleUp->bindParam(4,$curDate);
				$depoTotalSaleUp->execute();
			}else{
				$depoTotalSaleUp=$db->prepare("UPDATE depo_total_sales SET depo_total_sales_quantity=?,today_sales_tk=? WHERE depo_id=? AND date_time=?");
				$depoTotalSaleUp->bindParam(1,$updateQuanPackage);
				$depoTotalSaleUp->bindParam(2,$updateTakaPackage);
				$depoTotalSaleUp->bindParam(3,$exist_depo_id);
				$depoTotalSaleUp->bindParam(4,$curDate);
				$depoTotalSaleUp->execute();
			}
				
		}else{
			// depo total sales insert query
			$totalSalesInsert=$db->prepare("INSERT INTO depo_total_sales SET depo_id=?,depo_total_sales_quantity=?,today_sales_tk=?,date_time=?");
			$totalSalesInsert->bindParam(1,$depId);
			$totalSalesInsert->bindParam(2,$totalSalesQuantity);
			$totalSalesInsert->bindParam(3,$depoTotalSales);
			$totalSalesInsert->bindParam(4,$curDate);
			$totalSalesInsert->execute();	
		}// end total sales

		if($updatePackExe OR $wholeUpExe){
			$db->commit();
			$_SESSION['packMsg']="<p class='alert alert-success'>Update Success</p>";
			header("Location:../index.php?page=packageSetup&folder=depoinfo");
		}elseif($packInsertExe OR $wholeInsert){
			$db->commit();
			$_SESSION['packMsg']="<p class='alert alert-success'>Insert Success</p>";
			header("Location:../index.php?page=packageSetup&folder=depoinfo");
		}else{
			$db->rollback();
			$_SESSION['packMsg']="<p class='alert alert-danger'>Failed!</p>";
			header("Location:../index.php?page=packageSetup&folder=depoinfo");
		}

	}else{
		$_SESSION['packMsg']="<p class='alert alert-warning'>Please enter your package name</p>";
		header("Location:../index.php?page=packageSetup&folder=depoinfo");
	}
?>