<?php
require('database.php');
include_once("necessaryClass/user.php");
if(!$obj->userLoginId()){
	echo"<p class='alert alert-info'>You have no depo account !</p>";
	exit();
}
$user_id=$obj->userLoginId();//user id $user_id;
$depoViewQuery=$db->prepare("SELECT `depo`.*, `depo`.`id` AS `depo_main_id`,`user`.`id` FROM `depo` LEFT JOIN `user` ON `depo`.`user_id`=`user`.`id` WHERE `depo`.`user_id`=?");
$depoViewQuery->bindParam(1,$user_id);
$depoViewQuery->execute();
//$depoViewId=$depoViewQuery->fetch(PDO::FETCH_OBJ);
$sl="";
$data="";
while($depoViewId=$depoViewQuery->fetch(PDO::FETCH_OBJ)){
	$sl++;
	$data.="
		<tr class='success'>
			<td>$sl<a href='index.php?page=depoInformationView&folder=depoinfo&viewDepoId=$depoViewId->depo_main_id'>&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-eye-open'></span><a></td>
			<td>$depoViewId->depo_name</td>
			<td>$depoViewId->first_name</td>
			<td>$depoViewId->phone</td>
			<td>$depoViewId->email</td>
			<td>$depoViewId->district</td>
			<td>$depoViewId->street</td>
			<td>
				<a href='index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoViewId->depo_main_id' class='btn btn-primary'>
					<span class='glyphicon glyphicon-pencil'></span>
				</a>
			</td>
		</tr>
	";
}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-6 col-sm-12">
			<h3 class="text text-center text-info"><b>View your depo</b></h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-10 col-sm-offset-1">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Sl No</th>
						<th>Depo Name</th>
						<th>Owner Name</th>
						<th>Phone</th>
						<th>Email</th>
						<th>District</th>
						<th>Street</th>
						<th>Update</th>
					</tr>
				</thead>
				<tbody>					
					<td><?php echo $data; ?></td>
				</tbody>
			</table><hr>
		</div>
	</div>
</div>