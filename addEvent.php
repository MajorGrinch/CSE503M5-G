<?php
ini_set("session.cookie_httponly", 1);
session_start();

require 'database.php';

if (isset($_POST['event_title']) && isset($_POST['event_content']) && isset($_POST['event_datetime']) && isset($_POST['is_group']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {
	$event_title = $_POST['event_title'];
	$event_content = $_POST['event_content'];
	$event_datetime = $_POST['event_datetime'];
    $is_group = (int)$_POST['is_group'];
	$userid = (int)$_SESSION['userid'];
    $latitude = (float)$_POST['latitude'];
    $longitude = (float)$_POST['longitude'];
	$stmt = $mysqli->prepare("insert into events (title, eve_date, userid, eve_content, is_group, latitude, longitude) values (?,?,?,?,?,?,?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("ssisidd", $event_title, $event_datetime, $userid, $event_content, $is_group, $latitude, $longitude);
    if($stmt->execute()){
    	print(json_encode(array("status"=>"success", "eve_id"=>$mysqli->insert_id)));
    }
    $stmt->close();
}
