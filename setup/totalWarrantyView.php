<?php
	require("database.php");
		$warRecods=$db->prepare("SELECT * FROM total_warranty");
		$warRecods->execute();
		$rowCount=$warRecods->rowCount();
		$per_page_row=10;
		$totalPage=ceil($rowCount/$per_page_row);
		$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
		$startPage=(int)($pageNumber-1)*$per_page_row;
		if($pageNumber<1){
			$startPage=(int)(-$pageNumber+1)*$per_page_row;
			echo"You have no recods in your database!";
		}
	$selectTotalWarranty=$db->prepare("SELECT total_warranty.*,depo.depo_name FROM total_warranty LEFT JOIN depo ON total_warranty.depo_id=depo.id ORDER BY warranty_date DESC LIMIT $startPage,$per_page_row");
	$selectTotalWarranty->execute();
	$data='';
	$sl='';
	while($warrantyRow=$selectTotalWarranty->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$date=date('d-M-Y',strtotime($warrantyRow->warranty_date));
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>$warrantyRow->depo_name</td>
				<td>$warrantyRow->warranty_quantity</td>
				<td class='text-green text-bold'>$warrantyRow->total_warranty_tk</td>
				<td>{$date}</td>
			</tr>
		";	
	} 
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">View all replacement product list</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:10px">
			<table class="table table-hover table-bordered">
				<thead class="text-green">
					<th>Sl</th>
					<th>Depo Name</th>
					<th>Total quantity</th>
					<th>Total taka</th>
					<th>Warranty date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table>
			<hr>
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