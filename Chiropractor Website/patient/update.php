<?php
    
    session_start();

    // Get all form data from the HTML file.
    $name = $_POST["name"];
    $address = $_POST["address"];
    $zip = $_POST["zip"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $insname = $_POST["insurancename"];
    $memID = $_POST["memberid"];
    $group = $_POST["groupnumber"];
    $expdate = $_POST["expirationdate"];
    echo $expdate;

    // Information to log into the database.
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    // Creating connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //Grab old values for InsName, MemID, Addrs, Zip for SQL use

    $oldinsnameSQL = "SELECT InsName FROM PatientInsurance WHERE PNO = ". $_SESSION["PNo"];
    $oldinsname = $conn->query($oldinsnameSQL)->fetch_assoc()["InsName"];

    $oldmemIDSQL = "SELECT MemId FROM PatientInsurance WHERE PNO = ". $_SESSION["PNo"];
    $oldmemID = $conn->query($oldmemIDSQL)->fetch_assoc()["MemId"];

    $oldaddressSQL = "SELECT Addrs FROM Patients WHERE PNO = ". $_SESSION["PNo"];
    $oldaddress = $conn->query($oldaddressSQL)->fetch_assoc()["Addrs"];

    $oldzipSQL = "SELECT Zip FROM Patients WHERE PNO = ". $_SESSION["PNo"];
    $oldzip = $conn->query($oldzipSQL)->fetch_assoc()["Zip"];

    //Update Patients - PName, DOB, Age, Gender, Address, Zip, Phone #, Email
    $sql = "UPDATE Patients SET PName = '" . $name . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Dob = '" . $dob . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Age = '" . $age . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Gender = '" . $gender . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Addrs = '" . $address . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Zip = '" . $zip . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Phone = '" . $phone . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);
    $sql = "UPDATE Patients SET Mail = '" . $email . "' WHERE PNo= " . $_SESSION["PNo"];
    $conn->query($sql);


    //Delete outdated rows in DB and insert new values
    //'Updating' Insurance Name, Member ID, Group Num, Experation Date, Address, Zip, City, St8 in PatientInsurance, Insurance, and FullAddress DBs
    $deleteInsurance = "DELETE FROM Insurance WHERE InsName = '" . $oldinsname ."' AND MemId = '". $oldmemID ."'";
    $conn->query($deleteInsurance);

    $deletePatInsurance = "DELETE FROM PatientInsurance WHERE PNo = " . $_SESSION["PNo"];
    $conn->query($deletePatInsurance);

    $insertPI = "INSERT INTO PatientInsurance (PNo, InsName, MemId) VALUES (". $_SESSION["PNo"] . 
        ", '" . $insname . "', '" . $memID . "')";
    $conn->query($insertPI);
    
    $insertIns = "INSERT INTO Insurance (InsName, MemId, GrNo, ExpDate) VALUES ('". $insname . "', '" . $memID . 
    "', '". $group . "', '" . $expdate . "')";
    $conn->query($insertIns);
    
    $deleteFullAddress = "DELETE FROM FullAddress WHERE Addrs = '" . $oldaddress ."' AND Zip = '". $oldzip ."'";
    $conn->query($deleteFullAddress);

    $insertFullAdd = "INSERT INTO FullAddress (Addrs, Zip, City, St8) VALUES ('". $address . "', '" . $zip . 
    "', '". $city . "', '" . $state . "')";
    $conn->query($insertFullAdd);

    // Close connection and redirect to assignRoom.html
    $conn->close();
    header("Location: patientInformation.php");
?>