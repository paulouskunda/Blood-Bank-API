<?php

$ServerName = "localhost";
$DbUsername = "root";
$DbPassword =  "";
$Dbname ="bbms";

$db_link =mysqli_connect($ServerName, $DbUsername, $DbPassword, $Dbname);

if(!$db_link){
    die("conection failled ".mysqli_connect_error());
}
?>
