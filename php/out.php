<?php

include("config.php");
$id=$_GET['id'];
$gender=$_GET['gender'];
$weight=$_GET['weight'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];


function getBac($user_id){

$sqlUser=" SELECT * FROM users where   id = '".$user_id."'      " ;
$resultUser = $conn->query($sqlUser);

if ($resultUser->num_rows > 0) {

  $gender="";
  $bac=0;
    
    while($rowUser = $resultUser->fetch_assoc()) {
       $gender=  $rowUser['gender'];
    }

    if($gender=="male"){
    $ebac = ((0.806*3.0*1.2)/(0.58*80.0)) - (0.015*2.0);
    $bac = $ebac*10*1.06; 
    }else{
    $ebac = ((0.806*3.0*1.2)/(0.49*80.0)) - (0.017*2.0);
    $bac = $ebac*10*1.06;
    }

  }

  return $bac;

}



$sqlAllFriends=" SELECT * FROM friendship where (   from_id = '".$id."'   or   to_id =  '".$id."' )  and status = '1'   " ;
$resultAllFriends = $conn->query($sqlAllFriends);
// get all users who has approved friendship , for them to be excluded from the freind list
$frindsIdArray = [];
if ($result->num_rows > 0) {
    // getting all friends  array
  $i=0;
    while($rowAllFriends = $resultAllFriends->fetch_assoc()) {

      if($id!=$rowAllFriends['from_id']){
        $frindsIdArray[$i]=$rowAllFriends['to_id'];
      }else{
        $frindsIdArray[$i]=$rowAllFriends['from_id'];
      }
      $i++;
    }

// getting friends who are out in a specific time array



  $sqlAllOut=" SELECT * FROM users where id IN  ('".$frindsIdArray."')  and on_party = '0'  and date >= '".$from_date ."' and  date <= '".$to_date ."' " ;

$resultAllOut = $conn->query($sqlAllOut);
// get all users who has approved friendship , for them to be excluded from the freind list
$frindsOutArray = [];
if ($resultAllOut->num_rows > 0) {
    // getting all friends  array
  
    while($rowAllOut = $resultAllOut->fetch_assoc()) {
    array_push($friendUserArray, [
          'names'   => $resultAllOut['name'],
          'bac' => '12BAC',
          'latitude' => $resultAllOut['latitude'],
          'longitude' => $resultAllOut['longitude'],
          'friendId' => $resultAllOut['id']
        ]);
     
    }

  }



  }else{
    
  }

$conn->close();

?>