<?php
ini_set("session.cookie_httponly", 1);
session_start();

require 'database.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!preg_match("/^(\w)+$/", $username) || !preg_match("/^(\w)+$/", $password)) {
        die("Invalid username or password");
    }
    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        $result_array = array('status' => 'success');
        print(json_encode($result_array));
    }
    else{
        $result_array = array('status' => 'fail');
        print(json_encode($result_array));
    }
    $stmt->close();
}
