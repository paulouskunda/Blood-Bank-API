<?php
// header('Content-Type: application/json');

require_once '../includes/conn.php';
// require_once '../../functions.php';

$getAllReceiversSQL = mysqli_query($db_link, "SELECT users_tbl.type_of_user, COUNT(*) as total FROM request_tbl as req_tbl, users_tbl  
WHERE req_tbl.requesting_id = users_tbl.user_id  OR req_tbl.requester_id = users_tbl.user_id 
GROUP BY users_tbl.type_of_user");



$data = array();

foreach($getAllReceiversSQL as $rows){
    $data[] = $rows;
}

mysqli_close($db_link);

json_encode($data);

?>