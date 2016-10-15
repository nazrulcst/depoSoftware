<?php
	date_default_timezone_set("Asia/Dhaka");
	session_start();
	require("../database.php");
	include("../necessaryClass/user.php");
	if(!$obj->userLoginId()){
		echo"Not balance you";
		exit();
	}
	$userLoginId=$obj->userLoginId();// Required userLogin Id
	echo $depoNameId=$_POST['depoName'];
	$proNameId=$_POST['proName'];
	$proUnitPrice=$_POST['proUnitPrice'];
	$salesQuantity=$_POST['salesQuantity'];
	$totalTaka=$proUnitPrice*$salesQuantity;
	$currentDate=date("Y-m-d");

	// Depo store select for store Quantity minus Query 
		$selStore=$db->prepare("SELECT * FROM depo_store WHERE pro_id=?");
		$selStore->bindParam(1,$proNameId);
		$storeSelExe=$selStore->execute();
		$storeRow=$selStore->fetch(PDO::FETCH_ASSOC);
		$proStoreQuantity=$storeRow['pro_quantity'];
		$storeTotalPrice=$storeRow['total_price'];
		$updateQuantity=$proStoreQuantity-$salesQuantity; // $ Update Quantity
		$upTotal_price=$storeTotalPrice-$totalTaka; // $ Update total Price in depo store
	// Depo stroe update Query
		$updateStoreQuery=$db->prepare("UPDATE depo_store SET pro_quantity=?,total_price=? WHERE pro_id=?");
		$updateStoreQuery->bindParam(1,$updateQuantity);
		$updateStoreQuery->bindParam(2,$upTotal_price);
		$updateStoreQuery->bindParam(3,$proNameId);
		$storeUpExe=$updateStoreQuery->execute();

	// Depo today_sales table data insert Query 
		$todaySalesInsert=$db->prepare("INSERT INTO depo_sales SET depo_id=?,pro_id=?,pro_price=?,quantity=?,total_price=?,date_time=?");
		$todaySalesInsert->bindParam(1,$depoNameId);
		$todaySalesInsert->bindParam(2,$proNameId);
		$todaySalesInsert->bindParam(3,$proUnitPrice);
		$todaySalesInsert->bindParam(4,$salesQuantity);
		$todaySalesInsert->bindParam(5,$totalTaka);
		$todaySalesInsert->bindParam(6,$currentDate);
		$salesInsertExe=$todaySalesInsert->execute();
		if($storeSelExe && $storeUpExe && $salesInsertExe){
			echo"Your query has been successfully work";
		}else echo"Your operations has been failed !";
		

	// select from depo sales/today sales for total sales table report
		$depoSalesQuery=$db->prepare("SELECT * FROM  depo_sales WHERE depo_id=? AND date_time=?");
		$depoSalesQuery->bindParam(1,$depoNameId);
		$depoSalesQuery->bindParam(2,$currentDate);
		$depoSalesQuery->execute();
		$total='';
		$depoId='';
		$i=1;
		while($row=$depoSalesQuery->fetch(PDO::FETCH_OBJ)){
			$total+=$row->total_price;
			$depoId=$row->depo_id;
			$i++;
		}

	// Exitst depo id in depo total sales table
		$selDepoTotalSales=$db->prepare("SELECT * FROM depo_total_sales WHERE depo_id=? AND date_time=?");
		$selDepoTotalSales->bindParam(1,$depoNameId);
		$selDepoTotalSales->bindParam(2,$currentDate);
		$selDepoTotalSales->execute();
		$selRow=$selDepoTotalSales->fetch(PDO::FETCH_ASSOC);
		$total_taka=$selRow['total_taka'];
		$today_sales_tk=$selRow['today_sales_tk'];
		$prev_total_sales_tk=$selRow['prev_total_sales_tk'];
		$exist_depo_id=$selRow['depo_id'];
		$today_sales_up=$today_sales_tk+$totalTaka; // Today sales taka for update query variable
		$total_taka_up=$prev_total_sales_tk+$today_sales_up; // Today sales total taka update query
		$intotal_taka=$total+$prev_total_sales_tk; // Today last balance variable it's use for depo_total_sales insert	

		if($exist_depo_id){ // if Exist depo id in same date then execute update query else insert query
			// Depo total sales update Query
				$depoTotalSaleUp=$db->prepare("UPDATE depo_total_sales SET today_sales_tk=?,total_taka=? WHERE depo_id=?");
				$depoTotalSaleUp->bindParam(1,$today_sales_up);
				$depoTotalSaleUp->bindParam(2,$total_taka_up);
				$depoTotalSaleUp->bindParam(3,$exist_depo_id);
				echo"update";	
		}else{
			// depo total sales insert query
				$totalSalesInsert=$db->prepare("INSERT INTO depo_total_sales SET depo_id=?,prev_total_sales_tk=?,today_sales_tk=?,total_taka=?,date_time=?");
				$totalSalesInsert->bindParam(1,$depoNameId);
				$totalSalesInsert->bindParam(2,$total_taka);
				$totalSalesInsert->bindParam(3,$total);
				$totalSalesInsert->bindParam(4,$intotal_taka);
				$totalSalesInsert->bindParam(5,$currentDate);
				$totalSalesInsert->execute();
				echo"Insert";
		}
	




?>