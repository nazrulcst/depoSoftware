<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Add order book</h3>
			<hr>
			<?php
				if(isset($_SESSION['bookMsg'])){
					echo $_SESSION['bookMsg'];
					unset($_SESSION['bookMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:10px;">
			<form action="action/orderBookSetupAction.php" method="post">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="form-group">
						<label for="bookQuantity">Book Quantity</label>
						<input type="number" name="bookQuantity" id="bookQuantity" placeholder="Enter your book quantity" class="form-control" required="1">
					</div>
				</div>
				<div class="col-sm-10 col-sm-offset-1">
					<div class="form-group">
						<label for="totalCost">Total Cost</label>
						<input type="number" name="totalCost" id="totalCost" placeholder="Enter total cost" class="form-control" required="1">
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<a href="index.php?page=bookView&folder=officeUtilities" class="btn btn-warning btn-block">View Book</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>