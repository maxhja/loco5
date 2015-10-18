<?php

include("config.php");
$id=$_GET['id'];
$from=$_GET['from'];
$to=$_GET['to'];

// get all users who has approved friendship , for them to be excluded from the freind list

$result1 = $conn->query( " SELECT * FROM users WHERE id = '".$id."'  and on_party= '0' " );

if ($result1->num_rows > 0) {

$row1 = $result1->fetch_assoc();
$date = $row1['date'];


	if(strtotime($date) < strtotime($from)){

// update the server here 

		$sqlUpdate = " UPDATE users SET  on_party= '1'  WHERE id = '".$id."' ";

		if ($conn->query($sqlUpdate) === TRUE) {



		$sqDelete = " DELETE FROM users WHERE id = '".$id."' and date < '".$from."''  ";

			if ($conn->query($sqDelete) === TRUE) {    
			} 
		
	    $arr = array('error' => "sucess", "message"=>"update successfully");
	    echo json_encode($arr);

		}else{

			$arr = array('error' => "failed", "message"=>"failed");
		    echo json_encode($arr);
			}

	}else{
		$arr = array('error' => "failed", "message"=>"failed");
	    echo json_encode($arr);
		}
}else{
	$arr = array('error' => "failed", "message"=>"failed");
    echo json_encode($arr);
	}

$conn->close();

?>


