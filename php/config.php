<?php

// server values
$servername = "afuriqa.com.mysql";
$username = "afuriqa_com";
$password = "NR3BRMHd";
$dbname = "afuriqa_com";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	$arr = array('error' => "error", "message"=>"Connection failed");
    echo json_encode($arr);
} 


?>