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
					<select name='msgs'>
						<option>Select your action</option>
						<option value='delete'>Delete</option>
						<option value='active'>Active</option>
						<option value='deactive'>Deactive</option>
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
		<div class="col-sm-10 col-sm-offset-1">
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
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2 text-center" style="margin-top:10px">
			<?php
				echo"<a class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;"; // Previous button
				for($i=1;$i<=5;$i++){
					echo "<a href='' class='btn btn-default btn-sm text-green'>&nbsp; $i &nbsp;&nbsp;</a>";
				}
				echo"&nbsp;&nbsp;<a class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";// Next button
			?>	
		</div>
	</div>
</div>
