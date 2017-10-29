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

if (isset($_SESSION['userid'])) {
    $userid = (int)$_SESSION['userid'];
    $stmt   = $mysqli->prepare("select username, userid from users where userid!=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("i", $userid);
    if ($stmt->execute()) {
        $result       = $stmt->get_result();
        $result_array = array();
        while ($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
        print(json_encode($result_array));
    } else {
        print(json_encode("fail"));
    }
    $stmt->close();
}
