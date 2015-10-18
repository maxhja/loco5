<?php

include("config.php");
$id=$_GET['id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$current_date=$_GET['current_date'];






function getGender($current_friend_id){
include("config.php");
$resultGender = $conn->query(" SELECT * FROM users WHERE  id = '".$current_friend_id."'  ");
$rowGender = $resultGender->fetch_assoc() ;
$gender = $rowGender['gender'];

return $gender;
}



function getWeight($current_friend_id){
include("config.php");
$resultWeight = $conn->query(" SELECT * FROM users WHERE  id = '".$current_friend_id."'  ");
$rowWeight = $resultWeight->fetch_assoc() ;
$weight = $rowWeight['weight'];

return $weight;
}




function getTime($from_date,$to_date,$current_date,$current_friend_id){
include("config.php");
$result1 = $conn->query(" SELECT date FROM booze WHERE  date >= '".$from_date."' and  date <= '".$to_date."' and  id = '".$current_friend_id."'   ORDER BY date ASC
LIMIT 1  ");
$row1 = $result1->fetch_assoc() ;
$firt_date = $row1['date'];
$t1 = StrToTime ($current_date);
$t2 = StrToTime ($firt_date);
$diff = $t1 - $t2;
$hours = $diff / ( 60 * 60 );
return intval($hours);

}


function getBooze($from_date,$to_date,$current_friend_id,$beer_type){
include("config.php");
$sqlBooze=" SELECT SUM(bottle_size) AS booze_sum FROM booze  WHERE  date >= '".$from_date."' and  date <= '".$to_date."' and  
id = '".$current_friend_id."' and booze_type = '".$beer_type."' " ;
$resultBooze = $conn->query($sqlBooze);
$rowBooze = $resultBooze->fetch_assoc(); 
$sumBooze = $rowBooze['booze_sum'];

if($is_numeric){

}else{
  $sum=1;
}
return $sum;
}



function getStandardDrinks($from_date,$to_date,$current_friend_id){


    $getAllBers = getBooze($from_date,$to_date,$current_friend_id,1) ; // get the total cl of beers from the database (eg 100cl)
    $getAllWines = getBooze($from_date,$to_date,$current_friend_id,2) ;// get the total cl of beers from the database (eg 10cl)
    $getDrinks = getBooze($from_date,$to_date,$current_friend_id,3) ; // get the total cl of beers from the database (eg 4cl)
    
    $standardBeer = $getAllBers/33; // calculate how many standardBeers it is
    $standardWine = $getAllWines/15; // calculate how many standardWines it is
    $standardDrinks = $getDrinks/4.4; // calculate how many standardDrinks it is
    
    return $standardBeer + $standardWine + $standardDrinks;

}






function getBAC($from_date,$to_date,$current_date,$current_friend_id){

  
if( getGender($current_friend_id) == "male"){
  $BW = 0.58;
  $MR = 0.015;
}else{
  $BW = 0.49;
  $MR = 0.017;
}



$SD = getStandardDrinks($from_date,$to_date,$current_friend_id);
$WT = getWeight($current_friend_id) ;
$DP = getTime($from_date,$to_date,$current_date,$current_friend_id);

$EBAC = ((0.806*$SD*1.2)/($BW*$WT)) - ($MR*$DP);
$EBACinPERMILLE = $EBAC*10*1.06; 
    
return $EBACinPERMILLE;

}



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
  
$sqlAllOut=" SELECT * FROM users  where date >= '".$from_date ."' and  date <= '".$to_date ."'  and id IN  (".implode(', ',$frindsIdArray).") and   on_party = '0'  " ;

$resultAllOut = $conn->query($sqlAllOut);
// get all users who has approved friendship , for them to be excluded from the freind list
$frindsOutArray = [];


if ($resultAllOut->num_rows > 0) {
    // getting all friends  array
  
    while($rowAllOut = $resultAllOut->fetch_assoc()) {

      $bac=getBAC($from_date,$to_date,$current_date,$rowAllOut['id']);
      if(is_numeric($bac)){
    $bac=number_format((float)$bac, 1, '.', '');
      }else{
        $bac=0;
      }

    array_push($frindsOutArray, [
          'names'   => $rowAllOut['name'],
          'bac' => $bac." PR",
          'latitude' => $rowAllOut['latitude'],
          'longitude' => $rowAllOut['longitude'],
          'friendId' => $rowAllOut['id']
        ]);
     
    }
    
    echo json_encode($frindsOutArray);

  }
  
  
  
  



}


$conn->close();

?>