<?php

$mysqli = new mysqli('localhost', 'root', 'toor', 'miaocalendar');

if ($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
}
