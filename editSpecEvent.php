<?php
session_start();
require 'database.php';



if (isset($_POST['eve_id']) && isset($_SESSION['userid']) && isset($_POST['eve_title']) && isset($_POST['eve_content']) && isset($_POST['eve_date'])) {
    $eve_id = (int) $_POST['eve_id'];
    $userid = (int)$_SESSION['userid'];
    $eve_date = $_POST['eve_date'];
    $title = $_POST['eve_title'];
    $eve_content = $_POST['eve_content'];
    $stmt   = $mysqli->prepare("update events set title=?, eve_content=?, eve_date=? where eve_id=? and userid=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("sssii", $title, $eve_content, $eve_date, $eve_id, $userid);
    if ($stmt->execute()) {
        print(json_encode(array("status"=>"success")));
    } else {
        print(json_encode(array("status"=>"fail")));
    }
    $stmt->close();
}
