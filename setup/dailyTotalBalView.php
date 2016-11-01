<?php
	require("database.php");
	$depo_total_sales=$db->prepare("SELECT depo_total_sales.*,depo_total_sales.id AS depoTotalSalesId,depo.depo_name AS depoName,depo.id AS depoId FROM depo_total_sales LEFT JOIN depo ON depo_total_sales.depo_id=depo.id");
	$depo_total_sales->execute();
	$inc='';
	$data='';
	while($depo_tatal_sales_row=$depo_total_sales->fetch(PDO::FETCH_ASSOC)){
		$inc++;
		$data.="
			<tr class='success'>
				<td>$inc</td>
				<td>{$depo_tatal_sales_row['depoName']}</td>
				<td>{$depo_tatal_sales_row['depo_total_sales_quantity']}</td>
				<td>{$depo_tatal_sales_row['today_sales_tk']}</td>
				<td>{$depo_tatal_sales_row['date_time']}</td>
			</tr>
		";
	};
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Daily sales view</h3>
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
</div>