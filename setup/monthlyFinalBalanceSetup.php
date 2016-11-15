<?php
	date_default_timezone_set('Asia/Dhaka');
	require('database.php');
	include_once('necessaryClass/user.php');
	if(!$obj->userType()){
		exit();
	}
	$curDate=date('Y-m-d');
	$strcurDate=strtotime($curDate); 
	$first_day_of_month = date('Y-m-01');
	$strfirsDayofmonth=strtotime($first_day_of_month);
	$last_day_of_month = date('Y-m-t');
	$strlastDayofmonth=strtotime($last_day_of_month);
// Final balance table below working the 
	// Per monthly workshop data adding query
	$perMonthSel=$db->prepare("SELECT * FROM workshop_loss WHERE enter_date >= DATE_SUB(CURRENT_DATE,INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) AND enter_date <= LAST_DAY(CURRENT_DATE)");
	$perMonthSel->execute();
	$count=$perMonthSel->rowCount();
	$increment='';
	$quantityPermonth='';
	$total_pricePerMonth='';
	while($perMonthRow=$perMonthSel->fetch(PDO::FETCH_ASSOC)){
		$increment++;
		$quantityPermonth+=$perMonthRow['quantity'];
		$total_pricePerMonth+=$perMonthRow['total_price'];
	}
	
	// select product table all data for per month final account
		$productPerMonth=$db->prepare("SELECT * FROM products WHERE entry_date >= DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY)
   			AND entry_date <=  LAST_DAY(CURRENT_DATE)");
		$productPerMonth->execute();
		$proTotalQuantityPerMonth='';
		$proTotalTakaPerMonth='';
		while($proRow=$productPerMonth->fetch(PDO::FETCH_ASSOC)){
			$increment++;
			$proTotalQuantityPerMonth+=$proRow['quantity'];
			$proTotalTakaPerMonth+=$proRow['total_price'];
		}
	// select depo_store table all data for per month final account
		$dStorePerMonth=$db->prepare("SELECT * FROM depo_store WHERE store_date >= DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY)
   			AND store_date <=  LAST_DAY(CURRENT_DATE)");
		$dStorePerMonth->execute();
		$StoreTotalQuantity='';
		$StoreTotalTaka='';
		while($dStoreRow=$dStorePerMonth->fetch(PDO::FETCH_ASSOC)){
			$increment++;
			$StoreTotalQuantity+=$dStoreRow['pro_quantity'];
			$StoreTotalTaka+=$dStoreRow['total_price'];
		}	
	// select total salse table data for final balance table
		$total_salse_per_month=$db->prepare("SELECT * FROM depo_total_sales WHERE date_time >=DATE_SUB(CURRENT_DATE,INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) AND date_time <=LAST_DAY(CURRENT_DATE)");
		$total_salse_per_month->execute();
		$totalRowCount=$total_salse_per_month->rowCount();
		$total_sales_quantity='';
		$total_sales_taka='';
		while($salesRow=$total_salse_per_month->fetch(PDO::FETCH_ASSOC)){
			$increment++;
			$total_sales_quantity+=$salesRow['depo_total_sales_quantity'];
			$total_sales_taka+=$salesRow['today_sales_tk'];
		}
	// Insert final balance table data Query
		$currentMonthTotalQuantity=$proTotalQuantityPerMonth+$StoreTotalQuantity;//full month Quantity
		$curentMonthTotalCost=$proTotalTakaPerMonth+$StoreTotalTaka;//full month taka
		$totalProtif=$curentMonthTotalCost-$total_pricePerMonth;//full month loss
	//Select final balance table data
		$finalBalSel=$db->prepare("SELECT * FROM final_balance WHERE final_bal_date=?");
		$finalBalSel->bindParam(1,$curDate);
		$finalBalSel->execute();
		$finalBalRow=$finalBalSel->fetch(PDO::FETCH_ASSOC);
		$existFinalBalDate=$finalBalRow['final_bal_date'];
		$existFinalBalId=$finalBalRow['id'];
		$existFinalDateStr=strtotime($existFinalBalDate);
		// Checking the condition
		if($curDate==$last_day_of_month){
			if($existFinalDateStr==$strcurDate){
				$update=$db->prepare("UPDATE final_balance SET total_pro_quantity=?,total_pro_taka=?,total_store_quantity=?,total_store_taka=?,total_sales_quantity=?,total_sales_taka=?,total_damage_quantity=?,total_damage_tk=?,month_total_quantity=?,month_total_cost=?,total_profit=? WHERE final_bal_date=?");
				$update->bindParam(1,$proTotalQuantityPerMonth);
				$update->bindParam(2,$proTotalTakaPerMonth);
				$update->bindParam(3,$StoreTotalQuantity);
				$update->bindParam(4,$StoreTotalTaka);
				$update->bindParam(5,$total_sales_quantity);
				$update->bindParam(6,$total_sales_taka);
				$update->bindParam(7,$quantityPermonth);
				$update->bindParam(8,$total_pricePerMonth);
				$update->bindParam(9,$currentMonthTotalQuantity);
				$update->bindParam(10,$curentMonthTotalCost);
				$update->bindParam(11,$totalProtif);
				$update->bindParam(12,$curDate);
				$update->execute();
				$_SESSION['fbal']="<p class='alert alert-success'>Update your balance information</p>";
			}else{
				$insert=$db->prepare("INSERT INTO final_balance SET total_pro_quantity=?,total_pro_taka=?,total_store_quantity=?,total_store_taka=?,total_sales_quantity=?,total_sales_taka=?,total_damage_quantity=?,total_damage_tk=?,month_total_quantity=?,month_total_cost=?,total_profit=?,final_bal_date=?");
				$insert->bindParam(1,$proTotalQuantityPerMonth);
				$insert->bindParam(2,$proTotalTakaPerMonth);
				$insert->bindParam(3,$StoreTotalQuantity);
				$insert->bindParam(4,$StoreTotalTaka);
				$insert->bindParam(5,$total_sales_quantity);
				$insert->bindParam(6,$total_sales_taka);
				$insert->bindParam(7,$quantityPermonth);
				$insert->bindParam(8,$total_pricePerMonth);
				$insert->bindParam(9,$currentMonthTotalQuantity);
				$insert->bindParam(10,$curentMonthTotalCost);
				$insert->bindParam(11,$totalProtif);
				$insert->bindParam(12,$curDate);
				$insert->execute();
				$_SESSION['fbal']="<p class='alert alert-success'>Update your balance information</p>";
			}	
		}else{
			$_SESSION['fbal']="<p class='alert alert-warning'>Don't match date !</p>";
		}
		// select final table data for view all final balance
		$finalRecods=$db->prepare("SELECT * FROM final_balance");
		$finalRecods->execute();
		$rowCount=$finalRecods->rowCount();
		$per_page_row=10;
		$totalPage=ceil($rowCount/$per_page_row);
		$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
		$startPage=(int)($pageNumber-1)*$per_page_row;
		if($pageNumber<1){
			$startPage=(int)(-$pageNumber+1)*$per_page_row;
			echo"You have no recods in your database!";
		}
		$selFinalBal=$db->prepare("SELECT * FROM final_balance ORDER BY final_bal_date DESC LIMIT $startPage,$per_page_row");
		$selFinalBal->execute();
		$sl='';
		$data='';
		while($finalBalRow=$selFinalBal->fetch(PDO::FETCH_OBJ)){
			$sl++;
			$date=date('d-M-Y',strtotime($finalBalRow->final_bal_date));
			$data.="
				<tr class='success'>
					<td class='text-green bold'>$sl</td>
					<td>$finalBalRow->total_pro_quantity</td>
					<td>$finalBalRow->total_pro_taka</td>
					<td>$finalBalRow->total_sales_quantity</td>
					<td>$finalBalRow->total_sales_taka</td>
					<td>$finalBalRow->total_damage_quantity</td>
					<td>$finalBalRow->total_damage_tk</td>
					<td class='text-green text-bold'>$finalBalRow->month_total_quantity</td>
					<td class='text-green text-bold'>$finalBalRow->month_total_cost</td>
					<td>$date</td>
					<td></td>
				</tr>
			";
		}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="text-center text-green">View all monthly balance</h3>
			<hr>
			<?php
				if(isset($_SESSION['fbal'])){
					echo $_SESSION['fbal'];
					unset($_SESSION['fbal']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-sm-8 col-md-12">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead class="text-green">
					<th>Sl</th>
					<th>Product Pcs</th>
					<th>Product Taka</th>
					<th>Total sales pcs</th>
					<th>Total sales tk</th>
					<th>Damage pcs</th>
					<th>Damage Tk</th>
					<th>Total stock Pcs</th>
					<th>Total stock Tk</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table><hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 text-center" style="margin-top:10px">
			<?php
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=monthlyFinalBalanceSetup&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=monthlyFinalBalanceSetup&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=monthlyFinalBalanceSetup&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=monthlyFinalBalanceSetup&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=monthlyFinalBalanceSetup&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=monthlyFinalBalanceSetup&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>