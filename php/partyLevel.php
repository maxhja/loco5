<?php

include("config.php");
$id=$_GET['id'];
$party_level=$_GET['party_level'];


$message="updated";

if($party_level>0 && $party_level<4){

$message="Geek";

}





if($party_level>5 && $party_level<8){

$message="Medium";

}






if($party_level>9 && $party_level<11){

$message="All in";

}


$message="Updated";




$sqlUpdate = " UPDATE users SET party_level = '".$party_level."'  WHERE id = '".$id."' ";

if ($conn->query($sqlUpdate) === TRUE) {


	
	$arr = array('error' => "sucess", "message"=>$message);
    echo json_encode($arr);
    
} else {
     $arr = array('error' => "failed", "message"=>" unable to update retry!!");
    echo json_encode($arr);
}


$conn->close();

?>