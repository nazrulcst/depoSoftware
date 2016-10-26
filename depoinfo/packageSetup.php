<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10">
			<h3 class="text-center text-green">Add today package sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:20px">
			<form action="action/packageSetupAction.php" method="post">
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="productName">Product Name :</label>
						<select name="productName" id="productName" class="form-control">
							<option>Choice your product</option>

						</select>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="packageName">Package Name :</label>
						<select name="packageName" id="packageName" class="form-control">
							<option>Choice your package</option>
							<option value="24 %">Lowest offer</option>	
							<option value="72 %">Middle offer</option>	
							<option value="500 %">Largest offer</option>	
						</select>
					</div>
					</div>
				<div class="col-sm-10 col-sm-offset-1">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Add</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>