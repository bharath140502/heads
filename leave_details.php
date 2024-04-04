<?php error_reporting(0);?>
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../reviewmail.php');

$isread = 1;
$did = intval($_GET['leaveid']);
date_default_timezone_set('Asia/Kolkata');
$admremarkdate = date('Y-m-d G:i:s', strtotime("now"));

// Update the read notification status
$sql = "UPDATE tblleave SET IsRead = :isread WHERE id = :did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread', $isread, PDO::PARAM_STR);
$query->bindParam(':did', $did, PDO::PARAM_STR);
$query->execute();

// Code for action taken on leave
if (isset($_POST['update'])) {
    $did = intval($_GET['leaveid']);
    $status = $_POST['status'];

    // Get the current user's information
    $query = $dbh->prepare("SELECT * FROM tblemployees WHERE emp_id = :session_id");
    $query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $hodEmail = $row['EmailId'];
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $hodFullname = "{$firstName} {$lastName}";

    // Get the staff's email and name
    $staffEmail = $_POST['emailID'];
    $staffName = $_POST['staffName'];

    $reg_status = 2;
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d', strtotime("now"));

    if ($status === '2') {
        $result = mysqli_query($conn, "UPDATE tblleave, tblemployees SET tblleave.HodRemarks = '$status', tblleave.HodDate = '$admremarkdate' WHERE tblleave.empid = tblemployees.emp_id AND tblleave.id = '$did'");

        if ($result) {
            if (filter_var($hodEmail, FILTER_VALIDATE_EMAIL)) {
                if (filter_var($staffEmail, FILTER_VALIDATE_EMAIL)) {
                    // Send email for rejection
                    approve_leave_mail($staffName, $hodFullname, $staffEmail, "REJECTED");
                    echo "<script>alert('Leave rejected Successfully');</script>";
                } else {
                    echo "<script>alert('STAFF EMAIL IS INVALID. LEAVE APPLICATION REJECTED');</script>";
                }
            } else {
                echo "<script>alert('YOUR EMAIL IS INVALID. LEAVE APPLICATION REJECTED');</script>";
            }
        } else {
            die(mysqli_error());
        }
    } elseif ($status === '1') {
        $result = mysqli_query($conn, "UPDATE tblleave, tblemployees SET tblleave.HodRemarks = '$status', tblleave.HodDate = '$admremarkdate' WHERE tblleave.empid = tblemployees.emp_id AND tblleave.id = '$did'");

        // Deduct the approved leave from the employee's leave balance
        $query = mysqli_query($conn, "SELECT * FROM tblemployees, tblleave WHERE tblemployees.emp_id = tblleave.empid AND tblleave.HodRemarks = '$status' AND tblleave.id = '$did'");
        $row = mysqli_fetch_assoc($query);
        $requestedDays = $row['num_days'];
        $leaveType = $row['LeaveType'];
        $employeeId = $row['empid'];

        // Update the employee's leave balance based on the leave type
        if ($leaveType === 'CASUAL LEAVE') {
            // Deduct from Casual Leave balance
            $updateSql = "UPDATE tblemployees, tblleave SET tblemployees.CasualLeave = tblemployees.CasualLeave - tblleave.RequestedDays WHERE tblemployees.emp_id = tblleave.empid AND tblleave.id = '$did'";
        } elseif ($leaveType === 'SICK LEAVE') {
            $updateSql = "UPDATE tblemployees, tblleave SET tblemployees.SickLeave = tblemployees.SickLeave - tblleave.RequestedDays WHERE tblemployees.emp_id = tblleave.empid AND tblleave.id = '$did'";
            // Deduct from another leave type balance
            // Add more conditions as needed for different leave types
        } elseif ($leaveType === 'PRIVILEGE LEAVE') {
            $updateSql = "UPDATE tblemployees, tblleave SET tblemployees.PrivilageLeave = tblemployees.PrivilageLeave - tblleave.RequestedDays WHERE tblemployees.emp_id = tblleave.empid AND tblleave.id = '$did'";
            // Deduct from another leave type balance
            // Add more conditions as needed for different leave types
        } elseif ($leaveType === 'MATERNITY LEAVE') {
            $updateSql = "UPDATE tblemployees, tblleave SET tblemployees.MaternityLeave = tblemployees.MaternityLeave - tblleave.RequestedDays WHERE tblemployees.emp_id = tblleave.empid AND tblleave.id = '$did'";
            // Deduct from another leave type balance
            // Add more conditions as needed for different leave types
        } elseif ($leaveType === 'PERSONAL OUTPASS') {
            $updateSql = "UPDATE tblemployees, tblleave SET tblemployees.Permission = tblemployees.Permission - tblleave.RequestedDays WHERE tblemployees.emp_id = tblleave.empid AND tblleave.id = '$did'";
            // Deduct from another leave type balance
            // Add more conditions as needed for different leave types
        }

        // Create a PDO connection for the update query
        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->execute();

        if ($updateQuery) {
            // Leave deducted successfully
            echo "<script>alert('Leave deducted successfully');</script>";
        } else {
            // Handle error if the leave deduction fails
            echo "<script>alert('Error deducting leave from the employee\'s balance');</script>";
        }

        if ($result) {
            if (filter_var($hodEmail, FILTER_VALIDATE_EMAIL)) {
                if (filter_var($staffEmail, FILTER_VALIDATE_EMAIL)) {
                    // Send email for approval
                    approve_leave_mail($staffName, $hodFullname, $staffEmail, "APPROVED");
                    echo "<script>alert('Leave approved Successfully');</script>";
                } else {
                    echo "<script>alert('STAFF EMAIL IS INVALID. LEAVE APPLICATION APPROVED');</script>";
                }
            } else {
                echo "<script>alert('YOUR EMAIL IS INVALID. LEAVE APPLICATION APPROVED, BUT NO EMAIL SENT');</script>";
            }
        } else {
            die(mysqli_error());
        }
    } else {
        echo "<script>alert('Error occurred');</script>";
    }
}
?>


