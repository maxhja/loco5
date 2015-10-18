<?php

// server values
$servername = "localhost";
$username = "posdima_user";
$password = "loco@123";
$dbname = "posdima_loco";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	$arr = array('error' => "error", "message"=>"Connection failed");
    echo json_encode($arr);
} 


?>