<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">DEPARTMENT  HEADS</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">NAME</th>
								<th>EMAIL ADDRESS</th>
                                <th>DEPARTMENT</th>
                                <th>POSITION</th>
								<th>PHONE NUMBER</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								 <?php
		                         $teacher_query = mysqli_query($conn,"select * from tblemployees where tblemployees.role = 'HOD'  ORDER BY tblemployees.emp_id") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($teacher_query)) {
		                         $id = $row['emp_id'];
								     // Retrieve leave values
									 $sickLeave = $row['SickLeave'];
									 $privilegeLeave = $row['PrivilageLeave'];
									 $casualLeave = $row['CasualLeave'];
				 
									 // Calculate available leaves
									 $availableLeaves = $sickLeave + $privilegeLeave + $casualLeave;
				 
									 // Retrieve employee ID
									 $employeeId = $row['emp_id'];
				 
									 // Fetch availed leaves for the employee from the tblleave table
									 $query = "SELECT SUM(RequestedDays) AS availed_leaves FROM tblleave WHERE empid = $employeeId AND  regremarks = 1 GROUP BY empid";
									 $result = mysqli_query($conn, $query);
									 $row_leave = mysqli_fetch_assoc($result);
				 
									 // Retrieve availed leaves count
									 $availedLeaves = ($row_leave) ? $row_leave['availed_leaves'] : 0;
		                             ?>

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['EmailId']; ?></td>
                                <td><?php echo $row['Department']; ?></td>
                                <td><?php echo $row['Position_Staff']; ?></td>
	                            <td><?php echo $row['Phonenumber']; ?></td>
							</tr>
							<?php } ?>  
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>