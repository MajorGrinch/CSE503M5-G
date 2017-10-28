<?php
session_start();
require 'database.php';
if(!isset($_SESSION['userid'])){
	print(json_encode("login"));
	exit;
}

$userid = (int)$_SESSION['userid'];

$stmt = $mysqli->prepare("select events.eve_id, title, eve_date, src_userid, username from events join sharelist on events.eve_id=sharelist.eve_id join users on events.userid=users.userid where dst_userid=?");

if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param("i", $userid);
if($stmt->execute()){
	$result = $stmt->get_result();
	$result_array = array();
	while( $row = $result->fetch_assoc()){
		array_push($result_array, $row);
	}
	print(json_encode($result_array));
}
else{
	print(json_encode("Query Failed"));
}
$stmt->close();