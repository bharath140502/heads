<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['add_staff']))
	{
	
	$fname=$_POST['firstname'];
	$lname=$_POST['lastname'];   
	$email=$_POST['email'];  
	$gender=$_POST['gender']; 
	$dob=$_POST['dob']; 
	$department=$_POST['department']; 
	$address=$_POST['address']; 
	$leave_days=$_POST['leave_days']; 
	$user_role=$_POST['user_role']; 
	$phonenumber=$_POST['phonenumber']; 
	$position_staff=$_POST['position_staff']; 
	$staff_id=$_POST['staff_id']; 
	$cl = $_POST['CasualLeave'];
    $Pl = $_POST['PrivilageLeave'];
	$sl = $_POST['SickLeave'];
	$result = mysqli_query($conn,"update tblemployees set FirstName='$fname', LastName='$lname', EmailId='$email', Gender='$gender', Dob='$dob', Department='$department', Address='$address', Av_leave='$leave_days', role='$user_role', Phonenumber='$phonenumber', Position_Staff='$position_staff', Staff_ID='$staff_id' where emp_id='$get_id'         
		"); 		
	if ($result) {
     	echo "<script>alert('Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'staff.php'; </script>";
	} else{
	  die(mysqli_error());
   }
		
}

?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<!-- <div class="title">
								<h4>Staff Portal</h4>
							</div> -->
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Employee Details</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
									$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error($conn));
									$row = mysqli_fetch_array($query);
									?>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Employee Name :</label>
											<input name="fullname" type="text" class="form-control" readonly autocomplete="off" value="<?php echo $row['FirstName'] . ' ' . $row['LastName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Employee ID :</label>
											<input name="staff_id" type="text" class="form-control" required="true" readonly autocomplete="off" value="<?php echo $row['Staff_ID'] ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Email Address :</label>
											<input name="email" type="email" class="form-control" required="true" readonly autocomplete="off" value="<?php echo $row['EmailId']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Date Of Birth :</label>
											<input name="dob" type="text" class="form-control" readonly autocomplete="off" value="<?php echo $row['Dob']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Phone Number :</label>
											<input name="phonenumber" type="text" class="form-control" required="true" readonly autocomplete="off"value="<?php echo $row['Phonenumber']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Designation :</label>
											<input name="position_staff" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" value="<?php echo $row['Position_Staff'] ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Department :</label>
											<input name="department" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" value="<?php echo $row['Department'] ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Address :</label>
											<input name="address" type="text" class="form-control" readonly autocomplete="off" value="<?php echo $row['Address']; ?>">
										</div>
									</div>	
									
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Available Casual Leave :</label>
											<input name="cl" type="text" class="form-control" required="true" readonly autocomplete="off"value="<?php echo $row['CasualLeave']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Available Privilege Leave :</label>
											<input name="pl" type="text" class="form-control" required="true" readonly autocomplete="off"value="<?php echo $row['PrivilageLeave']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Available Sick Leave :</label>
											<input name="sl" type="text" class="form-control" required="true" readonly autocomplete="off"value="<?php echo $row['SickLeave']; ?>">
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>

			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<?php include('includes/scripts.php')?>
</body>
</html>