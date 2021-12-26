<?php
    $servername = "localhost";
    $username = "";
    $password = "";
    $db_name = "";
    
    // Starts session to get session variables from patient.
    session_start();

    $newApp = $_POST["newApp"];
    $time = $_POST["time"];
    $currDate = $_POST["currDate"];

    // Create connection to DB
    $conn = new mysqli($servername, $username, $password, $db_name);

    // Check connection to DB
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Gets the most recent visiting date, which is attached to previous appointment date/time.
    $sql = "SELECT MAX(AptDate) FROM NextAppointment ORDER BY AptDate DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $currApp = $result->fetch_assoc()["MAX(AptDate)"]; 
    }

    // Updates rescheduled appointment in NextAppointment
    $sql = "UPDATE NextAppointment SET NextApt = '" . $newApp . "' WHERE PNo= " . $_SESSION["PNo"] . " AND AptDate= '" . $currApp . "'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } 
    else {
        echo "Error updating record: " . $conn->error;
    }

    // Updates rescheduled appointment time in NextAppointment.
    $sql = "UPDATE NextAppointment SET Time = '" . $time . "' WHERE PNo= " . $_SESSION["PNo"] . " AND AptDate= '" . $currApp . "'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } 
    else {
        echo "Error updating record: " . $conn->error;
    }

    // Redirects to patientInformation.html
    header("Location: patientInformation.php");

    // Closes Connection.
    $conn->close();
?>