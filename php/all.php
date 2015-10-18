<?php

include("config.php");
$id=$_GET['id'];





// select * friends 

$sqlAllFriends=" SELECT * FROM friendship where (   from_id = '".$id."'   or   to_id =  '".$id."' )  and status = '1'   " ;
$resultAllFriends = $conn->query($sqlAllFriends);

$frindsIdArray = [];

if($resultAllFriends->num_rows > 0){


  $i=0;
  
    while($rowAllFriends = $resultAllFriends->fetch_assoc()) {

      if($id==$rowAllFriends['from_id']){
        $frindsIdArray[$i]=$rowAllFriends['to_id'];
      }else{
        $frindsIdArray[$i]=$rowAllFriends['from_id'];
      }
      $i++;
    }
    
    


//$sqlAllOut=" SELECT * FROM users  where id IN  (".implode(', ',$arrList).")   " ;      $frindsIdArray 
  
$sqlAllOut=" SELECT * FROM users  where id IN  (".implode(', ',$frindsIdArray).")   " ;

$resultAllOut = $conn->query($sqlAllOut);
// get all users who has approved friendship , for them to be excluded from the freind list
$frindsOutArray = [];


if ($resultAllOut->num_rows > 0) {
    // getting all friends  array
  
    while($rowAllOut = $resultAllOut->fetch_assoc()) {
    array_push($frindsOutArray, [
          'names'   => $rowAllOut['name'],
          'id' => $rowAllOut['id']
        ]);
     
    }
    
    echo json_encode($frindsOutArray);

  }
  
  
  
  



}


$conn->close();

?>