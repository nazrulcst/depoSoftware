<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=$obj->userLoginId();
	$depo=$db->prepare('SELECT * FROM depo WHERE user_id=?');
	$depo->bindParam(1,$userLoginId);
	$depo->execute();
	$fetchDepo=$depo->fetch(PDO::FETCH_ASSOC);
	$depoId=$fetchDepo['id'];
	$wholeSalesRecods=$db->prepare("SELECT * FROM whole_sales WHERE depo_id=?");
	$wholeSalesRecods->bindParam(1,$depoId);
	$wholeSalesRecods->execute();
	$rowCount=$wholeSalesRecods->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		$_SESSION['erMsg']="You are enter wrong values !";
	}
	$PackageSales=$db->prepare("SELECT *,whole_sales.id AS wID,depo.depo_name AS Dname,pack_name.package_name AS packName FROM whole_sales LEFT JOIN depo ON whole_sales.depo_id=depo.id LEFT JOIN pack_name ON whole_sales.pack_name_id=pack_name.id WHERE whole_sales.depo_id=? ORDER BY wID DESC LIMIT $startPage,$per_page_row");
	$PackageSales->bindParam(1,$depoId);
	$PackageSales->execute();
	$i='';
	$data='';
	while($wholeSalesRow=$PackageSales->fetch(PDO::FETCH_ASSOC)){
		$i++;
		$date=date('d-M-Y',strtotime($wholeSalesRow['whole_date']));
		$data.="
			<tr class='success'>
				<td>$i</td>
				<td>{$wholeSalesRow['Dname']}</td>
				<td>{$wholeSalesRow['total_item']}</td>
				<td>{$wholeSalesRow['packName']}</td>
				<td>{$wholeSalesRow['percentage']}</td>
				<td>{$wholeSalesRow['whole_sales_tk']}</td>
				<td>{$date}</td>
			</tr>
		";
	}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h3 class="text-green text-center">Today whole sales view</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2" style="margin-top:10px">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Quantity</th>
					<th>Package Name</th>
					<th>Percentage</th>
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
<?php
	// select from depo sales/today sales for total sales table report
		$depoSalesQuery=$db->prepare("SELECT * FROM  depo_sales WHERE depo_id=? AND date_time=?");
		$depoSalesQuery->bindParam(1,$depoNameId);
		$depoSalesQuery->bindParam(2,$currentDate);
		$depoSalesQuery->execute();
		$depoTotalSales='';
		$totalSalesQuantity='';
		$depoId='';
		$i=1;
		while($row=$depoSalesQuery->fetch(PDO::FETCH_OBJ)){
			$depoTotalSales+=$row->total_price;
			$totalSalesQuantity+=$row->quantity;
			$depoId=$row->depo_id;
			$i++;
		}
	// Exitst depo id in depo total sales table
		$selDepoTotalSales=$db->prepare("SELECT * FROM depo_total_sales WHERE depo_id=? AND date_time=?");
		$selDepoTotalSales->bindParam(1,$depoNameId);
		$selDepoTotalSales->bindParam(2,$currentDate);
		$selDepoTotalSales->execute();
		$selRow=$selDepoTotalSales->fetch(PDO::FETCH_ASSOC);
		$exist_depo_id=$selRow['depo_id'];	

		if($exist_depo_id){ // if Exist depo id in same date then execute update query else insert query
			// Depo total sales update Query
			$depoTotalSaleUp=$db->prepare("UPDATE depo_total_sales SET depo_total_sales_quantity=?,today_sales_tk=? WHERE depo_id=? AND date_time=?");
			$depoTotalSaleUp->bindParam(1,$totalSalesQuantity);
			$depoTotalSaleUp->bindParam(2,$depoTotalSales);
			$depoTotalSaleUp->bindParam(3,$exist_depo_id);
			$depoTotalSaleUp->bindParam(4,$currentDate);
			$totalDepoSalesUpdExe=$depoTotalSaleUp->execute();	
		}else{
			// depo total sales insert query
			$totalSalesInsert=$db->prepare("INSERT INTO depo_total_sales SET depo_id=?,depo_total_sales_quantity=?,today_sales_tk=?,date_time=?");
			$totalSalesInsert->bindParam(1,$depoNameId);
			$totalSalesInsert->bindParam(2,$totalSalesQuantity);
			$totalSalesInsert->bindParam(3,$depoTotalSales);
			$totalSalesInsert->bindParam(4,$currentDate);
			$totalDepoSalesInsExe=$totalSalesInsert->execute();	
		}
?>