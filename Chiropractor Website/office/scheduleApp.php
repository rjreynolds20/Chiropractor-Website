<?php
// Includes helper.php which includes all office php functions.
include 'helper.php';

$appDate = $_POST["appDate"];
$time = $_POST["time"];
$frequency = $_POST["frequency"];
$name = $_POST["fname"] . $_POST["lname"];
$dob = $_POST["dob"];
$currDate = $_POST["currDate"];

// Calls schedule appointment function from helper.php
scheduleAppointment($appDate, $time, $frequency, $name, $dob, $currDate);
?>