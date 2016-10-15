<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-info">Create new depo</h3>
			<hr>
			<?php
				if(isset($_SESSION['depoMsg'])){
					echo $_SESSION['depoMsg'];
					unset($_SESSION['depoMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<form action="action/depoInfoSetupAction.php" method="post" enctype="multipart/form-data">
			<div class="col-sm-12" style="margin-top:15px;">
		  		<div class="form-group">
		    		<label for="depoName">Depo Name :</label>
		    		<input type="text" name="depoName" class="form-control" id="depoName" placeholder="Write your depo name...">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="firstName">First Name :</label>
		    		<input type="text" name="firstName" class="form-control" id="firstName" placeholder="Write your first name...">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="lastName">Last Name :</label>
		    		<input type="text" name="lastName" class="form-control" id="lastName" placeholder="Write your last name...">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="birthDate">Date of Birth :</label>
		    		<input type="text" name="birthDate" class="form-control datepicker" id="birthDate" placeholder="mm/dd/yyyy">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="nid">NID :</label>
		    		<input type="text" name="nid" class="form-control" id="nid" placeholder="Enter your nid number">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="phone">Phone :</label>
		    		<input type="number" name="phone" class="form-control" id="phone" placeholder="Enter your phone number">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="email">Email :</label>
		    		<input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="webSite">Website :</label>
		    		<input type="text" name="webSite" class="form-control" id="webSite" placeholder="Enter your web address (Optional)">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="upazilla">Upazilla :</label>
		    		<input type="text" name="upazilla" class="form-control" id="upazilla" placeholder="Enter your upzilla name">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="district">District :</label>
		    		<input type="text" name="district" class="form-control" id="district" placeholder="Enter your district name">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="division">Division :</label>
		    		<select name="division" id="division" class="form-control">
		    			<option value="">Choice your division</option>
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
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="street">Street :</label>
		    		<input type="text" name="street" class="form-control" id="street" placeholder="Enter your street address">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="birthDate">Profile Picture :</label>
		    		<input type="file" name="ppicture">
		    	</div>
		  	</div>
		  	<div class="col-sm-12">
		  		<div class="form-group">
		    		<button type="submit" class="btn btn-primary btn-block hideMessages">Save</button>
		    	</div>
		  	</div>
		</form>
	</div>	
</div>
<script src="last.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
 	$(function(){
 		$('.datepicker').datepicker()
 	});
</script>
