<?php
include('includes/header.php');
include('../includes/session.php');

if (isset($_GET['delete'])) {
    $ood_id = $_GET['delete'];
    
    // Validate leave_id to prevent SQL injection
    if (!is_numeric($ood_id)) {
        echo "<script>alert('Invalid OOD ID');</script>";
        echo "<script type='text/javascript'> document.location = 'my_ood_history.php'; </script>";
        exit;
    }

    $sql = "DELETE FROM tblood WHERE id = $ood_id AND HodRemarks = 0";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Your applied OOD was deleted successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'my_ood_history.php'; </script>";
        exit;
    } else {
        echo "<script>alert('Error deleting leave: " . mysqli_error($conn) . "');</script>";
        echo "<script type='text/javascript'> document.location = 'ood_history.php'; </script>";
        exit;
    }
}

include('includes/navbar.php');
include('includes/right_sidebar.php');
include('includes/left_sidebar.php');
?>

<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20">
        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">

                    <?php
                    $sql = "SELECT id from tblood where emp_id = $session_id";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $empcount=$query->rowCount();
                    ?>

                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?php echo($empcount);?></div>
                            <div class="font-14 text-secondary weight-500">All Applied OOD Request</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">

                    <?php 
                     $status=1;
                     $query = mysqli_query($conn,"select * from tblood where emp_id = '$session_id' AND HodRemarks = '$status'")or die(mysqli_error());
                     $count_reg_staff = mysqli_num_rows($query);
                     ?>

                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?php echo htmlentities($count_reg_staff); ?></div>
                            <div class="font-14 text-secondary weight-500">Approved</div>
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
                     $query_pend = mysqli_query($conn,"select * from tblood where emp_id = '$session_id' AND HodRemarks = '$status'")or die(mysqli_error());
                     $count_pending = mysqli_num_rows($query_pend);
                     ?>

                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?php echo($count_pending); ?></div>
                            <div class="font-14 text-secondary weight-500">Pending</div>
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
                     $query_reject = mysqli_query($conn,"select * from tblood where emp_id = '$session_id' AND HodRemarks = '$status'")or die(mysqli_error());
                     $count_reject = mysqli_num_rows($query_reject);
                     ?>

                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?php echo($count_reject); ?></div>
                            <div class="font-14 text-secondary weight-500">Rejected</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h2 class="text-blue h4">ALL MY OOD DETAILS</h2>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus">OOD TYPE</th>
                            <th>DATE FROM</th>
                            <th>DATE TO</th>
                            <th>NO. OF DAYS</th>
                            <th>HOD STATUS</th>
                            <th>HR STATUS</th>
                            <th class="datatable-nosort">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT * FROM tblood WHERE emp_id = '$session_id'";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;

                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                        ?>
                                <tr>
                                    <td><?php echo htmlentities($result->Oodtype); ?></td>
                                    <td><?php echo htmlentities($result->FromDate); ?></td>
                                    <td><?php echo htmlentities($result->ToDate); ?></td>
                                    <td><?php echo htmlentities($result->num_days); ?></td>
                                    <td>
                                        <?php
                                        $stats = $result->HodRemarks;
                                        if ($stats == 1) {
                                            echo "<span style='color: green'>Approved</span>";
                                        } elseif ($stats == 2) {
                                            echo "<span style='color: red'>Not Approved</span>";
                                        } elseif ($stats == 0) {
                                            echo "<span style='color: blue'>Pending</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $stats = $result->HrRemarks;
                                        $stats1 = $result->HodRemarks;
                                        if ($stats == 1) {
                                            echo "<span style='color: green'>Approved</span>";
                                        } elseif ($stats == 2) {
                                            echo "<span style='color: red'>Not Approved</span>";
                                        } elseif ($stats == 0) {
                                            echo "<span style='color: blue'></span>";
                                        } elseif ($stats == 0 && $stats1 == 1) {
                                            echo "<span style='color: blue'>Pending</span>";
                                        }
                                        ?>
                                    </td>
                                    <!-- <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" href="view_leaves.php?edit=<?php echo htmlentities($result->id); ?>"><i class="icon-copy dw dw-eye"></i> View</a>
                                                <a class="dropdown-item" href="leave_history.php?delete=<?php echo htmlentities($result->id); ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td> -->
									<td>
                                   <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                        </a>
                                         <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                               <?php
                                                    $hodStatus = $result->HodRemarks;
                                                    if ($hodStatus == 0) {
                                                        ?>
                                                  <a class="dropdown-item" href="view_ood.php?edit=<?php echo htmlentities($result->id); ?>"><i class="icon-copy dw dw-eye"></i> View</a>
                                                  <!-- <a class="dropdown-item" href="edit_staff.php?edit=<?php echo $row['emp_id']; ?>"><i class="dw dw-edit2"></i> Edit</a> -->
                                                  <a class="dropdown-item" href="edit_ood.php?edit=<?php echo htmlentities($result->id); ?>"><i class="dw dw-edit2"></i> Edit</a>
                                                  <a class="dropdown-item" href="my_ood_history.php?delete=<?php echo htmlentities($result->id); ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                                 <?php
                                                    } else {
                                                             ?>
                                                             <a class="dropdown-item" href="view_ood.php?edit=<?php echo htmlentities($result->id); ?>"><i class="icon-copy dw dw-eye"></i> View</a>
                                                         <?php
                                                             }
                                                                ?>
                                          </div>
                                   </div>
                                            </td>
								
								           </tr>
                                        <?php
                                $cnt++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>
</div>
<!-- js -->
<?php include('includes/scripts.php'); ?>
</body>

</html>
