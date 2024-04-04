<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4 user-icon">
						<img src="../vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">

						<?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
						?>

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
						Welcome <b><?php echo  $row['FirstName']. " " .$row['LastName']; ?></b> to the Internal Self Portal. Access resources, information, and tools for enhanced productivity. Explore and empower yourself.
						</h4>
						
				</div>
			</div>
			<!-- <div class="title pb-20">
				<h2 class="h3 mb-0">Data Information</h2>
			</div> -->
			<div class="row pb-10">
				<!-- <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from tblemployees";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$empcount=$query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($empcount);?></div>
								<div class="font-14 text-secondary weight-500">Total Staffs</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div> -->
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=1;
						$sql = "SELECT id from tblleave where HodRemarks=:status";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$leavecount=$query->rowCount();
						?>        

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Approved Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy fa fa-hourglass"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=0;
						$sql = "SELECT tblleave.id from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where HodRemarks=:status and tblemployees.role = 'Staff' and tblemployees.Department = '$session_depart'";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$leavecount=$query->rowCount();
						?>        

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Pending Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=2;
						$sql = "SELECT id from tblleave where HodRemarks=:status";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$leavecount=$query->rowCount();
						?>  

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Rejected Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=0;
						$sql = "SELECT tblood.id from tblood join tblemployees on tblood.emp_id=tblemployees.emp_id where HodRemarks=:status and tblemployees.role = 'Staff' and tblemployees.Department = '$session_depart'";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$oodcount=$query->rowCount();
						?>        

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($oodcount); ?></div>
								<div class="font-14 text-secondary weight-500">Pending OOD</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Department Heads</div>
							<div class="table-actions">
								<a title="VIEW" href="department_hod_list.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role = '$session_role' ORDER BY tblemployees.emp_id ") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				
                <div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Employee on leave</div>
							<div class="table-actions">
								<a title="VIEW" href="approved_leave.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"SELECT tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.EmailId,tblemployees.Position_Staff,tblemployees.Department,tblemployees.Phonenumber from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id
								  where CURRENT_DATE = tblleave.FromDate AND tblleave.HodRemarks= 1") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>


				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Staff</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role = 'Staff' and Department = '$session_depart' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">LATEST LEAVE APPLICATIONS</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>MY REMARKS</th>
								<th>HR REMARKS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php $sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodDate,tblleave.RegDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblemployees.role = 'Staff' and Department = '$session_depart' order by lid desc limit 5";
									$query = $dbh -> prepare($sql);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									$cnt=1;
									if($query->rowCount() > 0)
									{
									foreach($results as $result)
									{         
								 ?>  

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<!-- <div class="txt mr-2 flex-shrink-0">
											<b><?php echo htmlentities($cnt);?></b>
										</div> -->
										<div class="txt">
											<div class="weight-600"><?php echo htmlentities($result->FirstName." ".$result->LastName);?></div>
										</div>
									</div>
								</td>
								<td><?php echo htmlentities($result->LeaveType);?></td>
	                            <td><?php echo htmlentities($result->PostingDate);?></td>
								<td><?php $stats=$result->HodRemarks;
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
	                            <td><?php $stats=$result->RegRemarks;
								           $statss=$result->HodRemarks;
	                             
								 if($stats==1){  
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php }  if($stats==0)  { ?>
	                                  <span style="color: blue">       </span>
	                                  <?php } if($statss==1 and $stats==0 ) { ?>
	                                   <span style="color: blue">Pending</span>
	                                  <?php }
								 ?>
	                            </td>
								<td>
									<!-- <div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a> -->
										<!-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"> -->
											<div><a class="dropdown-item" href="leave_details.php?leaveid=<?php echo htmlentities($result->lid);?>"><i class="dw dw-eye"></i> View</a><div>
											<!-- <a class="dropdown-item" href="admin_dashboard.php?leaveid=<?php echo htmlentities($result->lid);?>"><i class="dw dw-delete-3"></i> Delete</a> -->
										<!-- </div>
									</div> -->
								</td>
							</tr>
							<?php $cnt++;} }?>
						</tbody>
					</table>
			   </div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">LATEST OOD APPLICATIONS</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF NAME</th>
								<th>OOD TYPE</th>
								<th>APPLIED DATE</th>
								<th>MY REMARKS</th>
								<th>HR REMARKS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php $sql = "SELECT tblOOD.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblood.Oodtype,tblood.ToDate,tblood.FromDate,tblood.PostingDate,tblood.RequestedDays,tblood.Reason,tblood.HodRemarks,tblood.HrRemarks,tblood.HodDate,tblood.HrDate,tblood.num_days from tblood join tblemployees on tblood.emp_id=tblemployees.emp_id where tblemployees.role = 'Staff' and Department = '$session_depart' order by lid desc limit 5";
									$query = $dbh -> prepare($sql);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									$cnt=1;
									if($query->rowCount() > 0)
									{
									foreach($results as $result)
									{         
								 ?>  

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<!-- <div class="txt mr-2 flex-shrink-0">
											<b><?php echo htmlentities($cnt);?></b>
										</div> -->
										<div class="txt">
											<div class="weight-600"><?php echo htmlentities($result->FirstName." ".$result->LastName);?></div>
										</div>
									</div>
								</td>
								<td><?php echo htmlentities($result->Oodtype);?></td>
	                            <td><?php echo htmlentities($result->PostingDate);?></td>
								<td><?php $stats=$result->HodRemarks;
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
	                            <td><?php $stats=$result->HrRemarks;
								           $statss=$result->HodRemarks;
	                             
								 if($stats==1){  
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php }  if($stats==0)  { ?>
	                                  <span style="color: blue">       </span>
	                                  <?php } if($statss==1 and $stats==0 ) { ?>
	                                   <span style="color: blue">Pending</span>
	                                  <?php }
								 ?>
	                            </td>
								<td>
									<!-- <div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a> -->
										<!-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"> -->
											<div><a class="dropdown-item" href="ood_details.php?leaveid=<?php echo htmlentities($result->lid);?>"><i class="dw dw-eye"></i> View</a><div>
											<!-- <a class="dropdown-item" href="admin_dashboard.php?leaveid=<?php echo htmlentities($result->lid);?>"><i class="dw dw-delete-3"></i> Delete</a> -->
										<!-- </div>
									</div> -->
								</td>
							</tr>
							<?php $cnt++;} }?>
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