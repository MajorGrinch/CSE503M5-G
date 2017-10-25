<?php
session_start();
require 'database.php';
if(!isset($_SESSION['user'])){
	print(json_encode("login"));
	exit;
}
$username = $_SESSION['user'];
$userid = (int)$_SESSION['userid'];

$stmt = $mysqli->prepare("select title, eve_date, eve_content from events where userid=?");
$stmt->bind_param("i", $userid);
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

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