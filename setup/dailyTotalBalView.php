<?php
	require("database.php");
	$depoTotalSalesRecods=$db->prepare("SELECT * FROM depo_total_sales");
	$depoTotalSalesRecods->bindParam(1,$depoId);
	$depoTotalSalesRecods->execute();
	$rowCount=$depoTotalSalesRecods->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		echo"You have no recods in your database!";
	}
	$depo_total_sales=$db->prepare("SELECT depo_total_sales.*,depo_total_sales.id AS depoTotalSalesId,depo.depo_name AS depoName,depo.id AS depoId FROM depo_total_sales LEFT JOIN depo ON depo_total_sales.depo_id=depo.id ORDER BY date_time DESC LIMIT $startPage,$per_page_row");
	$depo_total_sales->execute();
	$inc='';
	$data='';
	while($depo_tatal_sales_row=$depo_total_sales->fetch(PDO::FETCH_ASSOC)){
		$inc++;
		$date=date('d-M-Y',strtotime($depo_tatal_sales_row['date_time']));
		$data.="
			<tr class='success'>
				<td>$inc</td>
				<td>{$depo_tatal_sales_row['depoName']}</td>
				<td>{$depo_tatal_sales_row['depo_total_sales_quantity']}</td>
				<td>{$depo_tatal_sales_row['today_sales_tk']}</td>
				<td>{$date}</td>
			</tr>
		";
	};
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Daily general sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-hover">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>General Sales</th>
					<th>Total Sales Taka</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data; ?>
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
					echo"<a href='index.php?page=dailyTotalBalView&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=dailyTotalBalView&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=dailyTotalBalView&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=dailyTotalBalView&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=dailyTotalBalView&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=dailyTotalBalView&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>