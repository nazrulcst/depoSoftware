<?php
require('database.php');
include('necessaryClass/user.php');
if(!$obj->userName()){
	exit();
}

if(!isset($_GET['depoInfoEditId'])){
	exit();
}
$depoInfoEditId=$_GET['depoInfoEditId'];
$depoInfoEditQuery=$db->prepare("SELECT `depo`.*,`user`.`userType`,`user`.`status` FROM `depo` LEFT JOIN `user` ON `depo`.`user_id`=`user`.`id` WHERE `depo`.`id`=?");
$depoInfoEditQuery->bindParam(1,$depoInfoEditId);
$depoInfoEditQuery->execute();
$depoInfoEditRow=$depoInfoEditQuery->fetch(PDO::FETCH_ASSOC);
$mainDate=$depoInfoEditRow['birthDate'];
$modifyDate=date('d-m-Y',strtotime($mainDate));
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-info">Update depo infromation</h3>
			<hr>
			<?php
				if(isset($_SESSION['depoEditMsg'])){
					echo $_SESSION['depoEditMsg'];
					unset($_SESSION['depoEditMsg']);
				}
			?>
			<a href="index.php?page=depoView&folder=depoinfo" class="btn btn-primary pull-right"><span class='glyphicon glyphicon-chevron-left'></span>Back to home</a>
		</div>
	</div>
	<div class="row">
		<form action="action/depoInfoEditAction.php" method="post" enctype="multipart/form-data">
			<div class="col-sm-12">
				<div class="form-group">
		    		<p>Profile Picture :</p>
		    		<img name="onwerPicture" src="<?php echo 'depoPhoto/'.$depoInfoEditRow['picture'];?>" alt="picture" height="130px" width="210px" style="box-shadow: 0px 2px 6px 5px #888888;margin-bottom:5px">
		    		<input type="hidden" name="oldPicName" value="<?php echo $depoInfoEditRow['picture'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-12">
		  		<div class="form-group">
		  			<p>Change picture</p>
		  			<input type="file" name="newPicture">
		  		</div>
		  	</div>
			<div class="col-sm-12">
		  		<div class="form-group">
		    		<label for="depoName">Depo Name :</label>
		    		<pre class="text-green"><?php echo $depoInfoEditRow['depo_name'];?></pre>
		    		<input type="hidden" name="depoEditId" value="<?php echo $depoInfoEditRow['id'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="firstName">First Name :</label>
		    		<input type="text" name="firstName" class="form-control" id="firstName" placeholder="Write your first name..." value="<?php echo $depoInfoEditRow['first_name'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="lastName">Last Name :</label>
		    		<input type="text" name="lastName" class="form-control" id="lastName" placeholder="Write your last name..." value="<?php echo $depoInfoEditRow['last_name'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="birthDate">Date of Birth :</label>
		    		<input type="text" name="birthDate" class="form-control datepicker" id="birthDate" placeholder="mm/dd/yyyy" value="<?php echo $modifyDate;?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="phone">Phone :</label>
		    		<input type="number" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" value="<?php echo $depoInfoEditRow['phone'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="nid">NID :</label>
		    		<input type="text" name="nid" class="form-control" id="nid" placeholder="Enter your nid number" value="<?php echo $depoInfoEditRow['nid'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="email">Email :</label>
		    		<input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php echo $depoInfoEditRow['email'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="webSite">Website :</label>
		    		<input type="text" name="webSite" class="form-control" id="webSite" placeholder="Enter your web address (Optional)" value="<?php echo $depoInfoEditRow['website'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="upazilla">Upazilla :</label>
		    		<input type="text" name="upazilla" class="form-control" id="upazilla" placeholder="Enter your upzilla name" value="<?php echo $depoInfoEditRow['upazilla'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="district">District :</label>
		    		<input type="text" name="district" class="form-control" id="district" placeholder="Enter your district name" value="<?php echo $depoInfoEditRow['district'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="street">Street :</label>
		    		<input type="text" name="street" class="form-control" id="street" placeholder="Enter your street address" value="<?php echo $depoInfoEditRow['street'];?>">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="division">Division :</label>
		    		<select name="division" id="division" class="form-control">
		    			<option value="<?php echo $depoInfoEditRow['division'];?>"><?php echo $depoInfoEditRow['division'];?></option>
		    			<option value="dhaka">Dhaka</option>
		    			<option value="chittagong">Chittagong</option>
		    			<option value="rajshahi">Rajshahi</option>
		    			<option value="khulna">Khulna</option>
		    			<option value="barishal">Barishal</option>
		    			<option value="rangpur">Rangpur</option>
		    			<option value="sylhet">Sylhet</option>
		    			<option value="mymengshing">Mymenshing</option>
		    		</select>
		    	</div>
		  	</div>
		  	<div class="col-sm-12">
		  		<div class="form-group">
		    		<button type="submit" class="btn btn-primary btn-block" id="ok">Update & Save</button>
		    	</div>
		  	</div>
		</form>
	</div>	
</div>
<script src="last.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
	$("#ok").click(function(){
		$("#mainHide").fadeOut("fast");
	});
 	$(function(){
 		$('.datepicker').datepicker()
 	});
</script>
