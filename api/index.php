<?php
        require_once '../includes/conn.php';
        require_once '../functions.php';
    
    
        // function validating all the paramters are available
        // we will pass the required parameters to this function 
        function isTheseParametersAvailable($params){
            //assuming all parameters are available 
            $available = true; 
            $missingparams = ""; 
            
            foreach($params as $param){
                if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
                    $available = false; 
                    $missingparams = $missingparams . ", " . $param; 
                }
            }
            
            //if parameters are missing 
            if(!$available){
                $response = array(); 
                $response['error'] = true; 
                $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
                
                //displaying error
                echo json_encode($response);
                
                //stopping further execution
                die();
            }
        }
    
        $response = array();

    //if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call
	if(isset($_GET['apicall'])){
		switch ($_GET['apicall']) {


			//if the api call value is 'login'
            //we will check if the users exists in the database and log them in or ask them to sign up of they don't
			case 'login':
                # code...
                isTheseParametersAvailable(array("username", "password"));
                $username = mysqli_real_escape_string($db_link, $_POST['username']);
                $password = mysqli_real_escape_string($db_link, $_POST['password']);

                if(isset($username, $password)){
                    $check_login = loginUser($db_link, $username, $password);
                    if(!$check_login){
                        $response['error'] = "true";
                        $response['message'] = "Wrong password or username";
                    }else{
                        // $userExtenal = array();
                        $userDetails = array();

                        while($row = mysqli_fetch_assoc($check_login)){
                            // $userDetails = array();
                            $userDetails['id'] = $row['user_id'];
                            $userDetails['name'] = $row['name'];
                            $userDetails['email'] = $row['email'];
                            $userDetails['phone_number'] = $row['phone_number'];
                            $userDetails['physical_address'] = $row['physical_address'];
                            $userDetails['password'] = $row['password'];
                            $userDetails['type_of_user'] = $row['type_of_user'];
                            $userDetails['blood_group'] = $row['blood_group'];
                            $userDetails['city'] = $row['city'];
                            $userDetails['province'] = $row['province'];
                            // array_push($userExtenal, $userDetails);
                            
                        }

                        $response['error'] = false;
                        $response['message'] = $userDetails;
                    }
                }

                break;
                case 'sign_up':
                    isTheseParametersAvailable(array('name', 'email', 'phone_number',
                     'physical_address', 'password', 'blood_group', 'user_type', 'why_give_blood',
                      'city', 'province'));
                    
                     $name = mysqli_real_escape_string($db_link, $_POST['name']);
                     $email = mysqli_real_escape_string($db_link, $_POST['email']);
                     $phone_number = mysqli_real_escape_string($db_link, $_POST['phone_number']);
                     $physical_address = mysqli_real_escape_string($db_link, $_POST['physical_address']);
                     $password = mysqli_real_escape_string($db_link, $_POST['password']);
                     $blood_group = mysqli_real_escape_string($db_link, $_POST['blood_group']);
                     $user_type = mysqli_real_escape_string($db_link, $_POST['user_type']);
                     $why_give_blood = mysqli_real_escape_string($db_link, $_POST['why_give_blood']);
                     $city = mysqli_real_escape_string($db_link, $_POST['city']);
                     $province = mysqli_real_escape_string($db_link, $_POST['province']);


                     $userSignDetials = array("name"=> $name, "email" => $email,
                     "phone_number"=> $phone_number, "physical_address" => $physical_address,
                    "password" => $password, "blood_group" => $blood_group, "user_type" => $user_type,
                    "why_give_blood" => $why_give_blood, "city" => $city, "province" => $province);


                    $sign_me_up = addNewUser($db_link, $userSignDetials);

                    if($sign_me_up === "already_created"){
                        $response["error"] = true;
                        $response["message"] = "User with ".$email." already in the system";
                    }else if($sign_me_up === "phone_number_exists"){
                        $response["error"] = true;
                        $response["message"] = "User with the ".$phone_number." already in the system";
                    }else if(!$sign_me_up){
                        $response["error"] = true;
                        $response["message"] = "We encounter an error";
                    }else {
                        $response['error'] = false;
                        $response['message'] = "Signed in";
                    }
                break;

                case 'request_blood':
                    isTheseParametersAvailable(array('requesting_id', 'requester_id',
                    'request_blood_group', 'requested_hosp', 'requested_city', 'request_status', 'request_date'));

                    $requesting_id = mysqli_real_escape_string($db_link, $_POST['requesting_id']);
                    $requester_id = mysqli_real_escape_string($db_link, $_POST['requester_id']);
                    $request_blood_group = mysqli_real_escape_string($db_link, $_POST['request_blood_group']);
                    $requested_hosp = mysqli_real_escape_string($db_link, $_POST['requested_hosp']);
                    $requested_city = mysqli_real_escape_string($db_link, $_POST['requested_city']);
                    $request_status = mysqli_real_escape_string($db_link, $_POST['request_status']);
                    $request_date = mysqli_real_escape_string($db_link, $_POST['request_date']);

                    $request_feed = requestBlood($db_link, $requesting_id, $requester_id, $request_blood_group,
                                                $requested_city, $requested_hosp, $request_status, $request_date);
                    
                    if($request_feed === 'waiting_approval'){
                        $response['error'] = true;
                        $response['message'] = $request_feed;
                    }else if($request_feed === 'Request_added'){
                        $response['error'] = false;
                        $response['message'] = $request_feed;
                    }else{
                        $response['error'] = true;
                        $response['message'] = $request_feed;
                    }
                    
                break;

                case 'get_hospital':
                    isTheseParametersAvailable(array('city'));
                    $city = mysqli_real_escape_string($db_link, $_POST['city']);
                    $hospitals = existingHospitals($db_link, $city);
                    // echo $hospitals;
                    if($hospitals != false){
                        $hospitals_list = array();
                        while($rows = mysqli_fetch_assoc($hospitals)){
                            $inner_array = array();
                            $inner_array['hosp_id'] = $rows['hosp_id'];
                            $inner_array['hosp_name'] = $rows['hosp_name'];
                            $inner_array['hosp_city'] = $rows['hosp_city'];
                            $inner_array['hosp_location'] = $rows['hosp_location'];
                            $inner_array['hosp_address'] = $rows['hosp_address'];
                            $inner_array['hosp_lat'] = $rows['hosp_lat'];
                            $inner_array['hosp_long'] = $rows['hosp_long'];
                            array_push($hospitals_list, $inner_array);
                        }

                        $response['error'] = false;
                        $response['message'] = $hospitals_list;
                    }else{
                        $response['error'] = true;
                        $response['message'] = "Try again later...";
                    }
                break;
                case 'get_hospital_cord':
                    isTheseParametersAvailable(array('lat', 'long'));
                    $lat = mysqli_real_escape_string($db_link, $_POST['lat']);
                    $long = mysqli_real_escape_string($db_link, $_POST['long']);
                    $hospitals = existingHospitalsLatLong($db_link, $lat, $long);
                    // echo $hospitals;
                    if($hospitals === 'no_record'){
                        $response['error'] = true;
                        $response['message'] = $hospitals;
                    }else if($hospitals == false){
                        $response['error'] = true;
                        $response['message'] = $hospitals;
                    }
                    else{
                        $hospitals_list = array();
                        while($rows = mysqli_fetch_assoc($hospitals)){
                            $inner_array = array();
                            $inner_array['hosp_id'] = $rows['hosp_id'];
                            $inner_array['hosp_name'] = $rows['hosp_name'];
                            $inner_array['hosp_city'] = $rows['hosp_city'];
                            $inner_array['hosp_location'] = $rows['hosp_location'];
                            $inner_array['hosp_address'] = $rows['hosp_address'];
                            $inner_array['hosp_lat'] = $rows['hosp_lat'];
                            $inner_array['hosp_long'] = $rows['hosp_long'];
                            $inner_array['distance'] = $rows['distance'];
                            array_push($hospitals_list, $inner_array);
                       
                    }
                    $response['error'] = false;
                    $response['message'] = $hospitals_list;
                }
                break;
                case 'pending_requests':
                    isTheseParametersAvailable(array('requesting_id', 'status'));
                    $requesting_id = mysqli_real_escape_string($db_link, $_POST['requesting_id']);
                    // $requester_id = mysqli_real_escape_string($db_link, $_POST['requester_id']);
                    $status = mysqli_real_escape_string($db_link, $_POST['status']);

                    $waitingList = getAllWaiting($db_link, $status, $requesting_id);

                    if($waitingList == false){
                        $response['error'] = true;
                        $response['message'] = "We encountered an error";
                    }else if($waitingList == 'no_report'){
                        $response['error'] = true;
                        $response['message'] = "No pending list";
                    }else{
                        $waitingListArray = array();
                        while($rows = mysqli_fetch_assoc($waitingList)){
                            $inner_Waiting = array();
                            $inner_Waiting['req_id'] = $rows['req_id'];
                            $inner_Waiting['requester_id'] = $rows['requester_id'];
                            $inner_Waiting['requesting_id'] = $rows['requesting_id'];
                            $inner_Waiting['request_blood_group'] = $rows['request_blood_group'];
                            $inner_Waiting['requested_city'] = $rows['requested_city'];
                            $inner_Waiting['requested_hosp'] = $rows['requested_hosp'];
                            $inner_Waiting['request_date'] = $rows['request_date'];
                            $inner_Waiting['reasonForBlood'] = $rows['reasonForBlood'];
                            $inner_Waiting['type_of_user'] = $rows['type_of_user'];
                            $inner_Waiting['name'] = $rows['name'];
                            
                            array_push($waitingListArray, $inner_Waiting);
                        }
                        $response['error'] = false;
                        $response['message'] = $waitingListArray;
                    }
                break;  
                case 'pending_requests_donor':
                    isTheseParametersAvailable(array('requesting_id', 'status'));
                    $requesting_id = mysqli_real_escape_string($db_link, $_POST['requesting_id']);
                    // $requester_id = mysqli_real_escape_string($db_link, $_POST['requester_id']);
                    $status = mysqli_real_escape_string($db_link, $_POST['status']);

                    $waitingList = getAllWaitingDonor($db_link, $status, $requesting_id);

                    if($waitingList == false){
                        $response['error'] = true;
                        $response['message'] = "We encountered an error";
                    }else if($waitingList == 'no_report'){
                        $response['error'] = true;
                        $response['message'] = "No pending list";
                    }else{
                        $approvedList = array();
                        while($rows = mysqli_fetch_assoc($approvedList)){
                            $inner_Waiting = array();
                            $inner_Waiting['req_id'] = $rows['req_id'];
                            $inner_Waiting['requester_id'] = $rows['requester_id'];
                            $inner_Waiting['requesting_id'] = $rows['requesting_id'];
                            $inner_Waiting['request_blood_group'] = $rows['request_blood_group'];
                            $inner_Waiting['requested_city'] = $rows['requested_city'];
                            $inner_Waiting['requested_hosp'] = $rows['requested_hosp'];
                            $inner_Waiting['request_date'] = $rows['request_date'];
                            $inner_Waiting['reasonForBlood'] = $rows['reasonForBlood'];
                            $inner_Waiting['type_of_user'] = $rows['type_of_user'];
                            $inner_Waiting['name'] = $rows['name'];
                            
                            array_push($approvedList , $inner_Waiting);
                        }
                        $response['error'] = false;
                        $response['message'] = $approvedList;
                    }
                break;
                case 'approved_requests':
                    isTheseParametersAvailable(array('requesting_id', 'status'));
                    $requesting_id = mysqli_real_escape_string($db_link, $_POST['requesting_id']);
                    $status = mysqli_real_escape_string($db_link, $_POST['status']);

                    $approvedList = getAllist($db_link, $status, $requesting_id);

                    if($approvedList == false){
                        $response['error'] = true;
                        $response['message'] = "We encountered an error";
                    }else if($approvedList == 'no_report'){
                        $response['error'] = true;
                        $response['message'] = "No Approved list";
                    }else{
                        $approvedListArray = array();
                        while($rows = mysqli_fetch_assoc($approvedList)){
                            $inner_approved = array();
                            $inner_approved['req_id'] = $rows['req_id'];
                            $inner_approved['requester_id'] = $rows['requester_id'];
                            $inner_approved['requesting_id'] = $rows['requesting_id'];
                            $inner_approved['request_blood_group'] = $rows['request_blood_group'];
                            $inner_approved['requested_city'] = $rows['requested_city'];
                            $inner_approved['requested_hosp'] = $rows['requested_hosp'];
                            $inner_approved['type_of_user'] = $rows['type_of_user'];
                            $inner_approved['request_date'] = $rows['request_date'];
                            $inner_approved['request_status'] = $rows['request_status'];
                            $inner_approved['name'] = $rows['name'];
                            $inner_approved['reasonForBlood'] = "null";

                            array_push($approvedListArray, $inner_approved);
                        }
                        $response['error'] = false;
                        $response['message'] = $approvedListArray;
                    }
                break;
                case 'approved_requests_donor':
                    isTheseParametersAvailable(array('requester_id', 'status'));
                    $requesting_id = mysqli_real_escape_string($db_link, $_POST['requester_id']);
                    $status = mysqli_real_escape_string($db_link, $_POST['status']);

                    $approvedList = getAllistDonor($db_link, $status, $requesting_id);

                    if($approvedList == false){
                        $response['error'] = true;
                        $response['message'] = "We encountered an error";
                    }else if($approvedList == 'no_report'){
                        $response['error'] = true;
                        $response['message'] = "No Approved list";
                    }else{
                        $approvedListArray = array();
                        while($rows = mysqli_fetch_assoc($approvedList)){
                            $inner_approved = array();
                            $inner_approved['req_id'] = $rows['req_id'];
                            $inner_approved['requester_id'] = $rows['requester_id'];
                            $inner_approved['requesting_id'] = $rows['requesting_id'];
                            $inner_approved['request_blood_group'] = $rows['request_blood_group'];
                            $inner_approved['requested_city'] = $rows['requested_city'];
                            $inner_approved['requested_hosp'] = $rows['requested_hosp'];
                            $inner_approved['type_of_user'] = $rows['type_of_user'];
                            $inner_approved['request_date'] = $rows['request_date'];
                            $inner_approved['request_status'] = $rows['request_status'];
                            $inner_approved['name'] = $rows['name'];
                            $inner_approved['reasonForBlood'] = "null";
                            array_push($approvedListArray, $inner_approved);
                        }
                        $response['error'] = false;
                        $response['message'] = $approvedListArray;
                    }
                break;
                case 'accept_reject_request':
                    isTheseParametersAvailable(array('status', 'req_id'));
                    $staus_ = mysqli_real_escape_string($db_link, $_POST['status']);
                    $req_id = mysqli_real_escape_string($db_link, $_POST['req_id']);

                    $updateMe = updateRequestStatus($db_link, $req_id, $staus_);

                    if($updateMe == false){
                        $response['error'] = true;
                        $response['message'] = "An error was encounted";
                    }else{
                        $response['error'] = false;
                        $response['message'] = $updateMe;
                    }

                break; 
                case 'get_donors':
                    # code...
                    isTheseParametersAvailable(array("city"));
                    $city = mysqli_real_escape_string($db_link, $_POST['city']);
    
                    if(isset($city)){
                        $getDonors = getAllDonors($db_link, $city);
                        if($getDonors == false){
                            $response['error'] = "true";
                            $response['message'] = "Wrong password or username";
                        }else if ($getDonors == "no_report"){
                            $response['error'] = "true";
                            $response['message'] = "No match";
                        }else{
                            $userExtenal = array();
    
                            while($row = mysqli_fetch_assoc($getDonors)){
                                $userDetails = array();
                                $userDetails['id'] = $row['user_id'];
                                $userDetails['name'] = $row['name'];
                                $userDetails['email'] = $row['email'];
                                $userDetails['phone_number'] = $row['phone_number'];
                                $userDetails['physical_address'] = $row['physical_address'];
                                $userDetails['password'] = $row['password'];
                                $userDetails['type_of_user'] = $row['type_of_user'];
                                $userDetails['blood_group'] = $row['blood_group'];
                                $userDetails['city'] = $row['city'];
                                $userDetails['province'] = $row['province'];
                                array_push($userExtenal, $userDetails);
                                
                            }
    
                            $response['error'] = false;
                            $response['message'] = $userExtenal;
                        }
                    }
    
                    break;   
                    case 'giveBlood':
                        isTheseParametersAvailable(array('don_id_ref','donor_name', 'donor_blood_group',
                         'donor_hospital', 'donor_date', 'donor_reason', 'donor_city'));

                         $don_id_ref = mysqli_real_escape_string($db_link, $_POST['don_id_ref']);
                         $donor_name = mysqli_real_escape_string($db_link, $_POST['donor_name']);
                         $donor_blood_group = mysqli_real_escape_string($db_link, $_POST['donor_blood_group']);
                         $donor_hospital = mysqli_real_escape_string($db_link, $_POST['donor_hospital']);
                         $donor_date = mysqli_real_escape_string($db_link, $_POST['donor_date']);
                         $donor_reason = mysqli_real_escape_string($db_link, $_POST['donor_reason']);
                         $donor_city = mysqli_real_escape_string($db_link, $_POST['donor_city']);

                         if(isset($don_id_ref, $donor_name)){
                             $passDonationRecords = array("don_id_ref" => $don_id_ref, "donor_name" => $donor_name,
                            "donor_blood_group" => $donor_blood_group, "donor_hospital" => $donor_hospital, 
                            "donor_date" => $donor_date, "donation_reason" => $donor_reason, "donor_city" => $donor_city);
                             $getInsertDonation = addDonation($db_link, $passDonationRecords);
                             if($getInsertDonation == 'inserted'){
                                 $response['error'] = false;
                                 $response['message'] = "Inserted";
                             }else if($getInsertDonation  == "no_two_dates"){
                                $response['error'] = true;
                                $response['message'] = "You can't give blood twice on the same day. Date already booked";
                            }else {
                                $response['error'] = true;
                                $response['message'] = "We encountered an error";
                             }
                         }

                    break;
                    case 'getGivenBlood':
                        isTheseParametersAvailable(array('don_id_ref'));
                        $don_id_ref = mysqli_real_escape_string($db_link, $_POST['don_id_ref']);

                        $getAllDonations = getAllGiveBlood($db_link, $don_id_ref);
                        if($getAllDonations == 'no_record'){
                            $response['error'] = true;
                            $response['message'] = "It seems you don't have any records yet... ";
                        }else if($getAllDonations == false){
                            $response['error'] = true;
                            $response['message'] = "We encountered an error";
                        }else{
                            $externalArray = array();
                            while($rows = mysqli_fetch_assoc($getAllDonations)){
                                $internalArray = array();
                                $todaysDate = date('d/m/Y');
                                if(strtotime($rows['donor_date']) < strtotime($todaysDate)){
                                    continue;
                                }else{
                                    $internalArray['don_id'] = $rows['don_id'];
                                    $internalArray['don_id_ref'] = $rows['don_id_ref'];
                                    $internalArray['donor_name'] = $rows['donor_name'];
                                    $internalArray['donor_blood_group'] = $rows['donor_blood_group'];
                                    $internalArray['donor_hospital'] = $rows['donor_hospital'];
                                    $internalArray['donation_reason'] = $rows['donation_reason'];
                                    $internalArray['donor_date'] = $rows['donor_date'];
                                    $internalArray['donor_city'] = $rows['donor_city'];
                                    $internalArray['today'] = $todaysDate;
                                    array_push($externalArray, $internalArray);
                                }

                            }

                            $response['error'] = false;
                            $response['message'] = $externalArray;
                        }
                    break;
               
            }
    }else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	//displaying the response in json structure 
    echo json_encode($response, JSON_PRETTY_PRINT);
?>
