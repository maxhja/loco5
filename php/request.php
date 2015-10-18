<?php

include("config.php");
$id=$_GET['id'];
$allRequest = [];
$check=0;


// select * friends to accept   
$sqlAllFriendsToAccept=" SELECT * FROM friendship where  to_id =  '".$id."'   and status = '0'   " ;
$resultAllFriendsToAccept = $conn->query($sqlAllFriendsToAccept);

$friendToAcceptIdArray = [];

if($resultAllFriendsToAccept->num_rows > 0){
  $i=0;
    while($rowAllFriendsToAccept = $resultAllFriendsToAccept->fetch_assoc()) {      
        $friendToAcceptIdArray[$i]=$rowAllFriendsToAccept['from_id']; 
        $i++;
    }
// select * friend to accept info
$sqlAllFriendsToAcceptInfo=" SELECT * FROM users  where id IN  (".implode(', ',$friendToAcceptIdArray).")  " ;
$resultAllFriendsToAcceptInfo = $conn->query($sqlAllFriendsToAcceptInfo);
// get all users who has approved friendship , for them to be excluded from the freind list
if ($resultAllFriendsToAcceptInfo->num_rows > 0) {
    // getting all friends  array
  
    while($rowAllFriendsToAcceptInfo = $resultAllFriendsToAcceptInfo->fetch_assoc()) {
    array_push($allRequest, [
          'names'   => $rowAllFriendsToAcceptInfo['name'],
          'id' => $rowAllFriendsToAcceptInfo['id'],
          'status' => '1'
        ]);
     
    }

    $check=1;
    
  }

}










// select * pending request   
$sqlAllPending=" SELECT * FROM friendship where  from_id =  '".$id."'   and status = '0'   " ;
$resultAllPending = $conn->query($sqlAllPending);

$friendPendingIdArray = [];
if($resultAllPending->num_rows > 0){
  $i=0;
    while($rowAllPending = $resultAllPending->fetch_assoc()) {      
        $friendPendingIdArray[$i]=$rowAllPending['to_id']; 
         $i++;
    }
// select * pending info
$sqlAllPendingInfo=" SELECT * FROM users  where id IN  (".implode(', ',$friendPendingIdArray).")  " ;
$resultAllPendingInfo = $conn->query($sqlAllPendingInfo);
// get all users who has approved friendship , for them to be excluded from the freind list
if ($resultAllPendingInfo->num_rows > 0) {
    // getting all friends  array
  
    while($rowAllPendingInfo = $resultAllPendingInfo->fetch_assoc()) {
    array_push($allRequest, [
          'names'   => $rowAllPendingInfo['name'],
          'id' => $rowAllPendingInfo['id'],
          'status' => '0'
        ]);
     
    }

    $check=1;
    
  }

}




if($check==1){
  echo json_encode($allRequest);
}











$conn->close();

?>