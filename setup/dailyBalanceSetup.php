<?php
	require("database.php");
	$depo_total_sales=$db->prepare("SELECT depo_total_sales.*,depo_total_sales.id AS depoTotalSalesId,depo.depo_name AS depoName,depo.id AS depoId FROM depo_total_sales LEFT JOIN depo ON depo_total_sales.depo_id=depo.id");
	$depo_total_sales->execute();
	$sl='';
	$data='';
	while($depoSalesRow=$depo_total_sales->fetch(PDO::FETCH_ASSOC)){
		$sl++;
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>{$depoSalesRow['depoName']}</td>
				<td>{$depoSalesRow['depo_total_sales_quantity']}</td>
				<td>{$depoSalesRow['today_sales_tk']}</td>
				<td>{$depoSalesRow['date_time']}</td>
				<td></td>
			</tr>
		";
	}


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
					<th>Total Sales</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table>
		</div>
	</div>
</div>