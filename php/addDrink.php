<?php

include("config.php");
$id=$_GET['id'];
$bottle_size=$_GET['bottle_size'];
$alcool_percentage=$_GET['alcool_percentage'];
$date = $_GET['date'];

$sqlBeer = "INSERT INTO drink (id, bottle_size,alcool_percentage,date )
VALUES ('".$id."', '".$bottle_size."' , '".$alcool_percentage."'  , '".$date."' )";

if ($conn->query($sqlBeer) === TRUE) {
    
    $arr = array('error' => "sucess", "message"=>"New drink added !!");
    echo json_encode($arr);


} else {
    $arr = array('error' => "failed", "message"=>" unable to record  beer!!");
    echo json_encode($arr);
}

$conn->close();

?>