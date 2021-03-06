<?php
	date_default_timezone_set("Asia/Dhaka");
	session_start();
	require("../database.php");
	include("../necessaryClass/user.php");
	if(!$obj->userLoginId()){
		$_SESSION['rpMsg']="<p class='alert alert-danger'>You are invalid user</p>";
		header("Location:../index.php?page=depoTodaySales&folder=depoinfo");
		exit();
	}
	$userLoginId=$obj->userLoginId();// Required userLogin Id
	$depoNameId=$_POST['depoName'];
	$proNameId=$_POST['proName'];
	$proUnitPrice=$_POST['proUnitPrice'];
	$salesQuantity=$_POST['salesQuantity'];
	$totalTaka=$proUnitPrice*$salesQuantity;
	$currentDate=date("Y-m-d");
	$curTimeStr=strtotime($currentDate);
	$depoSalesUpdExe='';
	$depoSalesInsExe='';
	$totalDepoSalesUpdExe='';
	$totalDepoSalesInsExe='';
	if(!empty($depoNameId) && !empty($proNameId) && !empty($proUnitPrice) && !empty($salesQuantity)){
		$db->beginTransaction();
	// Depo store select for store Quantity minus Query 
		$selStore=$db->prepare("SELECT * FROM depo_store WHERE pro_id=?");
		$selStore->bindParam(1,$proNameId);
		$selStore->execute();
		$storeRow=$selStore->fetch(PDO::FETCH_ASSOC);
		$proStoreQuantity=$storeRow['pro_quantity'];
		$storeTotalPrice=$storeRow['total_price'];
		$updateQuantity=$proStoreQuantity-$salesQuantity; //store Update Quantity variable
		$upTotal_price=$storeTotalPrice-$totalTaka; // store Update total Price variable
	// Depo stroe update Query mean product minus from this table
		$updateStoreQuery=$db->prepare("UPDATE depo_store SET pro_quantity=?,total_price=? WHERE pro_id=?");
		$updateStoreQuery->bindParam(1,$updateQuantity);
		$updateStoreQuery->bindParam(2,$upTotal_price);
		$updateStoreQuery->bindParam(3,$proNameId);
		$updateStoreQuery->execute();
		// Complete the depo store update with minus data

	// Depo today_sales data select query
		$depoTodaySalesQuery=$db->prepare("SELECT * FROM  depo_sales WHERE depo_id=? AND date_time=?");
		$depoTodaySalesQuery->bindParam(1,$depoNameId);
		$depoTodaySalesQuery->bindParam(2,$currentDate);
		$depoTodaySalesQuery->execute();
		$selRow=$depoTodaySalesQuery->fetch(PDO::FETCH_ASSOC);
		$quantity=$selRow['quantity'];
		$Totalprice=$selRow['total_price'];
		$upTotal_price=$Totalprice+$totalTaka;
	// depos sales select pro_id Query
		$proId=$db->prepare("SELECT depo_sales.*,depo_sales.id AS depoSalesId,depo.id,products.id AS proDuctId FROM depo_sales LEFT JOIN depo ON depo_sales.depo_id=depo.id LEFT JOIN products ON depo_sales.pro_id=products.id WHERE depo_sales.pro_id=? AND depo_sales.date_time=?");
		$proId->bindParam(1,$proNameId);
		$proId->bindParam(2,$currentDate);
		$proId->execute();
		$proIdRow=$proId->fetch(PDO::FETCH_ASSOC);
		$existProductId=$proIdRow['pro_id'];
		$existDate=$proIdRow['date_time'];
		$existQuantity=$proIdRow['quantity']."<br>";
		$upTotalQuantity=$existQuantity+$salesQuantity;
		$existDateStr=strtotime($existDate);
		if($existProductId && $existDateStr==$curTimeStr){
			// Depo sale update Query
			$depoSalesUpQuery=$db->prepare("UPDATE depo_sales SET quantity=?,total_price=? WHERE pro_id=? AND date_time=?");
			$depoSalesUpQuery->bindParam(1,$upTotalQuantity);
			$depoSalesUpQuery->bindParam(2,$upTotal_price);
			$depoSalesUpQuery->bindParam(3,$existProductId);
			$depoSalesUpQuery->bindParam(4,$currentDate);
			$depoSalesUpdExe=$depoSalesUpQuery->execute();
		}else{
			// Depo today_sales table data insert Query 
			$todaySalesInsert=$db->prepare("INSERT INTO depo_sales SET depo_id=?,pro_id=?,pro_price=?,quantity=?,total_price=?,date_time=?");
			$todaySalesInsert->bindParam(1,$depoNameId);
			$todaySalesInsert->bindParam(2,$proNameId);
			$todaySalesInsert->bindParam(3,$proUnitPrice);
			$todaySalesInsert->bindParam(4,$salesQuantity);
			$todaySalesInsert->bindParam(5,$totalTaka);
			$todaySalesInsert->bindParam(6,$currentDate);
			$depoSalesInsExe=$todaySalesInsert->execute();
		}

	// select from depo sales/today sales for total sales table report
		$depoSalesQuery=$db->prepare("SELECT * FROM  depo_sales WHERE depo_id=? AND date_time=?");
		$depoSalesQuery->bindParam(1,$depoNameId);
		$depoSalesQuery->bindParam(2,$currentDate);
		$depoSalesQuery->execute();
		$depoTotalSales='';
		$totalSalesQuantity='';
		$depoId='';
		$i=1;
		while($row=$depoSalesQuery->fetch(PDO::FETCH_OBJ)){
			$depoTotalSales+=$row->total_price;
			$totalSalesQuantity+=$row->quantity;
			$depoId=$row->depo_id;
			$i++;
		}
	// Exitst depo id in depo total sales table
		$selDepoTotalSales=$db->prepare("SELECT * FROM depo_total_sales WHERE depo_id=? AND date_time=?");
		$selDepoTotalSales->bindParam(1,$depoNameId);
		$selDepoTotalSales->bindParam(2,$currentDate);
		$selDepoTotalSales->execute();
		$selRow=$selDepoTotalSales->fetch(PDO::FETCH_ASSOC);
		$exist_depo_id=$selRow['depo_id'];
		$exist_depo_Quan=$selRow['depo_total_sales_quantity'];
		$exist_depo_tk=$selRow['today_sales_tk'];
		$upQuantity=$salesQuantity+$exist_depo_Quan;
		$upTaka=$totalTaka+$exist_depo_tk;
		if($exist_depo_id){ // if Exist depo id in same date then execute update query else insert query
			// Depo total sales update Query
			$depoTotalSaleUp=$db->prepare("UPDATE depo_total_sales SET depo_total_sales_quantity=?,today_sales_tk=? WHERE depo_id=? AND date_time=?");
			$depoTotalSaleUp->bindParam(1,$upQuantity);
			$depoTotalSaleUp->bindParam(2,$upTaka);
			$depoTotalSaleUp->bindParam(3,$exist_depo_id);
			$depoTotalSaleUp->bindParam(4,$currentDate);
			$totalDepoSalesUpdExe=$depoTotalSaleUp->execute();	
		}else{
			// depo total sales insert query
			$totalSalesInsert=$db->prepare("INSERT INTO depo_total_sales SET depo_id=?,depo_total_sales_quantity=?,today_sales_tk=?,date_time=?");
			$totalSalesInsert->bindParam(1,$depoNameId);
			$totalSalesInsert->bindParam(2,$totalSalesQuantity);
			$totalSalesInsert->bindParam(3,$depoTotalSales);
			$totalSalesInsert->bindParam(4,$currentDate);
			$totalDepoSalesInsExe=$totalSalesInsert->execute();	
		}

		if($depoSalesUpdExe && $totalDepoSalesUpdExe OR $totalDepoSalesInsExe){
			$db->commit();
			$_SESSION['rpMsg']="<p class='alert alert-success'>Query has been successful</p>";
			header("Location:../index.php?page=depoTodaySales&folder=depoinfo");
		}elseif($depoSalesInsExe && $totalDepoSalesUpdExe OR $totalDepoSalesInsExe){
			$db->commit();
			$_SESSION['rpMsg']="<p class='alert alert-success'>Query has been successful</p>";
			header("Location:../index.php?page=depoTodaySales&folder=depoinfo");
		}else{
			$db->rollback();
			$_SESSION['rpMsg']="<p class='alert alert-danger'>Failed your query !</p>";
			header("Location:../index.php?page=depoTodaySales&folder=depoinfo");
		}
	}else{
		$_SESSION['rpMsg']="<p class='alert alert-warning'>Please fill up all fields !</p>";
		header("Location:../index.php?page=depoTodaySales&folder=depoinfo");
	}

?>