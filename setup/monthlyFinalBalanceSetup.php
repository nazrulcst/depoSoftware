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

	// select total salse table data for final balance table
		$total_salse_per_month=$db->prepare("SELECT * FROM depo_total_sales WHERE date_time >=DATE_SUB(CURRENT_DATE,INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) AND date_time <=LAST_DAY(CURRENT_DATE)");
		$total_salse_per_month->execute();
		$totalRowCount=$total_salse_per_month->rowCount();
		$total_sales_taka='';
		$total_sales_quantity='';
		while($salesRow=$total_salse_per_month->fetch(PDO::FETCH_ASSOC)){
			$increment++;
			$total_sales_quantity=$salesRow['depo_total_sales_quantity'];
			$total_sales_taka+=$salesRow['today_sales_tk'];
		}
	// select package all data for final balance table
		$totalPackageSel=$db->prepare("SELECT * FROM package WHERE package_date >=DATE_SUB(CURRENT_DATE,INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) AND package_date <=LAST_DAY(CURRENT_DATE)");
		$totalPackageSel->execute();
		$packageRow=$totalPackageSel->fetch(PDO::FETCH_ASSOC);
		$totalPackageQuantity=$packageRow['total_item'];	
		$totalPackageTaka=$packageRow['total_sales_taka'];	
	// Insert final balance table data Query
		$curentMonthTotalCost=$total_sales_taka+$proTotalTakaPerMonth+$totalPackageTaka;//full month taka
		$currentMonthTotalQuantity=$proTotalQuantityPerMonth+$total_sales_quantity+$totalPackageQuantity;//full month Quantity
		$totalProtif=$curentMonthTotalCost-$total_pricePerMonth;//full month loss
		// Checking the condition
		if($curDate==$last_day_of_month){
			$insert=$db->prepare("INSERT INTO final_balance SET total_pro_quantity=?,total_pro_taka=?,total_sales_quantity=?,total_sales_taka=?,total_damage_quantity=?,total_damage_tk=?,month_total_quantity=?,month_total_cost=?,total_profit=?,final_bal_date=?");
			$insert->bindParam(1,$proTotalQuantityPerMonth);
			$insert->bindParam(2,$proTotalTakaPerMonth);
			$insert->bindParam(3,$total_sales_quantity);
			$insert->bindParam(4,$total_sales_taka);
			$insert->bindParam(5,$quantityPermonth);
			$insert->bindParam(6,$total_pricePerMonth);
			$insert->bindParam(7,$currentMonthTotalQuantity);
			$insert->bindParam(8,$curentMonthTotalCost);
			$insert->bindParam(9,$totalProtif);
			$insert->bindParam(10,$curDate);
			$insert->execute();
			$_SESSION['fbal']="<p class='alert alert-success'>Update your balance information</p>";
		}else{
			$_SESSION['fbal']="<p class='alert alert-warning'>Don't match date !</p>";
		}	

		// select final table data for view all final balance
		$selFinalBal=$db->prepare("SELECT * FROM final_balance");
		$selFinalBal->execute();
		$sl='';
		$data='';
		while($finalBalRow=$selFinalBal->fetch(PDO::FETCH_OBJ)){
			$sl++;
			$data.="
				<tr class='success'>
					<td>$sl</td>
					<td>$finalBalRow->total_pro_quantity</td>
					<td>$finalBalRow->total_pro_taka</td>
					<td>$finalBalRow->total_sales_quantity</td>
					<td>$finalBalRow->total_sales_taka</td>
					<td>$finalBalRow->total_damage_quantity</td>
					<td>$finalBalRow->total_damage_tk</td>
					<td>$finalBalRow->month_total_quantity</td>
					<td>$finalBalRow->month_total_quantity</td>
					<td>$finalBalRow->month_total_cost</td>
					<td>$finalBalRow->total_profit</td>
					<td>$finalBalRow->final_bal_date</td>
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
			<table class="table table-hover table-bordered table-striped table-condensend">
				<thead class="text-green">
					<th>Sl</th>
					<th>proQuantity</th>
					<th>proPrice</th>
					<th>TotalSalseQuan</th>
					<th>TotalSalseTaka</th>
					<th>DamageQuan</th>
					<th>DamageTaka</th>
					<th>MonthlyQuan</th>
					<th>MonthlyTaka</th>
					<th>Monthlycost</th>
					<th>TotalProfit</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table><hr>
		</div>
	</div>
</div>