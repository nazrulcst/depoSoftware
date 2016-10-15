<?php
require('database.php');
if(!isset($_GET['viewDepoId'])){
	exit('Delete Id Required!');
}
$depoDelId=$_GET['viewDepoId'];
$viewDepoinfo=$db->prepare("SELECT * FROM depo WHERE id=?");
$viewDepoinfo->bindParam(1,$depoDelId);
$viewDepoinfo->execute();
$viewDepoInfoRow=$viewDepoinfo->fetch(PDO::FETCH_OBJ);
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="col-xs-12">
				<h3 class="text text-center text-primary">View depo information</h3>
				<hr>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<img src="<?php echo 'depoPhoto/'.$viewDepoInfoRow->picture;?>" height="150px" width="220px" alt="profile picture" style="border:4px solid grey">
		</div>
		<div class="col-sm-8">
			<h3 class="text text-danger">Depo Name : <?php echo $viewDepoInfoRow->depo_name;?></h3>
			<h3 class="text text-danger">Mobile : <?php echo $viewDepoInfoRow->phone;?></h3>
			<h3 class="text text-danger">E-mail : <?php echo $viewDepoInfoRow->email;?></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h3>First Name:<p><?php echo $viewDepoInfoRow->first_name;?></p></h3>
		</div>
		<div class="col-sm-4">
			<h3>Last Name:<p><?php echo $viewDepoInfoRow->last_name;?></p></h3>
		</div>
		<div class="col-sm-4">
			<h3>Date of Birth:<p><?php echo $viewDepoInfoRow->birthDate;?></p></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h3>NID No:<p><?php echo $viewDepoInfoRow->nid;?></p></h3>
		</div>
		<div class="col-sm-4">
			<h3>Upazilla:<p><?php echo $viewDepoInfoRow->upazilla;?></p></h3>
		</div>
		<div class="col-sm-4">
			<h3>District:<p><?php echo $viewDepoInfoRow->district;?></p></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h3>District:<p><?php echo $viewDepoInfoRow->district;?></p></h3>
		</div>
		<div class="col-sm-4">
			<h3>Street/Location:<p><?php echo $viewDepoInfoRow->street;?></p></h3>
		</div>
		<div class="col-sm-4">
			<h3>WebSite:<p><a href=""><?php echo $viewDepoInfoRow->website;?></a></p></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-5" style="margin-top:10px">
			<a href="index.php?page=depoView&folder=depoinfo" class="btn btn-primary"><span class='glyphicon glyphicon-chevron-left'></span>Back to home</a>
		</div>
	</div>
</div>