<?php

$mysqli = new mysqli('localhost', 'root', 'Aptx4869!!', 'miaocalendar');

if ($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
}
