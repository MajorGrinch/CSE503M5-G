<?php
session_start();
if(isset($_POST['logout'])){
    unset($_SESSION['user']);
    unset($_SESSION['userid']);
    unset($token);
    session_destroy();
    print(json_encode(array('status' =>'success')));
}