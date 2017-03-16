<?php //Initialize models needed for the table
$department = new department_model($serial_number);
?>

	<h2>Department</h2>

		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Status</td>
					<td><?php echo $department->status; ?></td>
				</tr>
				<tr>
					<td>Department</td>
					<td><?php echo $department->department; ?></td>
				</tr>
			</tbody>
