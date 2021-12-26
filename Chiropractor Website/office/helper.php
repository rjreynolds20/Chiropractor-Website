<?php
    //PRE: This function no longer works practically, but works in theory.
    //PRE: Takes name of patient and date of birth of patient.
    //POST: Removes patient from the database.
    function remove_row($name, $dob) {
        $servername = "localhost";
        $username = "";
        $password = "";
        $db_name = "";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db_name);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Match the name and dob to the patient number.
        $sql = "DELETE FROM Patients WHERE PName = '". $name ."' AND Dob = '". $dob ."'";

        // Removes patient from the Patients DB.
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } 
        else {
            echo "Error deleting record: " . $conn->error;
        }

        // Closes connection and redirect to removeClient.html.
        header("Location: removeClient.html");
        $conn->close();
    }

    //PRE: Takes room number, patient name, patient date of birth, current date.
    //POST: Assigns room to patient and stores in Rooms DB as well as Visits DB.
    function assignRoom($room, $name, $dob, $date) {
        $servername = "localhost";
        $username = "";
        $password = "";
        $db_name = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetches PNo using patient's name and date of birth.
        $PNo = "SELECT PNo FROM Patients WHERE PName = '". $name ."' AND Dob = '". $dob ."'";
        $result = $conn->query($PNo);
        if ($result->num_rows > 0) {
            $PNo_sql = $result->fetch_assoc()["PNo"]; 
        }

        // Fetches DNo using Patient's PNo.
        $DNo = "SELECT DNo FROM Patients WHERE PNo =" . $PNo_sql;
        $result = $conn->query($DNo);
        if ($result->num_rows > 0) {
            $DNo_sql = $result->fetch_assoc()["DNo"]; 
        }
        
        // Update Rooms appropriately
        $sql = "UPDATE Rooms SET PNo=" . $PNo_sql . " WHERE RNo=" . $room;
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } 
        else {
            echo "Error updating record: " . $conn->error;
        }

        // Insert visit into Visits DB.
        $sql = "INSERT INTO Visits (PNo, AptDate, DNo)
        VALUES (" . $PNo_sql . ", '" . $date ."', " . $DNo_sql. ")";
        echo $PNo_sql;
        echo $date;
        echo $DNo_sql;
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error inserting record: " . $conn->error;
        }

        // Close connection and redirect to assignRoom.html.
        header("Location: assignRoom.html");
        $conn->close();
    }

    //PRE: Takes appDate - which is the desired new appointment date,
    //           time - which is the desired new time for the new appointment.
    //           patient's name, patient's date of birth, and current date.
    //POST: Updates patient's next appointment with new desired appointment date and time.
    //      Updates the NextAppointment DB with next appointment information.
    function scheduleAppointment($appDate, $time, $frequency, $name, $dob, $currDate) {
        $servername = "localhost";
        $username = "";
        $password = "";
        $db_name = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetches PNo using patient's name and date of birth.
        $PNo = "SELECT PNo FROM Patients WHERE PName = '". $name ."' AND Dob = '". $dob ."'";
        $result = $conn->query($PNo);

        if ($result->num_rows > 0) {
            $PNo_sql = $result->fetch_assoc()["PNo"]; 
        }

        // Get current date from JavaScript script,
        // Push frequency into frequency table,

        // Insert NextApt into NextAppointment table.

        $sql = "INSERT INTO NextAppointment (PNo, AptDate, NextApt, Time)
        VALUES (" . $PNo_sql . ", '" . $currDate ."', '". $appDate."', '" . $time. "')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Insert Frequency into Frequency table.

        $sql = "INSERT INTO Frequency (PNo, AptDate, Freq)
        VALUES (" . $PNo_sql . ", '" . $currDate . "', '" . $frequency ."')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection and redirect to scheduleApp.html.
        header("Location: scheduleApp.html");
        $conn->close();
    }
?>