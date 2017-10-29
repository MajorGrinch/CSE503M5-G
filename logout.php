<?php
ini_set("session.cookie_httponly", 1);
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}
session_start();
if(isset($_POST['logout'])){
    unset($_SESSION['user']);
    unset($_SESSION['userid']);
    unset($token);
    session_destroy();
    print(json_encode(array('status' =>'success')));
}