<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
if(strlen($_SESSION['alogin'])==0)
{   
header('location:index.php');
}
else
{

 if(isset($_POST['reset']))
{   
	$password=md5($_POST['password']);
    $newpassword=md5($_POST['newpassword']);
	$confirmpassword=md5($_POST['confirmpassword']);
    $username=$_SESSION['alogin'];
	
	$query = mysqli_query($conn,"select password from tblemployees where emp_id ='$username'");
	
	if( $query = $password ){

    if($confirmpassword == $newpassword){
		$query = mysqli_query($conn,"update tblemployees set password = '$newpassword' where emp_id = '$username' AND (password = '$password' AND  '$newpassword' = '$confirmpassword') ");
		if ($query) {
			 echo "<script>alert('password Successfully Updated NOTE :  if current password is correct');</script>";
			 
			 echo "<script type='text/javascript'> document.location = 'change_password.php'; </script>";
		}
	}
        
	 else{
		echo "<script>alert(' confirm password INCORRECT');</script>";
		echo "<script type='text/javascript'> document.location = 'change_password.php'; </script>";
	    die(mysqli_error());
   }

	 }
	
	 else{
	
		echo "<script>alert(' current password is incorrect');</script>";
		echo "<script type='text/javascript'> document.location = 'change_password.php'; </script>";
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
									<h4>Reset Password</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Reset password Module</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Change Password</h2>
								<section>
									<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label >Current Password</label>
												<input name="password" type="text" class="form-control" required="true" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>New password</label>
												<input name="newpassword" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase">
											</div>
										</div>
									</div>

                                    <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label> Confirm New password</label>
												<input name="confirmpassword" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase">
											</div>
										</div>
									</div>

									<div class="col-sm-12 text-right">
										<div class="dropdown">
										   <input class="btn btn-primary" type="submit" value="Reset" name="reset" id="add">
									    </div>
									</div>
								   </form>
							    </section>
							</div>
						</div>
						
						
											

										</tbody>
									</table>
								</div>
							</div>
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