<?php
$data = $_REQUEST['json_data'];
$json = json_decode($data,true);
include("config.php");
$id=$json[0]['user_id'];
$sql=" SELECT * FROM friendship where ( from_id = '".$id."'   or   to_id =  '".$id."' )  and status = '1' or status = '0'   " ;
$result = $conn->query($sql);
// get all users who has approved friendship , for them to be excluded from the freind list
$approvedUserArray = [];
$friendUserArray = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
array_push($approvedUserArray, [
      'from_id'   => $row['from_id'],
      'to_id' => $row['to_id']
    ]);

    }




// if result exist

// start the comparison here
foreach ($json as $key => $value) {
  $i=0;
foreach ($approvedUserArray as $ki => $valeur) {
if( $value['id'] == $valeur['from_id'] || $value['id'] == $valeur['to_id'] ){
  //if has approved request skip
  $i=1;
}

}

if($i==0){

  array_push($friendUserArray, [
      'id'   => $value['id'],
      'name' => $value['name'],
      'user_id' => $value['user_id']
    ]);

}else{

}

}
echo json_encode($friendUserArray);


$conn->close();

  }else{
    echo json_encode($json);
  }
  
  
  
  
  


?>