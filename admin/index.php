<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
	
	require_once '../includes/conn.php';
	require_once '../functions.php';
//  if($_SESSION["loggedin"] !== true){
//      header("location: login.php");
//     exit;
// }

if(isset($_POST['submit'])){
	$hosp_name = mysqli_real_escape_string($db_link, $_POST['hosp_name']);
	$hosp_city = mysqli_real_escape_string($db_link, $_POST['hosp_city']);
	$hosp_location = mysqli_real_escape_string($db_link, $_POST['hosp_location']);
	$hosp_address = mysqli_real_escape_string($db_link,$_POST['hosp_address']);
	$hosp_lat = mysqli_real_escape_string($db_link,$_POST['hosp_lat']);
	$hosp_long= mysqli_real_escape_string($db_link,$_POST['hosp_long']);
	
	$hosp_data = addHospital($db_link, $hosp_name, $hosp_city, $hosp_location, $hosp_address, $hosp_lat, $hosp_long);
	// echo $hosp_data;
	
			if ($hosp_data === 'hospital_name_exits') {
				echo "<script> alert ( 'Warning',
					'hospital Already in the System',
					'warning'
				  )
				  </script>";
				  echo "<script> 
							  alert ( 'Hospital Already in the System')
						</script>";
			}else if ($hosp_data === 'hospital_added') {
				echo "<script> swal ( 'Success',
					'Hospital Successfully registered in the system',
					'success'
				  )
				  </script>";
			}
		}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>BLOOD DONATION DASHBOARD - ADMIN</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <!-- DataTables Select JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

</head>
<body>
    <?php require_once './header.php'; ?>

    
    <div class="container">
    	
    	<br/>
    	
	 	<button class="btn btn-secondary w-100 p-3"  type="button" data-toggle="collapse" data-target="#addSchool" aria-expanded="true" aria-controls="collapseExample">
			Add Hospital/ blood Bank Center   
		 </button>
		
    	<div class="row">
    		
	 		 <div class="collapse col-md-12" id="addSchool">
	 		 	<div class="col-md-12">
	    			<h2>Add Hospital/Blood Bank Center</h2>
	    			<hr/>
				<form class="form" method="post" action="index.php">	
					<label>Hospital/Blood Bank Center</label><br/>										
					<input class="form-control" type="text" name="hosp_name" placeholder="hospital name" required="required" />
					<label>Hospital City Orgin:</label></br>
					<input class="form-control" type="text" name="hosp_city" placeholder="hospital city" required="required"/>
					<label>Hospital Location E.g Munali </label><br/>
					<input class="form-control" type="text" name="hosp_location" placeholder="hospital location" required="required" />
					<label> Hospital Address e.g new Munali street </label><br/>
					<input class="form-control" type="text" name="hosp_address" placeholder="hospital address" required="required">
					<label> Hospital Address e.g 12.865 </label><br/>
					<input class="form-control" type="text" name="hosp_lat" placeholder="hosp_lat" required="required">
					<label> Hospital Long e.g new -28.132 </label><br/>
					<input class="form-control" type="text" name="hosp_long" placeholder="hosp_long" required="required">
					<br>
					<div class="form-group">
						<button class="btn btn-primary" type="submit" name="submit"class="btn primary"><i class="fa fa-message"></i>add</button>
					</div>
				
				</form>
							
					<!-- <form method="POST">
						<label>School Name</label>
						<input required class="form-control" type="text" name="school_name" placeholder="School Name" /><br>
						<label>School Center Number</label>
						<input required class="form-control" type="text" name="school_id" placeholder="School Center Number" /><br>
						<label>School Location</label>
						<input required class="form-control" type="text" name="school_location" placeholder="School Location" /><br>
						<input type="submit" name="submit_school" class="btn btn-primary" value="Add School" />
					</form> -->
	    		</div>
	 		 </div>
	 	</div>
	 	<br>
		 <p> Welcome to the Bank Bank system </p>
    	 <!-- <button class="btn btn-dark w-100 p-3"  type="button" data-toggle="collapse" data-target="#addPupil" aria-expanded="true" aria-controls="collapseExample">
			Add Pupil
		 </button> -->
		 <div class="row">
		 <div class="collapse col-md-12" id="addPupil">
		 	<div class="col-md-12">
    			<h2>Add Pupil</h2>
    			<hr/>

					<form method="POST" class="form-group">
						<label>Pupil Full Name</label>
						<input required type="text" class="form-control" name="pupil_name" placeholder="Name"><br />
						<label>Pick School</label>
						<select name="pupil_school" class="form-control">
							<?php
								$getSchools = schoolCentre($db_link);

								while ($rows = mysqli_fetch_assoc($getSchools)) {
									echo "<option value='".$rows['school_center']."'>".$rows['school_name']."</option>";
								}
							?>
						</select><br>
						<label>Pupil Intake</label>
						<input required class="form-control" type="text" name="pupil_intake" placeholder="intake"><br />
						<label>Set Password</label>
						<input required class="form-control" type="password" name="pupil_password"placeholder="password" ><br />
						<label>Pupil ID Number</label>
						<input required class="form-control" type="number" name="pupil_id" placeholder="id"><br />
						<input class="btn btn-primary"  type="submit" name="submit_pupil" value="Add Pupil" />
					</form>
    		</div>
		 </div>

    		
    	</div>
    	<br>
    	 <button class="btn btn-success w-100 p-3"  type="button" data-toggle="collapse" data-target="#addResults" aria-expanded="true" aria-controls="collapseExample">
			Upload Results
		 </button>
    	<div class="row">
    		<div class="collapse col-md-12" id="addResults">
	    		<div class="col-md-12">
	    			<h2>Upload Results</h2>
	    			<hr/>
					<form enctype="multipart/form-data" method="POST">
						<label>Results Intake</label>
						<input required class="form-control" type="text" name="intake_year" placeholder="intake_year" /><br>
						<label>Upload Results <sup>CSV Format</sup></label>
						<input required class="form-control" type="file" name="excel_or_csv" accept=".csv" /><br>
						<input type="submit" class="btn btn-grey" value="Upload CSV" name="submit_csv">

					</form>
	    		</div>
    		</div>
    	</div>
    	  <br>
    	 <button class="btn btn-primary w-100 p-3"  type="button" data-toggle="collapse" data-target="#addPaper" aria-expanded="true" aria-controls="collapseExample">
			Upload Past Paper
		 </button>
		 <div class="row">
		 	<div class="collapse col-md-12" id="addPaper">
			 	<div class="col-md-12">
	    			<h2>Add Past Paper</h2>
	    			<hr/>

					<form enctype="multipart/form-data" method="POST">
						<label>Paper Name</label>
						<input required class="form-control" type="text" name="paper_name" /><br>
						<label>Paper Year</label>
						<input required class="form-control" type="text" name="paper_year" /><br>
						<label>Upload the Paper <sup>PDF - Format</sup></label>
						<input class="form-control" type="file" accept=".pdf" name="paper_file"><br>
						<input required type="submit" class="btn btn-grey" value="Upload Past Paper" name="submit">
					</form>	
	    		</div>
		 	</div>
    	
    	</div>
    	<br>
    </div>









</body>
</html>