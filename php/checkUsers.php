<?php

include("config.php");
$id=$_GET['id'];
$name=$_GET['name'];
$date=$_GET['date'];

$sqlSelectUser = " SELECT * FROM users where id='".$id."' and name = '".$name."'   ";
$resultSelectUser = $conn->query($sqlSelectUser);


if ($resultSelectUser->num_rows > 0) {


    // output data of each row
    $arr = array('error' => "sucess", "message"=>"user exist !!");
    echo json_encode($arr);

} else {

$sqlInsertUser = "INSERT INTO users (id, name ,date )
VALUES ('".$id."', '".$name."', '".$date."')";

if ($conn->query($sqlInsertUser) === TRUE) {
    
    $arr = array('error' => "sucess", "message"=>"New record created successfully !!");
    echo json_encode($arr);


} else {
    $arr = array('error' => "failed", "message"=>" unable to record !!");
    echo json_encode($arr);
}



    
}


$conn->close();







?>