<?php

include("config.php");
$id=urldecode($_GET['id']);
$bottle_size=urldecode($_GET['bottle_size']);
$alcool_percentage=urldecode($_GET['alcool_percentage']);
$date = urldecode($_GET['date']);
$booze_type = urldecode($_GET['booze_type']);

$sqlBeer = "INSERT INTO booze (id, bottle_size,alcool_percentage,date,booze_type )
VALUES ('".$id."', '".$bottle_size."' , '".$alcool_percentage."'  , '".$date."' , '".$booze_type."' )";

if ($conn->query($sqlBeer) === TRUE) {
    
    $arr = array('error' => "sucess", "message"=>"New beer added !!");
    echo json_encode($arr);


} else {
    $arr = array('error' => "failed", "message"=>" unable to record  beer!!");
    echo json_encode($arr);
}

$conn->close();

?>