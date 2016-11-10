<?php
	require("database.php");
	$wholeSalesRecods=$db->prepare("SELECT * FROM whole_sales");
	$wholeSalesRecods->bindParam(1,$depoId);
	$wholeSalesRecods->execute();
	$rowCount=$wholeSalesRecods->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		echo"You have no recods in your database!";
	}
	$whole_sales=$db->prepare("SELECT *,depo.depo_name AS depoName,pack_name.package_name AS pName FROM whole_sales LEFT JOIN depo ON whole_sales.depo_id=depo.id LEFT JOIN pack_name ON whole_sales.pack_name_id=pack_name.id ORDER BY whole_date DESC LIMIT $startPage,$per_page_row");
	$whole_sales->execute();
	$inc='';
	$data='';
	while($wholeRow=$whole_sales->fetch(PDO::FETCH_ASSOC)){
		$inc++;
		$date=date('d-M-Y',strtotime($wholeRow['whole_date']));
		$data.="
			<tr class='success'>
				<td>$inc</td>
				<td>{$wholeRow['depoName']}</td>
				<td>{$wholeRow['pName']}</td>
				<td>{$wholeRow['total_item']}</td>
				<td>{$wholeRow['percentage']}</td>
				<td>{$wholeRow['whole_sales_tk']}</td>
				<td>{$date}</td>
			</tr>
		";
	};
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Daily whole sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-hover">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Package Name</th>
					<th>Quantity</th>
					<th>Percentage</th>
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
		<div class="col-sm-10 col-sm-offset-1 text-center" style="margin-top:10px">
			<?php
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=wholeSalesView&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=wholeSalesView&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=wholeSalesView&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=wholeSalesView&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=wholeSalesView&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=wholeSalesView&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>