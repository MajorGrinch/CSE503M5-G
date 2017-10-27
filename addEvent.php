<?php
session_start();
require 'database.php';

if (isset($_POST['event_title']) && isset($_POST['event_content']) && isset($_POST['event_datetime'])) {
	$event_title = $_POST['event_title'];
	$event_content = $_POST['event_content'];
	$event_datetime = $_POST['event_datetime'];
	$userid = (int)$_SESSION['userid'];
	$stmt = $mysqli->prepare("insert into events (title, eve_date, userid, eve_content) values (?,?,?,?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("ssis", $event_title, $event_datetime, $userid, $event_content);
    if($stmt->execute()){
    	print(json_encode(array("status"=>"success")));
    }
    $stmt->close();
}
