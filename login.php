<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database.php';
if (isset($_POST['username']) && isset($_POST['passwordInput'])) {
    $username = $_POST['username'];
    $password = $_POST['passwordInput'];
    if (!preg_match("/^(\w)+$/", $username) || !preg_match("/^(\w)+$/", $password)) {
        die("Invalid username or password");
    }
    $stmt = $mysqli->prepare("select userid, password from users where username=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userid, $temp_password);
    $stmt->fetch();
    if (password_verify($password, $temp_password)) {
        $_SESSION['user']   = $username;
        $_SESSION['userid'] = $userid;
        $_SESSION['token']  = bin2hex(openssl_random_pseudo_bytes(32));
        $result_array = array('status' => 'success', 'username'=> $username);
        print(json_encode($result_array));
    } else {
        $result_array = array('status' => 'fail' );
        print(json_encode($result_array));
    }
    $stmt->close();
}
