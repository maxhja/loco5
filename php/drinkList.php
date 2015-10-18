<?php

include("config.php");
$friendId=$_GET['friendId'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];







//$sqlAllOut=" SELECT * FROM users  where id IN  (".implode(', ',$arrList).")   " ;      $frindsIdArray 
  
$sqlDrink=" SELECT * FROM booze  where date >= '".$from_date ."' and  date <= '".$to_date ."' and id = '".$friendId."' " ;

$resultDrink = $conn->query($sqlDrink);
// get all users who has approved friendship , for them to be excluded from the freind list
$drinkArray = [];


if ($resultDrink->num_rows > 0) {
    // getting all friends  array
  
    while($rowDrink = $resultDrink->fetch_assoc()) {

      if($rowDrink['booze_type']==1){
        $booze="Beer";

      }else if($rowDrink['booze_type']==2) {
      $booze="Wine";
      }else{
      $booze="Drink";
      }
    array_push($drinkArray, [
          'time'   => $rowDrink['date'],
          'boozeType' => $booze,
          'quantity' => $rowDrink['bottle_size']
          
        ]);
     
    }
    
    echo json_encode($drinkArray);

  }
  
  
  
  


$conn->close();

?>