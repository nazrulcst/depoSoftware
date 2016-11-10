<?php
	require("database.php");
	$depoTotalSales=$db->prepare("SELECT * FROM depo_total_sales");
	$depoTotalSales->bindParam(1,$depoId);
	$depoTotalSales->execute();
	$rowCount=$depoTotalSales->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		echo"You have no recods in your database!";
	}
	$depoTotalQuery=$db->prepare("SELECT *,depo.depo_name AS depoName FROM depo_total_sales LEFT JOIN depo ON depo_total_sales.depo_id=depo.id ORDER BY date_time DESC LIMIT $startPage,$per_page_row");
	$depoTotalQuery->execute();
	$inc='';
	$data='';
	while($depoTotalSalesRow=$depoTotalQuery->fetch(PDO::FETCH_ASSOC)){
		$inc++;
		$date=date('d-M-Y',strtotime($depoTotalSalesRow['date_time']));
		$data.="
			<tr class='success'>
				<td>$inc</td>
				<td>{$depoTotalSalesRow['depoName']}</td>
				<td>{$depoTotalSalesRow['depo_total_sales_quantity']}</td>
				<td>{$depoTotalSalesRow['today_sales_tk']}</td>
				<td>{$date}</td>
			</tr>
		";
	};
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Daily depo total sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<table class="table table-hover">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Quantity</th>
					<th>Total Sales Tk</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data; ?>
				</tbody>
			</table><hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center" style="margin-top:10px">
			<?php
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=depoTotalBalSheet&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=depoTotalBalSheet&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=depoTotalBalSheet&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=depoTotalBalSheet&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=depoTotalBalSheet&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=depoTotalBalSheet&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>