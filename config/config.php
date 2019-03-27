<?php
ob_start(); // this turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/New_York");
$conn = mysqli_connect('localhost', 'root', '', 'stangclubmd');

if (mysqli_connect_errno()) {
    echo "Failed to connect " . mysqli_connect_errno();
}
