<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=$obj->userLoginId();
	$depo=$db->prepare('SELECT * FROM depo WHERE user_id=?');
	$depo->bindParam(1,$userLoginId);
	$depo->execute();
	$fetchDepo=$depo->fetch(PDO::FETCH_ASSOC);
	$depoId=$fetchDepo['id'];

	$depoSalesRecods=$db->prepare("SELECT * FROM depo_sales WHERE depo_id=?");
	$depoSalesRecods->bindParam(1,$depoId);
	$depoSalesRecods->execute();
	$rowCount=$depoSalesRecods->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		$_SESSION['erMsg']="You are enter wrong values !";
	}

	$depo_sales=$db->prepare("SELECT *,depo_sales.id AS sID,depo_sales.pro_price AS sPrice, depo_sales.quantity AS sQuan, depo_sales.total_price AS sTotal,depo.depo_name AS dName,products.pro_name AS Pname FROM depo_sales LEFT JOIN depo ON depo_sales.depo_id=depo.id LEFT JOIN products ON depo_sales.pro_id=products.id WHERE depo_sales.depo_id=? ORDER BY sID DESC LIMIT $startPage,$per_page_row");
	$depo_sales->bindParam(1,$depoId);
	$depo_sales->execute();
	$i='';
	$data='';
	while($salesRow=$depo_sales->fetch(PDO::FETCH_ASSOC)){
		$i++;
		$date=date('d-M-Y',strtotime($salesRow['date_time']));
		$data.="
			<tr class='success'>
				<td>$i</td>
				<td>{$salesRow['dName']}</td>
				<td>{$salesRow['Pname']}</td>
				<td>{$salesRow['sPrice']}</td>
				<td>{$salesRow['sQuan']}</td>
				<td>{$salesRow['sTotal']}</td>
				<td>{$date}</td>
			</tr>
		";
	}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h3 class="text-green text-center">Today sales view</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2" style="margin-top:10px">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Product Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Sales Tk</th>
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
					echo"<a href='index.php?page=viewTodaySales&folder=depoinfo&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=viewTodaySales&folder=depoinfo&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=viewTodaySales&folder=depoinfo&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=viewTodaySales&folder=depoinfo&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=viewTodaySales&folder=depoinfo&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=viewTodaySales&folder=depoinfo&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>