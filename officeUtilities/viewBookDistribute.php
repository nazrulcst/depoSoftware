<?php
	require('database.php');
	$bookDist=$db->prepare("SELECT * FROM book_distribution");
	$bookDist->execute();
	$rowCount=$bookDist->rowCount();
	$per_page_row=12;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		echo"Page not found !";
	}
	$selectBookDist=$db->prepare("SELECT *,depo.depo_name AS depoName FROM book_distribution LEFT JOIN depo ON book_distribution.depo_id=depo.id ORDER BY enter_date DESC LIMIT $startPage,$per_page_row");
	$selectBookDist->execute();
	$inc='';
	$data='';
	while($fetchRow=$selectBookDist->fetch(PDO::FETCH_ASSOC)){
		$inc++;	
		$date=date('d-M-Y',strtotime($fetchRow['enter_date']));
		$data.="
			<tr class='success'>
				<td>{$inc}</td>
				<td>{$fetchRow['depoName']}</td>
				<td>{$fetchRow['book_number']}</td>
				<td>{$date}</td>
			</tr>
		";
	}
?>
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-green text-center">View all depo order book</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Book Number</th>
					<th width="5%">Date</th>
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
					echo"<a href='index.php?page=viewBookDistribute&folder=officeUtilities&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=viewBookDistribute&folder=officeUtilities&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=viewBookDistribute&folder=officeUtilities&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=viewBookDistribute&folder=officeUtilities&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=viewBookDistribute&folder=officeUtilities&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=viewBookDistribute&folder=officeUtilities&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>