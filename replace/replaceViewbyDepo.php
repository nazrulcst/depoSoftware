<?php
	date_default_timezone_set('Asia/Dhaka');
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=(int)$obj->userLoginId();
	$warRecodrs=$db->prepare("SELECT * FROM warranty");
	$warRecodrs->execute();
	$rowCount=$warRecodrs->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		$_SESSION['erMsg']="You are enter wrong values !";
	}
	$selWarranty=$db->prepare("SELECT *,warranty.quantity AS repQuantity,warranty.total_price AS repPrice,depo.depo_name AS depoName,products.pro_name AS proName FROM warranty LEFT JOIN depo ON warranty.depo_id=depo.id LEFT JOIN user ON depo.user_id=user.id LEFT JOIN products ON warranty.pro_id=products.id WHERE depo.user_id=? LIMIT $startPage,$per_page_row");
	$selWarranty->bindParam(1,$userLoginId);
	$selWarranty->execute();
	$sl='';
	$data='';
	while($warRow=$selWarranty->fetch(PDO::FETCH_ASSOC)){
		$sl++;
		$date=date('d-M-Y',strtotime($warRow['replace_date']));
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>{$warRow['depoName']}</td>
				<td>{$warRow['proName']}</td>
				<td>{$warRow['repQuantity']}</td>
				<td>{$warRow['repPrice']}</td>
				<td>{$date}</td>
			</tr>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Your replacement products</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Total Tk</th>
					<th>Date</th>
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
					echo"<a href='index.php?page=replaceViewbyDepo&folder=replace&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=replaceViewbyDepo&folder=replace&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=replaceViewbyDepo&folder=replace&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=replaceViewbyDepo&folder=replace&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=replaceViewbyDepo&folder=replace&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=replaceViewbyDepo&folder=replace&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>