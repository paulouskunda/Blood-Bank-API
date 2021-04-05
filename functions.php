<?php

/**
* @param $db_link: Connection link to the database
* @param $_id:  identification code
* @param $password
* @return error/false/query: return boolean or string of the error 
*/

function addNewUser($db_link, $donor_array_details){
	$email = "";
	if(checkTheMail($db_link, $donor_array_details['email'])){
		return "already_created";
	}else if(checkThePhoneNumber($db_link, $donor_array_details['phone_number'])){
		return "phone_number_exists";
	}else{
		$insert = "INSERT INTO users_tbl (name, email, phone_number, physical_address, password, type_of_user, user_type, city, province)
		 VALUES ('".$donor_array_details['name']."', 
		 '".$donor_array_details['email']."', 
		'".$donor_array_details['phone_number']."', 
		'".$donor_array_details['physical_address']."',
		 '".$donor_array_details['password']."',
		'".$donor_array_details['user_type']."',
		'".$donor_array_details['blood_group']."',
		'".$donor_array_details['city']."',
		'".$donor_array_details['province']."') ";

		if (mysqli_query($db_link, $insert)) {
			return "user added sucessfully ";
		}else{
			return false;
		}
	}
}


function checkTheMail($db_link, $email){
	$select_donor = "SELECT * FROM users_tbl WHERE email = '$email'";
	if (mysqli_num_rows(mysqli_query($db_link, $select_donor)) > 0) {
		return true;
	}else {
		return false;
	}
}


function checkThePhoneNumber($db_link, $phone_number){
	$select_donor = "SELECT * FROM users_tbl WHERE phone_number = '$phone_number'";
	if (mysqli_num_rows(mysqli_query($db_link, $select_donor)) > 0) {
		return true;
	}else {
		return false;
	}
}


function addHospital($db_link,  $hospital_name, $hospital_city, $hospital_location, $hospital_address, $hospital_lat, $hospital_long){

	if(checkHospitalName($db_link, $hospital_name)){
		return "hospital_name_exits";
	}else{
				$hospitalData = "INSERT INTO hospital_tbl (hosp_name, hosp_city, hosp_location, hosp_address, hosp_lat, hosp_long) VALUES ('$hospital_name','$hospital_city', '$hospital_location', '$hospital_address', '$hospital_lat', '$hospital_long')";
		if (mysqli_query($db_link, $hospitalData)) {
			return "hospital_added";
		}else{
			// echo mysqli_error($db_link);
			return false;
		}
	}
}
function checkHospitalName($db_link, $hospital_name){
	$check_name = "SELECT * FROM hospital_tbl WHERE hosp_name = '$hospital_name'";

	if (mysqli_num_rows(mysqli_query($db_link, $check_name)) > 0)
		return true;
	else
		return false;
}
function existingHospitals($db_link, $city){
	$check_name= "SELECT * FROM hospital_tbl WHERE hosp_city = '$city'";

	if (mysqli_num_rows(mysqli_query($db_link, $check_name)) > 0)

		return mysqli_query($db_link, $check_name);
	else
		echo mysqli_error($db_link);
		return false;
}

function existingHospitalsLatLong($db_link, $lat, $long){
	// Quary to calculate distance of the current locationg
	// url => https://developers.google.com/maps/solutions/store-locator#creating-the-maphttps://developers.google.com/maps/solutions/store-locator#creating-the-map
	$check_the_distance_SQL = "SELECT 
								*, 
								(
									6371 *
									acos(cos(radians($lat)) * 
									cos(radians(hosp_lat)) * 
									cos(radians(hosp_long) - 
									radians($long)) + 
									sin(radians($lat)) * 
									sin(radians(hosp_lat )))
								) AS distance 
								FROM hospital_tbl 
								HAVING distance < 50 and distance >= 0
								ORDER BY distance LIMIT 0, 20";

	if (mysqli_num_rows(mysqli_query($db_link, $check_the_distance_SQL)) > 0)

		return mysqli_query($db_link, $check_the_distance_SQL);
	else if(mysqli_num_rows(mysqli_query($db_link, $check_the_distance_SQL)) === 0)
		return "no_record";
	else
		return false;
}

function requestBlood($db_link, $requesting_id, $requester_id, $blood_group, $request_city, $hospital_requuest, $status, $date){

	if(checkStatus($db_link,$requesting_id, $requester_id, $status)){
		return "waiting_approval";
	}else{
				$requestData = "INSERT INTO request_tbl (requester_id, requesting_id, request_blood_group, 
				requested_city, requested_hosp, request_status, request_date) 
				VALUES ('$requester_id', '$requesting_id', '$blood_group', '$request_city', '$hospital_requuest', '$status', '$date')";
		if (mysqli_query($db_link, $requestData)) {
			return "Request_added";
		}else{
			
			return mysqli_error($db_link);
		}
	}
}
function checkStatus($db_link, $requesting_id, $requester_id, $status){
	$check_status = "SELECT * FROM request_tbl WHERE requesting_id = '$requesting_id' AND requester_id = '$requester_id' AND request_status = '$status'";

	if (mysqli_num_rows(mysqli_query($db_link, $check_status)) > 0)
		return true;
	else
		return false;
}
function existingStatus($db_link){
	$check_status= "SELECT * FROM request_tbl";

	if (mysqli_num_rows(mysqli_query($db_link, $check_status)) > 0)

		return mysqli_query($db_link, $check_status);
	else
		return mysqli_error($db_link);
}

