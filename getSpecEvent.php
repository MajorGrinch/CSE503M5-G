<?php
session_start();
require 'database.php';

if (isset($_POST['eve_id']) && isset($_SESSION['userid'])) {
    $eve_id = (int) $_POST['eve_id'];
    $stmt   = $mysqli->prepare("select eve_id, title, eve_date, eve_content, latitude, longitude from events where eve_id=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("i", $eve_id);
    if ($stmt->execute()) {
        $result       = $stmt->get_result();
        $result_array = array();
        while ($row = $result->fetch_assoc()) {
            array_push($result_array, $row);
        }
        print(json_encode($result_array));
    } else {
        print(json_encode("Query Failed"));
    }
    $stmt->close();
}
