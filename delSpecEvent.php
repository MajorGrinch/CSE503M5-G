<?php
ini_set("session.cookie_httponly", 1);
session_start();
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
    die("Session hijack detected");
}else{
    $_SESSION['useragent'] = $current_ua;
}
require 'database.php';

if (isset($_POST['eve_id']) && isset($_SESSION['userid'])) {
    $eve_id = (int) $_POST['eve_id'];
    $userid = (int)$_SESSION['userid'];
    $stmt   = $mysqli->prepare("delete from events where eve_id=? and userid=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("ii", $eve_id, $userid);
    if ($stmt->execute()) {
        print(json_encode(array("status"=>"success")));
    } else {
        print(json_encode(array("status"=>"fail")));
    }
    $stmt->close();
}
