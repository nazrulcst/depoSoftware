<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center text-green">Create new user</h3>
			<hr>
			<?php
				if(isset($_SESSION['loginMsg'])){
					echo $_SESSION['loginMsg'];
					unset($_SESSION['loginMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px;">
			<form action="action/userCreateSetupAction.php" method="post">
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="userName">User Name :</label>
		    		<input type="text" name="userName" class="form-control" id="userName" placeholder="Write your user name" required="1">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="userType">User type :</label>
		    		<select name="userType" id="userType" class="form-control" required="1">
		    			<option value="">Choice your user type</option>
		    			<option value="superadmin">Super Admin</option>
		    			<option value="admin">Admin</option>
		    			<option value="employee">Employee</option>
		    			<option value="userNormal">User</option>
		    		</select>
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="userPass">Password :</label>
		    		<input type="password" name="userPass" class="form-control" id="userPass" placeholder="Enter your password" required="1">
		    	</div>
		  	</div>
		  	<div class="col-sm-6">
		  		<div class="form-group">
		    		<label for="userConfirmPass">Confirm Password :</label>
		    		<input type="password" name="userConfirmPass" class="form-control" id="userConfirmPass" placeholder="Confirm password" required="1">
		    	</div>
		  	</div>
		  	<div class="col-sm-12">
		  		<div class="form-group">
		    		<label for="status">Status :</label>
		    		<select id="status" name="status" class="form-control" required="1">
		    			<option>Choice user activity (Active or Deactive)</option>
		    			<option value="active">Active user</option>
		    			<option value="deactive">Deactive user</option>
		    		</select>
		    	</div>
		  	</div>
		  	<div class="col-sm-12">
		  		<div class="form-group">
		    		<button type="submit" class="btn btn-primary btn-block">Submit</button>
		    	</div>
		  	</div>
			</form>
		</div>
	</div>	
</div>