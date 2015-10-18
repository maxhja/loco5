<?php

include("config.php");
$from_id=$_GET['from_id'];
$to_id=$_GET['to_id'];



$sqlUpdate = " UPDATE friendship SET status = '1' WHERE from_id = '".$from_id."'  and to_id = '".$to_id."' ";

if ($conn->query($sqlUpdate) === TRUE) {
    $arr = array('error' => "sucess", "message"=>"accepted");
    echo json_encode($arr);
  
} else {
     $arr = array('error' => "failed", "message"=>" unable to accept retry!!");
    echo json_encode($arr);
}

$conn->close();

?>