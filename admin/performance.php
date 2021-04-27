<?php
	require_once '../includes/conn.php';
	require_once '../functions.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

    <meta charset="utf-8">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <!-- DataTables Select JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/Chart.min.js"></script>
    <style type="text/css">
    	#chart {
		  max-width: 100%;
		}
    </style>

</head>
<body>
	    <?php require_once './header.php'; ?>
	    <div class="container">
	    		    		<br>
							<div class="row">
								<div class="col-md-12">
								<h4>Generate A Report<h4>
								<form method="POST" action="generate.php" class="form-group">
									<select name="type_of_report" class="form-control" onChange="reportSelectOptions(this)">
										<option id="users_list" value="users_list"> List of Current Users </option>
										<option id="blood_group" value="blood_group"> Blood Group </option>
										<option id="hospital_search" value="hospital_search"> Blood Banks </option>
										<!-- <option id="province_report" value="province_report">Report Per Province</option> -->
									</select>

									<div  class="form-group" id="blood_group_list" style="display: none">
										<lable> Pick Blood Group </label>
										<select name="blood_groups" class="form-control">
											<option id="all_blood_group" value="all_blood_group"> All Avaliable Groups </option>
											<?php 
												$select = mysqli_query($db_link, "SELECT blood_group FROM users_tbl");
												foreach($select as $rows){
													echo '<option id="'.$rows['blood_group'].'" value="'.$rows['blood_group'].'">
														'.$rows['blood_group'].'</option>';
												}
											?>
										</select>
									</div>


									<div class="form-group" id="provinces" style="display: none">
										<label>Pick A Province </label>
										<select name="provinces" class="form-control">
											<option id="all_province"> All Available Provinces </option>
											<?php
												$select = mysqli_query($db_link, "SELECT DISTINCT(province) FROM users_tbl");
												foreach($select as $rows){
													echo '<option id="'.$rows['province'].'" value="'.$rows['province'].'">
														'.$rows['province'].'</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group" id="hosp" style="display: none">
										<label> Pick A Blood Bank Center (Hospital) </label>
										<select name="hopistals" class="form-control">
											<option id="all_centers"> All Centers </option>

											<?php
												$select = mysqli_query($db_link, 
												"SELECT DISTINCT(requested_hosp) FROM `request_tbl`");
												foreach($select as $rows){
													echo '<option id="'.$rows['requested_hosp'].'" value="'.$rows['requested_hosp'].'">
														'.$rows['requested_hosp'].'</option>';
												}
											?>										</select>
									</div>
									<br/>
									<br/>
									<input type="submit" name="submit" value="Get Report" />
								</form>
								</div>
							
								
							</div>
							<div class="row">
								<div class="col-md-6">
								<h4>Donation City Distrubtion<h4>
								</div>
								<div class="col-md-6">
								<h4>Donation Blood Groups Distrubtion</h4>
								<?php 
									$getBloodDonation = mysqli_query($db_link, "SELECT blood_group, 
																	COUNT(blood_group) as TOTAL FROM users_tbl GROUP BY blood_group");
									// while()
									
								?>
								<canvas id="bloodChart" width="400" height="400"></canvas>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-6">
								<h4>Donation Receiver - Donors Distrubtion</h4>
								<canvas id="myChart" width="400" height="400"></canvas>

								<div id="chart"></div>
								</div>
								<div class="col-md-6">

								</div>
								
							</div>
	    
	    </div>
	    
	<script type="text/javascript">
	
		function reportSelectOptions(select){
			console.log(select.value);
			if(select.value == 'blood_group' ){
				document.getElementById('blood_group_list').style.display = "block" 
				document.getElementById('provinces').style.display = "none" 
				document.getElementById('hosp').style.display = "none" 
			}else if(select.value == 'Hospital Search'){
				document.getElementById('blood_group_list').style.display = "none" 
				document.getElementById('provinces').style.display = "none" 
				document.getElementById('hosp').style.display = "block" 
			}else if(select.value == 'Report Per Province'){
				document.getElementById('blood_group_list').style.display = "none" 
				document.getElementById('provinces').style.display = "block" 
				document.getElementById('hosp').style.display = "none" 
			}else{
				document.getElementById('blood_group_list').style.display = "none" 
				document.getElementById('provinces').style.display = "none" 
				document.getElementById('hosp').style.display = "none" 
			}
		}

		function showBloodGraph(){
			{
				$.post("ajax_calls/blood.php",
					function (blood_data){
						// console.log(blood_data);
						var blood_group = [];
						var blood_num = [];
						for (var i in blood_data){
							blood_group.push(blood_data[i].type_of_user);
							blood_num.push(blood_data[i].total);

						}
						// console.log(blood_group)
						// console.log(blood_num)
						var chartData = {
							labels: blood_group,
							datasets: [{
								label: 'Blood Group',
								backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: blood_num
							}]
						};

						var bloodTarget = $("#bloodChart");

						var barGraph = new Chart(bloodTarget, {
							type: 'bar',
							data: chartData
						});
					});
			}
		}

	</script>
	<?php 
	$getAllReceiversSQL = mysqli_query($db_link, "SELECT users_tbl.type_of_user, COUNT(*) as total FROM request_tbl as req_tbl, users_tbl  
	WHERE req_tbl.requesting_id = users_tbl.user_id  OR req_tbl.requester_id = users_tbl.user_id 
	GROUP BY users_tbl.type_of_user");
	
	
	
	$data = array();
	
	foreach($getAllReceiversSQL as $rows){
		$data[] = $rows;
	}

	for($i=0; $i< sizeof($data); $i++){
		// echo $data['type_of_user'];
	}



	$getData = json_encode($data);
	// echo $getData;
	
?>
<script>
	var blood_group = [];
	var blood_num = [];
	for (var i in blood_data){
		blood_group.push(blood_data[i].type_of_user);
		blood_num.push(blood_data[i].total);

	}
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php include "ajax_calls/blood.php"; ?>
<script>
var data = {
	labels : ["January","February","March",
              "April","May","June",
              "July","Agost","September",
              "October","November","December"],
	datasets : [
		{
			fillColor : "rgba(252,233,79,0.5)",
			strokeColor : "rgba(82,75,25,1)",
			pointColor : "rgba(166,152,51,1)",
			pointStrokeColor : "#fff",
			data : <?php echo $get[1]; ?>
		}
	]
}


var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }

//Get context with jQuery - using jQuery's .get() method.
var ctx = $("#myChart").get(0).getContext("2d");


new Chart(ctx).Line(data,options);
</script>
</body>
</html>