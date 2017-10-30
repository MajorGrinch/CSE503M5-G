<?php
ini_set("session.cookie_httponly", 1);
session_start();

require 'database.php';

if (isset($_POST['eve_id']) && isset($_SESSION['userid']) && isset($_POST['eve_title']) && isset($_POST['eve_content']) && isset($_POST['eve_date']) && isset($_POST['lat']) && isset($_POST['lng'])) {
    $eve_id      = (int) $_POST['eve_id'];
    $userid      = (int) $_SESSION['userid'];
    $eve_date    = $_POST['eve_date'];
    $title       = $_POST['eve_title'];
    $eve_content = $_POST['eve_content'];
    $latitude    = (float)$_POST['lat'];
    $longitude   = (float)$_POST['lng'];

    $pre_stmt = $mysqli->prepare("select events.eve_id, events.userid, dst_userid from events join sharelist on events.eve_id=sharelist.eve_id where is_group=1 and dst_userid=? and events.eve_id=?");
    if(!$pre_stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $pre_stmt->bind_param("ii", $userid, $eve_id);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();
    if($result->num_rows == 0){
        print(json_encode(array("status"=>"unauthorized")));
        $pre_stmt->close();
        exit;
    }else{
        $pre_stmt->close();
    }
    
    $stmt        = $mysqli->prepare("update events set title=?, eve_content=?, eve_date=?, latitude=?, longitude=? where eve_id=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("sssddi", $title, $eve_content, $eve_date, $latitude, $longitude, $eve_id);
    if ($stmt->execute()) {
        print(json_encode(array("status" => "success")));
    } else {
        print(json_encode(array("status" => "fail")));
    }
    $stmt->close();
}
