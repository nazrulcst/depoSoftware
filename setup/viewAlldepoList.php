<?php
	require("database.php");
	include_once("necessaryClass/user.php");
	if(!$obj->userType()){
		//header("Location:index.php");
		exit("You have no right access this option, please go away");
	}
$obj->userType();

$pagination=$db->prepare("SELECT * FROM depo");
$pagination->execute();
$totalRow=$pagination->rowCount();
$perPageDepoList=5;
$totalPage=ceil($totalRow/$perPageDepoList);
$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:$_GET['pgNumber']=1);
$start=($pageNumber-1)*$perPageDepoList;
if($pageNumber<1){
	$start=(-$pageNumber+1)*$perPageDepoList;
	echo"Recods not found !";
}
$viewAllDepo=$db->prepare("SELECT * FROM depo LIMIT $start,$perPageDepoList");
$viewAllDepo->execute();
$sl='';
$data='';
while($viewAllDepoRow=$viewAllDepo->fetch(PDO::FETCH_OBJ)){
	$sl++;
	$data.="
		<tr class='success'>
			<td class='text-green'>$sl</td>
			<td>$viewAllDepoRow->depo_name</td>
			<td>$viewAllDepoRow->first_name</td>
			<td>$viewAllDepoRow->phone</td>
			<td>$viewAllDepoRow->email</td>
			<td>$viewAllDepoRow->nid</td>
			<td>$viewAllDepoRow->upazilla</td>
			<td>$viewAllDepoRow->street</td>
			<td>$viewAllDepoRow->district</td>
			<td>$viewAllDepoRow->division</td>
			<td>$viewAllDepoRow->uploader</td>
		</tr>	
	";
}


?>
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">View all depo list</h3>
			<hr>
			<?php
				if(isset($_SESSION['delDepoMsg'])){
					echo $_SESSION['delDepoMsg'];
					unset($_SESSION['delDepoMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Onwe Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th>NID</th>
					<th>Upazilla</th>
					<th>Street</th>
					<th>District</th>
					<th>Division</th>
					<th>Uploader</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table><hr>
		</div>
	</div>
	<div class="row"><!--Pagination Section start here-->
		<div class="col-xs-8 col-xs-offset-2 text-center" style="margin-top:10px">
			<?php
				$pagePre=$pageNumber-1;
				$pageNext=$pageNumber+1;
				if($pagePre==0){//checking the previous button
					echo"<a href='index.php?page=viewAlldepoList&folder=setup&pgNumber={$pagePre}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}else{
					echo"<a href='index.php?page=viewAlldepoList&folder=setup&pgNumber={$pagePre}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}
				
				if($pageNumber <= $totalPage){
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
								echo "<a href='index.php?page=viewAlldepoList&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>".'&nbsp;';
						}else{
							echo "<a href='index.php?page=viewAlldepoList&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>".'&nbsp;';
						}
					}
				}else{
					echo"Page not found ! 404";
				}
				if($pageNumber==$totalPage){//checking the next button
					echo"&nbsp;&nbsp;<a class='btn btn-primary btn-sm disabled'
						href='index.php?page=viewAlldepoList&folder=setup&pgNumber={$pageNext}'>Next
							<span class='glyphicon glyphicon-chevron-right'></span>
						</a>";// Next button
				}else{
					echo"&nbsp;&nbsp;<a href='index.php?page=viewAlldepoList&folder=setup&pgNumber={$pageNext}'
					 class='btn btn-primary btn-sm'>Next
					 	<span class='glyphicon glyphicon-chevron-right'></span>
					 </a>";// Next button
				}
			?>	
		</div>
	</div><!--/Pagination Section End here-->
</div>