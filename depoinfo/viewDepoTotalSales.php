<?php
	date_default_timezone_set('Asia/Dhaka');
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=$obj->userLoginId();
	$currentDate=date('Y-m-d');
	$depo=$db->prepare('SELECT * FROM depo WHERE user_id=?');
	$depo->bindParam(1,$userLoginId);
	$depo->execute();
	$fetchDepo=$depo->fetch(PDO::FETCH_ASSOC);
	$depoId=$fetchDepo['id'];

	$totalSalesRecod=$db->prepare("SELECT * FROM depo_total_sales WHERE depo_id=?");
	$totalSalesRecod->bindParam(1,$depoId);
	$totalSalesRecod->execute();
	$rowCount=$totalSalesRecod->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		echo "No recods found!";
	}

	$depoTotalSales=$db->prepare("SELECT *,depo.depo_name AS dpName FROM depo_total_sales LEFT JOIN depo ON depo_total_sales.depo_id=depo.id WHERE depo_id=? ORDER BY date_time DESC LIMIT $startPage,$per_page_row");
	$depoTotalSales->bindParam(1,$depoId);
	$depoTotalSales->execute();
	$i='';
	$data='';
	while($dpTotalSalesRow=$depoTotalSales->fetch(PDO::FETCH_ASSOC)){
		$i++;
		$date=date('d-M-Y',strtotime($dpTotalSalesRow['date_time']));
		$data.="
			<tr class='success'>
				<td>$i</td>
				<td>{$dpTotalSalesRow['dpName']}</td>
				<td>{$dpTotalSalesRow['depo_total_sales_quantity']}</td>
				<td>{$dpTotalSalesRow['today_sales_tk']}</td>
				<td>{$date}</td>
			</tr>
		";
	}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h3 class="text-green text-center">Depo total sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2" style="margin-top:10px">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Total Quantity</th>
					<th>Total Sales Taka</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>	
			</table><hr>
		</div>
		<div class="col-sm-10 col-sm-offset-1 text-center" style="margin-top:10px">
			<?php
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=viewDepoTotalSales&folder=depoinfo&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=viewDepoTotalSales&folder=depoinfo&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=viewDepoTotalSales&folder=depoinfo&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=viewDepoTotalSales&folder=depoinfo&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=viewDepoTotalSales&folder=depoinfo&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=viewDepoTotalSales&folder=depoinfo&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>