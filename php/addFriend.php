<?php

include("config.php");
$user_id=$_GET['user_id'];
$friend_id=$_GET['friend_id'];
$friendName=$_GET['friendName'];



$sqlAddFriend = "INSERT INTO  friendship ( from_id , to_id, status )
VALUES ('".$user_id."', '".$friend_id."' , '0'  )";

if ($conn->query($sqlAddFriend) === TRUE) {

$sqlSelectUser = " SELECT * FROM users where id='".$friend_id."' and name = '".$friendName."'   ";
$resultSelectUser = $conn->query($sqlSelectUser);


if ($resultSelectUser->num_rows > 0) {


   

} else {

$sqlInsertUser = "INSERT INTO users (id, name  )
VALUES ('".$friend_id."', '".$friendName."')";

if ($conn->query($sqlInsertUser) === TRUE) {
      
}
    
}





    
    $arr = array('error' => "sucess", "message"=>" New friend added !!");
    echo json_encode($arr);


} else {
    $arr = array('error' => "failed", "message"=>" unable to add friend!!");
    echo json_encode($arr);
}










$conn->close();

?>