<style>
	input[type="text"]
	{
	    font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	.btn-outline:hover {
	  color: #fff;
	  background-color: #524d7d;
	  border-color: #524d7d; 
	}

	textarea { 
		font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	textarea.text_area{
        height: 8em;
        font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
      }

	</style>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">

							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Leave Details</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<form method="post" action="">

						<?php 
						if(!isset($_GET['leaveid']) && empty($_GET['leaveid'])){
							header('Location: admin_dashboard.php');
						}
						else {
						
						$lid=intval($_GET['leaveid']);
						$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodDate,tblleave.RegDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.id=:lid";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':lid',$lid,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result)
						{         
						?>  

						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Employee Name</b></label>
									<input type="text" name="staffName" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->FirstName . " " . $result->LastName);?>">

									<!-- <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->FirstName." ".$result->LastName);?>"> -->
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Employee ID</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->Staff_ID);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Designation</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->Position_Staff);?>">
								</div>
							</div>
							
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Phone Number</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->Phonenumber);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Email Address</b></label>
									<input type="text" name="emailID" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->EmailId);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Type</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->LeaveType);?>">
								</div>
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Applied Date</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->PostingDate);?>">
								</div>
							</div>
                            <div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Period</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="From <?php echo htmlentities($result->FromDate);?> to <?php echo htmlentities($result->ToDate);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Requested Number of Days</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->num_days);?>">
								</div>
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Number Days still outstanding</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->DaysOutstand);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Reason</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->WorkCovered);?>">
								</div>
							</div>

						</div>
						
						
						<div class="form-group row">
							<div class="col-md-6 col-sm-12">
							    <div class="form-group">
									<label style="font-size:16px;"><b>Date For HOD's Action</b></label>
									<?php
									if ($result->HodDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
										<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->HodDate); ?>">
									  </div>
									<?php endif ?>
							    </div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Date For HR Action</b></label>
									<?php
									if ($result->RegDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
										<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->RegDate); ?>">
									  </div>
									<?php endif ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Status From HOD</b></label>
									<?php $stats=$result->HodRemarks;?>
									<?php
									if ($stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Status From HR</b></label>
									<?php $ad_stats=$result->RegRemarks;?>
									<?php
									if ($ad_stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($ad_stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<?php 
							if(($stats==0 AND $ad_stats==0) OR ($stats==2 AND $ad_stats==0) OR ($stats==2 AND $ad_stats==2))
							  {

							 ?>
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b></b></label>
									<div class="modal-footer justify-content-center">
										<button class="btn btn-primary" id="action_take" data-toggle="modal" data-target="#success-modal">Take&nbsp;Action</button>
									</div>
								</div>
							</div>

							<form name="adminaction" method="post">
  								<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-body text-center font-18">
												<h4 class="mb-20">Leave take action</h4>
												<select name="status" required class="custom-select form-control">
													<option value="">Choose your option</option>
				                                          <option value="1">Approved</option>
				                                          <option value="2">Rejected</option>
												</select>
											</div>
											<div class="modal-footer justify-content-center">
												<input type="submit" class="btn btn-primary" name="update" value="Submit">
											</div>
										</div>
									</div>
								</div>
  							</form>

							 <?php }?> 
						</div>

						<?php $cnt++;} } }?>
					</form>
				</div>

			</div>
			
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>