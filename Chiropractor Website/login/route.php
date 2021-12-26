<?php
    $email  = $_POST["email"];
    $inputPassword = $_POST["password"];
    $checkAccount = FALSE;
    //ESTABLISHES THE CONNECTION
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //check if patient
    $mail_sql = "SELECT Mail FROM Patients WHERE Mail = '" . $email ."'";
    $mail_result = $conn->query($mail_sql);

    if ($mail_result->num_rows > 0) {
        $pass_sql = "SELECT Password FROM Patients WHERE Mail = '" . $email ."'";
        $pass_result = $conn->query($pass_sql);
        //get password from db
        if ($pass_result->num_rows > 0) {
            $PPassword = $pass_result->fetch_assoc()["Password"];
        }
        //check input vs query
        if($PPassword == $inputPassword){
            $pno_sql = "SELECT PNo FROM Patients WHERE Mail = '".$email."' AND Password = '". $PPassword . "'";
            $result = $conn->query($pno_sql);
            if ($result->num_rows > 0) {
                $PNo = $result->fetch_assoc()["PNo"]; 
            }

            $conn->close();
            session_start();

            $_SESSION["PNo"] = $PNo;
            $checkAccount = TRUE;
            echo $checkAccount;
            header("Location: ../patient/patientInformation.php");
        }
        
    }

    //THIS CHECKS IF DOCTOR
    $mail_sql = "SELECT Mail FROM Doctors WHERE Mail = '" . $email ."'";
    $mail_result = $conn->query($mail_sql);

    if ($mail_result->num_rows > 0) {
        $pass_sql = "SELECT Password FROM Doctors WHERE Mail = '" . $email ."'";
        $pass_result = $conn->query($pass_sql);

        //get password from db
        if ($pass_result->num_rows > 0) {
            $PPassword = $pass_result->fetch_assoc()["Password"];
        }
        //check input vs query
        if($PPassword == $inputPassword){
            $conn->close();
            $checkAccount = TRUE;
            header("Location: ../doctor/room.html");
        }
        //^NEED TO PASS THE DNo USING A SESSION VARIABLE^
    }

    //THIS CHECKS IF OFFICE MANAGER
    $mail_sql = "SELECT Mail FROM OManagers WHERE Mail = '" . $email ."'";
    $mail_result = $conn->query($mail_sql);

    if ($mail_result->num_rows > 0) {
        $pass_sql = "SELECT Password FROM OManagers WHERE Mail = '" . $email ."'";
        $pass_result = $conn->query($pass_sql);

        //get password from db
        if ($pass_result->num_rows > 0) {
            $PPassword = $pass_result->fetch_assoc()["Password"];
        }
        //check input vs query
        if($PPassword == $inputPassword){
            $conn->close();
            $checkAccount = TRUE;
            header("Location: ../office/scheduleApp.html");
        }
    }
    if($checkAccount == FALSE){
        echo $checkAccount;
        header("Location: LogIn.html");
    }

?>