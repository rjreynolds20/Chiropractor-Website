<?php
// Include helper.php which has all office php functions.
include 'helper.php';

$name = $_POST["fname"] . $_POST["lname"];
$room = $_POST["roomNo"];
$dob = $_POST["dob"];
$date = $_POST["currDate"];

// Calls assignRoom from helper.php
assignRoom($room, $name, $dob, $date);
?>