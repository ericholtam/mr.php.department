<?php //Initialize models needed for the table
$department = new department_model($serial_number);
?>

	<h2><span data-i18n="department.department"></span></h2>

		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Department</td>
					<td><?php echo $department->department; ?></td>
				</tr>
			</tbody>
