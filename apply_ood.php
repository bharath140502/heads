<html>
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

	if(isset($_POST['apply']))
	{
	$empid=$session_id;
	$ood_type=$_POST['ood_type'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
	$fromdate=date('d-m-Y', strtotime($_POST['date_from']));
	$todate=date('d-m-Y', strtotime($_POST['date_to']));
	$requested_days=$_POST['requested_days'];  
	$hod_status=0;
	$hr_status=0;
	$isread=0;
	$datePosting = date("d-m-Y");
    $details = $_POST['details'];
    $reason = $_POST['reason'];

	$DF = date_create($_POST['date_from']);
	$DT = date_create($_POST['date_to']);

	$diff =  date_diff($DF , $DT );
	$num_days = (1 + $diff->format("%a"));

	$query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($query);

	if($fromdate > $todate)
	{
	    echo "<script>alert('End Date should be greater than Start Date');</script>";
	  }
	else {
            $staffQuery= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error($conn));
            //getEmailStaff
            $staffRow = mysqli_fetch_assoc($staffQuery);
            $staffEmailId = $staffRow['EmailId'];
            $firstname = $staffRow['FirstName'];
            $lastname = $staffRow['LastName'];
            $fullname = "".$firstname."  ".$lastname."";

            $hodQuery= mysqli_query($conn,"select * from tblemployees where tblemployees.role = 'HOD' and tblemployees.Department = '$session_depart'")or die(mysqli_error($conn));
            //getEmail
            $row = mysqli_fetch_assoc($hodQuery);
            $hEmailId = $row['EmailId'];
            $firstName = $row['FirstName'];
            $lastName = $row['LastName'];
            $hodFullname = "".$firstName."  ".$lastName."";

            if (filter_var($staffEmailId, FILTER_VALIDATE_EMAIL)) {
                
                if (filter_var($hEmailId, FILTER_VALIDATE_EMAIL)) {
                    $sql="INSERT INTO tblood (Oodtype,RequestedDays,FromDate,ToDate,PostingDate,Reason,HodRemarks,HrRemarks,IsRead,emp_id,num_days,StartTime, EndTime)	VALUES('$ood_type', '$requested_days','$fromdate','$todate', '$datePosting', '$reason','$hod_status','$hr_status','$isread','$empid', '$num_days','$start_time','$end_time')";
                    $lastInsertId = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    if($lastInsertId)
                    {
                        echo "<script>alert('applied OOD successfully');</script>";
                        echo "<script type='text/javascript'> document.location = 'my_ood_history.php'; </script>";

                    }
                    else 
                    {
                        echo "<script>alert('Something went wrong. Please try again');</script>";
                    }
                }
                else {
                    echo "<script>alert('HOD EMAIL IS INVALID. LEAVE APPLICATION FAILED');</script>";
                 }
            }
            else {
                echo "<script>alert('YOUR EMAIL IS INVALID. LEAVE APPLICATION FAILED');</script>";
            }
	}

}

?>
<body>
    
    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>OUT OF OFFICE DUTY FORM</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">OOD Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                 </div>
                 <div style="margin-left: 30px; margin-right: 30px;" class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Out Of Office Duty Form</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>

                                <?php if ($role_id = 'HOD'): ?>
                                <?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
                                    $row = mysqli_fetch_array($query);
                                ?>
                        
                        <div class="row">
                                <div class="col-md-6 col-sm-12"> <!-- Use a single column instead of splitting into two columns -->
                                    <div class="form-group">
                                       <label>Name</label>
                                       <input name="fullname" type="text" class="form-control" readonly autocomplete="off" value="<?php echo $row['FirstName'] . ' ' . $row['LastName']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Employee ID </label>
                                            <input name="staff_id" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Staff_ID']; ?>">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Position</label>
                                            <input name="postion" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Position_Staff']; ?>">
                                        </div>
                                    </div>
                                    <?php endif ?>
                                
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>OOD Type :</label>
                                            <select name="ood_type" id="ood_type" class="custom-select form-control" required="true" autocomplete="off">
                                            <option value="">Select OOD type...</option>
                                            <?php $sql = "SELECT  description from tbloodtype";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $result)
                                            {   ?>                                            
                                            <option value="<?php echo htmlentities($result->description);?>"><?php echo htmlentities($result->description);?></option>
                                            <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Start OOD Date :</label>
                                            <input id="date_form" name="date_from" type="date" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>End OOD Date :</label>
                                            <input id="date_to" name="date_to" type="date" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                <label>Start Time:</label>
                                <input name="start_time" type="time" class="form-control" autocomplete="off">
                                </div>
                               </div>
                              <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                              <label>End Time:</label>
                              <input name="end_time" type="time" class="form-control" autocomplete="off">
                              </div>
                              </div>
                            </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                       <label>Details:</label>
                                       <input name="reason" type="text" class="form-control" required="true" autocomplete="off">
                                       <!-- <textarea name="reason" class="form-control" rows="3" required="true" ></textarea> -->
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Requested OOD days</label>
                                            <input id="requested_days" name="requested_days" type="text" class="form-control" required="true" autocomplete="off" readonly value="">
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Apply&nbsp;OOD</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  

<script>
    const picker = document.getElementById('date_form');
    picker.addEventListener('input', function(e){
    var day = new Date(this.value).getUTCDay();
    if([6,0].includes(day)){
      e.preventDefault();
      this.value = '';
      alert('Weekends not allowed');
    } else {
        calc();
    }
   });

   const pickers = document.getElementById('date_to');
    pickers.addEventListener('input', function(e){
    var day = new Date(this.value).getUTCDay();
    if([6,0].includes(day)){
      e.preventDefault();
      this.value = '';
      alert('Weekends not allowed');
    }else {
        calc();
    }
   });


    function calc() {
      const date_to = document.getElementById('date_to');
      const date_from = document.getElementById('date_form');
      result = getBusinessDateCount(new Date(date_from.value), new Date(date_to.value));
      var work = document.getElementById("requested_days");
      work.value = result;
}

    function getBusinessDateCount(startDate, endDate) {
        var elapsed, daysBeforeFirstSaturday, daysAfterLastSunday;
        var ifThen = function(a, b, c) {
            return a == b ? c : a;
        };

        elapsed = endDate - startDate;
        elapsed /= 86400000;

        daysBeforeFirstSunday = (7 - startDate.getDay()) % 7;
        daysAfterLastSunday = endDate.getDay();

        elapsed -= (daysBeforeFirstSunday + daysAfterLastSunday);
        elapsed = (elapsed / 7) * 5;
        elapsed += ifThen(daysBeforeFirstSunday - 1, -1, 0) + ifThen(daysAfterLastSunday, 6, 5);

        return Math.ceil(elapsed);
     }


     function showHideTimeToTimeColumns() {
        var leaveType = document.getElementById("leave_type").value;
        var timeToTimeColumns = document.getElementById("timeToTimeColumns");

        if (leaveType === "PO") {
            timeToTimeColumns.style.display = "block";
        } else {
            timeToTimeColumns.style.display = "none";
        }
    }

    // Attach an event listener to the "Leave Type" dropdown
    document.getElementById("ood_type").addEventListener("change", showHideTimeToTimeColumns);
</script>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
  
</body>
</html>
