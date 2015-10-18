<?php

include("config.php");
$id=$_GET['id'];
$latitude=$_GET['latitude'];
$longitude=$_GET['longitude'];



$sqlUpdate = " UPDATE users SET  latitude='".$latitude."' , longitude='".$longitude."'   WHERE id = '".$id."' ";

if ($conn->query($sqlUpdate) === TRUE) {
	if($on_party==0){
    $arr = array('error' => "sucess", "message"=>"update successfully");
    echo json_encode($arr);
	} 
} else {
     $arr = array('error' => "failed", "message"=>" unable to update retry!!");
    echo json_encode($arr);
}

$conn->close();

?>