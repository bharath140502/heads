<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>


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
									<h4>Holiday List</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Holiday Module</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
                    <div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
								<h2 class="mb-30 h4" >National Holiday List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th class="table-plus">Holiday Name</th>
											<th>Date</th>
                                            
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from tblholiday where type = 'National'";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
	                                            <td><?php echo htmlentities($result->HolidayName);?></td>
	                                            <td><?php echo htmlentities($result->Date);?></td>
											
											</tr>

											<?php $cnt++;} }?>  

										</tbody>
									</table>
								</div>
							</div>
						</div>

                        <div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
								<h2 class="mb-30 h4" >Festival Holiday List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th class="table-plus">Holiday Name</th>
											<th>Date</th>
                                            
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from tblholiday where type = 'Festival'";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
	                                            <td><?php echo htmlentities($result->HolidayName);?></td>
	                                            <td><?php echo htmlentities($result->Date);?></td>
                                                
											
											</tr>

											<?php $cnt++;} }?>  

										</tbody>
									</table>
								</div>
							</div>
						</div>

                        <div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
					<h2 class="mb-30 h4"> Optional Holiday List<p style="font-size: 14px; color:#FF0000;">note : only one optional holiday you can take out of the below listed</p></h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th class="table-plus">Holiday Name</th>
											<th>Date</th>
                                            
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from tblholiday where type = 'Optional'";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
	                                            <td><?php echo htmlentities($result->HolidayName);?></td>
	                                            <td><?php echo htmlentities($result->Date);?></td>
                                                
											
											</tr>

											<?php $cnt++;} }?>  

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