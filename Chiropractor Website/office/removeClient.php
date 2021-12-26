<?php
// Include helper.php which includes all office php functions.
include 'helper.php';

$name = $_POST["fname"] . $_POST["lname"];
$dob = $_POST["dob"];

// Calls remove row from helper.php
remove_row($name, $dob);
?>