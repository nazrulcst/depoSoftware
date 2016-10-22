<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$loginUserId=$obj->userLoginId();
	$selAllProName=$db->prepare("SELECT * FROM products");
	$selAllProName->execute();
	$proName='';
	$sl='';
	while($proRow=$selAllProName->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$proName.="
			<option value='$proRow->id'>$proRow->pro_name</option>
		";
	}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Workshop replacement product</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:25px;">
			<form action="action/workShopSetupAction.php" method="post" class="workShopForm">
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="depo">Product Name :</label>
						<select name="ProName" class="form-control" id="ProName">
							<option value="">Select product name</option>
							<?php echo $proName;?>
						</select>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proPrice">Product price :</label>
						<input type="text" name="proPrice" class="form-control" id="proPrice" placeholder="Product unit price">	
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="repQuantity">Quantity(pcs) :</label>
						<input type="text" name="repQuantity" class="form-control" id="repQuantity" placeholder="Enter your replacement quantity">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="name">Choice a category :</label>
						<select name="selectMode" class="form-control" id="actionSel">
							<option value="">Select your option</option>
							<option value="replaced">Replaced</option>
							<option value="damaged">Damaged</option>
						</select>
					</div>
				</div>
				<div class="col-sm-10 col-sm-offset-1">
					<button type="submit" class="btn btn-primary btn-block">Submit</button>					
				</div>
			</form>	
		</div>
	</div>
</div>
<script src="last.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$("#ProName").change(function(){
			var proName=$(this).val();
			$.ajax({
				url:'ajaxAction/workshopShowNameAjax.php',
				type:'POST',
				data:{proNameVal:proName},
				success:function(value){
					$("#proPrice").val(value.price);
				}
			});
		});
		$("#actionSel").change(function(){
				var ActionMode=$("#actionSel").val();
				var conFirm=confirm("Are you sure this product is "+ActionMode);
				if(conFirm==true){
					$("#actionSel").val(ActionMode);
				}else{
					$("#actionSel").val(null);
				}
			});
		$('.workShopForm').submit(function(){
			var ProName=$("#ProName").val();
			var ProPrice=$("#proPrice").val();
			var ProQuantity=$("#repQuantity").val();
			var ActionMode=$("#actionSel").val();
			$.ajax({
				url:'action/workShopSetupAction.php',
				type:'POST',
				data:{proNameVal:ProName,proPriceVal:ProPrice,QuantityVal:ProQuantity,actionVal:ActionMode},
				success:function(dataValue){}
			});
		});
	});
</script>