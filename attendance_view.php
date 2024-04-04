<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<!-- <div class="title pb-20">
				<h2 class="h3 mb-0">Attendance Details</h2>
			</div> -->

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">DEPARTMENT EMPLOYEES ATTENDANCE</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
                                <th>Employee ID</th>
								<th class="table-plus">EMPLOYEE NAME</th>
                                <th>DEPARTMENT</th>
								<th>LOGIN TIME</th>
								<th>LOGOUT TIME</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								 <?php
		                         $teacher_query = mysqli_query($conn,"SELECT attendee.Emp_Id,attendee.Employee_Name,tblemployees.Department,attendee.First_In,attendee.Last_Out from attendee join tblemployees on attendee.Emp_Id=tblemployees.Staff_ID where tblemployees.Department = '$session_depart'") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($teacher_query)) {
		                         $id = $row['Emp_Id'];
		                             ?>
                                
                                <td><?php echo $row['Emp_Id']; ?></td>
								<td class="table-plus">
                                    
									<div class="name-avatar d-flex align-items-center">
                                    
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['Employee_Name']; ?></div>
										</div>
									</div>
								</td>
								
	                            <td><?php echo $row['Department']; ?></td>
								<td><?php echo $row['First_In']; ?></td>
								<td><?php echo $row['Last_Out']; ?></td>
								<td>
								</td>
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