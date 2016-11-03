<?php
	require('database.php');
	$viewAlluser=$db->prepare("SELECT * FROM user");
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
				<td>
					<select name='msgs' id='actionId'>
						<option id='actionMode'>Select your action</option>
						<option id='actionMode' value='active'>Active</option>
						<option id='actionMode' value='delete'>Delete</option>
						<option id='actionMode' value='deactive'>Deactive</option>
					</select>
				</td>
			</tr>
		";
	}
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="text-center text-green">View all users</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<th width="5%">Sl No</th>
					<th>User Name</th>
					<th>User Type</th>
					<th>User Status</th>
					<th width="5%">Action</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12" style="margin-top:10px">
			<hr>
		</div>
	</div>
</div>
<script src="last.js"></script>
<script>
	$(document).ready(function(){
		$("#actionId").change(function(){
			$(this.value).click(function(){
				alert("nice");
			});
		});
	});
</script>