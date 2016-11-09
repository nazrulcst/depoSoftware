<?php
	require('database.php');
	$userRecods=$db->prepare("SELECT * FROM user");
	$userRecods->execute();
	$totalRecods=$userRecods->rowCount();
	$perPage=12;
	$totalPage=ceil($totalRecods/$perPage);
	$pageNumber=(isset($_GET['pgNumber'])?$_GET['pgNumber']:$_GET['pgNumber']=1);
	$startPage=($pageNumber-1)*$perPage;
	if($pageNumber<1){
		$startPage=(-$pageNumber+1)*$perPage;
		echo"No recods found!";
	}
	$viewAlluser=$db->prepare("SELECT * FROM user LIMIT $startPage,$perPage");
	$viewAlluser->execute();
	$sl="";
	$data="";
	while($viewAllusrRow=$viewAlluser->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$data.="
			<tr class='success'>
				<td class='text-green text-bold'>$sl</td>
				<td>$viewAllusrRow->userName</td>
				<td>$viewAllusrRow->userType</td>
				<td>$viewAllusrRow->status</td>
				<td width='5%'>
					<a href='index.php?page=viewAlluser&folder=setup&activeId=$viewAllusrRow->id' class='btn btn-primary btn-sm'>active</a>
				</td>
				<td>
					<a href='index.php?page=viewAlluser&folder=setup&DeactiveId=$viewAllusrRow->id' class='btn btn-warning btn-sm'>Deactive</a>
				</td>
			</tr>
		";
	}
?>
<div class="container">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<h3 class="text-center text-green">View all users</h3>
			<hr>
			<?php
				if(isset($_GET['activeId'])){
					$activeId=$_GET['activeId'];
					echo "Are you sure active this user? <a href='action/userDeleteActiveDeactiveAction.php?staActive=$activeId'>Yes</a>&nbsp;&nbsp;
						<a href='index.php?page=viewAlluser&folder=setup'>No</a>
					";
				}elseif(isset($_GET['DeactiveId'])){
					$Deactive=$_GET['DeactiveId'];
					echo"
						Are you sure deactive this user? <a href='action/userDeleteActiveDeactiveAction.php?staDeactive=$Deactive'>Yes</a>&nbsp;&nbsp;
						<a href='index.php?page=viewAlluser&folder=setup'>No</a>
					";
				}
				if(isset($_SESSION['userStsMsg'])){
					echo $_SESSION['userStsMsg'];
					unset($_SESSION['userStsMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<table class="table table-hover table-bordered table-condensed">
				<thead class="text-green">
					<th width="5%">Sl No</th>
					<th>User Name</th>
					<th>User Type</th>
					<th>User Status</th>
					<th width="5%">Action</th>
				</thead>
				<tbody>
					<?php echo $data;?>
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
					echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>