function loginUser($db_link, $username, $userpassword){
	$check_user = "SELECT * FROM users_tbl WHERE password = '$userpassword' AND email = '$username' OR phone_number = '$username' ";
	$runSQL = mysqli_query($db_link, $check_user);
	if(mysqli_num_rows($runSQL) > 0)
		return $runSQL;
	else
		return false;

}

function updateRequestStatus($db_link, $req_id, $status_update){
	$updateRequestStatusSql = "UPDATE request_tbl SET request_status = '$status_update' WHERE req_id = '$req_id'";
	if(mysqli_query($db_link, $updateRequestStatusSql)){
		return "status changed to ".$status_update;
	}else{
		echo mysqli_error($db_link);
		return false;
	}
}

function getAllist($db_link, $status, $requesting_id){
	$getPendingRequest = "SELECT req.requesting_id, req.requester_id, req.request_status,
	req.req_id, req.request_blood_group, req.requested_city, req.requested_hosp, req.request_date,
	users.name, req.reasonForBlood, users.type_of_user
	FROM users_tbl as users, request_tbl as req 
	WHERE req.request_status = 'accepted' OR req.request_status = 'rejected' AND req.requesting_id = users.user_id
	AND req.requesting_id  = '$requesting_id' GROUP BY req.request_status";
	
	$runMeUp = mysqli_query($db_link, $getPendingRequest);
	if(mysqli_num_rows($runMeUp)>0){
		return $runMeUp;
	}else if(mysqli_num_rows($runMeUp) == 0){
		return "no_report";
	}else
		{
			echo mysqli_error($db_link);
			return false;
		}
}
function getAllistDonor($db_link, $status, $requesting_id){
	$getPendingRequest = "SELECT * FROM request_tbl WHERE  request_status = 'accepted' OR request_status = 'rejected'
	AND requester_id = '$requesting_id'";
	
	$runMeUp = mysqli_query($db_link, $getPendingRequest);
	if(mysqli_num_rows($runMeUp)>0){
		return $runMeUp;
	}else if(mysqli_num_rows($runMeUp) == 0){
		return "no_report";
	}else{
		echo mysqli_error($db_link);
		return false;

	}
}


function getAllWaiting($db_link, $status, $requesting_id){
	$getPendingRequest = "SELECT req.requesting_id, req.requester_id, req.request_status,
	req.req_id, req.request_blood_group, req.requested_city, req.requested_hosp, req.request_date,
	users.name, req.reasonForBlood, users.type_of_user
	FROM users_tbl as users, request_tbl as req 
	WHERE req.request_status = 'waiting' AND req.requester_id = users.user_id
	AND req.requesting_id = '$requesting_id' OR req.requester_id  = '$requesting_id'";
	
	$runMeUp = mysqli_query($db_link, $getPendingRequest);
	if(mysqli_num_rows($runMeUp)>0){
		return $runMeUp;
	}else if(mysqli_num_rows($runMeUp)){
		return "no_report";
	}else{
		echo mysqli_error($db_link);
		return false;
	}
}

function getAllWaitingDonor($db_link, $status, $requesting_id){
	$getPendingRequest = "SELECT req.requesting_id, req.requester_id, req.request_status,
	req.req_id, req.request_blood_group, req.requested_city, req.requested_hosp, req.request_date,
	users.name, req.reasonForBlood, users.type_of_user
	FROM users_tbl as users, request_tbl as req 
	WHERE req.request_status = 'waiting' AND req.requesting_id = users.user_id
	AND req.requester_id  = '$requesting_id'";
	
	$runMeUp = mysqli_query($db_link, $getPendingRequest);
	if(mysqli_num_rows($runMeUp)>0){
		return $runMeUp;
	}else if(mysqli_num_rows($runMeUp)){
		return "no_report";
	}else{
		echo mysqli_error($db_link);
		return false;
	}
}
function getAllDonors($db_link, $city){
	$getAllDonors = "SELECT * FROM users_tbl WHERE type_of_user = 'donor' 
	AND city = '$city' ";
	
	$runMeUp = mysqli_query($db_link, $getAllDonors);
	if(mysqli_num_rows($runMeUp)>0){
		return $runMeUp;
	}else if(mysqli_num_rows($runMeUp) == 0){
		return "no_report";
	}else{
		echo mysqli_error($db_link);
		return false;
	}
}

function addDonor($db_link, $donor_name, $d_blood_group, $d_hospital, $reason, $donating_date, $city){

	if (checkDonatingDay($db_link, $donating_date)) {
		return " you_already_booked";
	}else{
		$donorData = "INSERT INTO donate_blood (donor_name,  donor_blood_group, donor_hospital, donation_reason, donor_date, donor_city) VALUES ('$donor_name', '$d_blood_group', '$d_hospital', '$reason', '$donating_date', '$city')";
		if (mysqli_query($db_link, $donorData)) {
			# code...
			return true;
		}else{
			return mysqli_error($db_link);
		}
	}
}
function checkDonatingDay($db_link, $donating_date){
	$select_date = "SELECT * FROM donate_blood WHERE donor_date = '$donating_date'";

	if (mysqli_num_rows(mysqli_query($db_link, $select_date)) > 0)
		return true;
	else
		return false;
}




function donatingDay($db_link){
	$select_date = "SELECT * FROM donate_blood";

	if (mysqli_num_rows(mysqli_query($db_link, $select_date)) > 0)

		return mysqli_query($db_link, $select_date);
	else
		return mysqli_error($db_link);
}


?>