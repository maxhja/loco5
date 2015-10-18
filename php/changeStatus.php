<?php

include("config.php");
$id=$_GET['id'];
$on_party=$_GET['on_party'];
$date=$_GET['date'];
$latitude=$_GET['latitude'];
$longitude=$_GET['longitude'];



$sqlUpdate = " UPDATE users SET on_party = '".$on_party."' , date='".$date."', latitude='".$latitude."' , longitude='".$longitude."'   WHERE id = '".$id."' ";

if ($conn->query($sqlUpdate) === TRUE) {
	if($on_party==0){
    $arr = array('error' => "sucess", "message"=>"Party");
    echo json_encode($arr);
	} else{
	$arr = array('error' => "sucess", "message"=>"Home");
    echo json_encode($arr);
    }
} else {
     $arr = array('error' => "failed", "message"=>" unable to update retry!!");
    echo json_encode($arr);
}

$conn->close();

?>