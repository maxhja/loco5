<?php

include("config.php");
$id=$_GET['id'];
$weight=$_GET['weight'];
$gender=$_GET['gender'];


$sqlUpdate = " UPDATE users SET gender = '".$gender."' , weight = '".$weight."'  WHERE id = '".$id."' ";

if ($conn->query($sqlUpdate) === TRUE) {


  
  $arr = array('error' => "sucess", "message"=>$message);
    echo json_encode($arr);
    
} else {
     $arr = array('error' => "failed", "message"=>" unable to update retry!!");
    echo json_encode($arr);
}


$conn->close();

?>