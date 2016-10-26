<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Create new package offer</h3>
			<hr>
			<?php
				if(isset($_SESSION['offMsg'])){
					echo $_SESSION['offMsg'];
					unset($_SESSION['offMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<form action="action/createOfferNameAction.php" method="post">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="packageName">Package Name :</label>
						<input type="text" name="packageName" id="packageName" placeholder="Enter package name" class="form-control">
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="percentage">Percentage Off :</label>
						<input type="number" name="percentage" id="percentage" placeholder="Enter a value without %" class="form-control">
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Add package</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>