<?php
ini_set("session.cookie_httponly", 1);
session_start();

require 'database.php';

if (isset($_POST['eve_id']) && isset($_SESSION['userid']) && isset($_POST['dst_userid'])) {
    $eve_id = (int) $_POST['eve_id'];
    $dst_userid = (int)$_POST['dst_userid'];
    $src_userid = (int)$_SESSION['userid'];
    $stmt   = $mysqli->prepare("insert into sharelist values (?,?,?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("iii", $eve_id, $src_userid, $dst_userid);
    if ($stmt->execute()) {
        print(json_encode(array("status"=>"success")));
    } else {
        print(json_encode("Query Failed"));
    }
    $stmt->close();
}
