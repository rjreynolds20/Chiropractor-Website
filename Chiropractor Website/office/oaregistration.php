<?php
    // Get all form data from the HTML file.
    $name = $_POST["fname"] . $_POST["lname"];
    $address = $_POST["address"];
    $zip = $_POST["zip"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $insname = $_POST["insname"];
    $memID = $_POST["memID"];
    $group = $_POST["group"];
    $expdate = $_POST["expdate"];
    $userPassword = $_POST["password"];

    //Default observation values for O
    $defObservation = array("Hypo Mo. Seg.", "Hyper Mo. Seg.", "SPN Taut", "PN Tend", "Derifield R/L", "Sht. Lg. R/L");

    //Default treatment values for T
    $defTreatment = array("Cerival Adjustment", "Thoracic Adjustment", "Lumbar Adjustment", "Pelvic Adjustment", 
        "RH7 PNF", "Hydro.", "Trigger Pt.", "P.P.", "TC/TL", "LE/Δ/I", "TR", "C.J.");

    //Default assessment values for A
    $defAssessment = array("Progressing as Expected", "Slow Progress", "Exacerbation", "Plateau");

    //Default plan values for P
    $defPlan = array("Inclinometer Digital", "Inclinometer J. Tech", "EMG 1", "EMG 2", "Muscle Testing C/T", "Muscle Testing L/S", 
        "Muscle Testing EXT.", "Dynamometer J. Tech", "Rehab. (RH) 1 2 3 4 5");


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

    // Selects the most recent patient i.e. the newly added patient.
    $sql = "SELECT MAX(PNo) AS NewestAddition FROM Patients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $newPNo = $result->fetch_assoc()["NewestAddition"] + 1; 
    }

    
    //ADD TO Patients - PNo, PName, DOB, Age, Gender, Address, Zip, Phone #, Email, DoctorNum, Password
    $sql = "INSERT INTO Patients (PNo, PName, Dob, Age, Gender, Addrs, Zip, Phone, Mail, DNo," . "Password" .")
    VALUES (" . $newPNo .",'" . $name ."','" . $dob ."','" . $age ."','" . $gender ."','" . $address ."','" . $zip ."','" . $phone ."','" . $email ."'," . "0" .",'" . $userPassword ."')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //ADD TO ActivePatients - PNo
    $sql = "INSERT INTO ActivePatients (PNo)
    VALUES (" . $newPNo . ")";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //ADD TO FullAddress - Address, Zip, City, State
    $sql = "INSERT INTO FullAddress (Addrs, Zip, City, St8)
    VALUES ('" . $address . "','" . $zip . "','" . $city ."','" . $state . "')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //ADD TO PatientInsurance - PNo, Insurance Name, Member ID.
    $sql = "INSERT INTO PatientInsurance (PNo, InsName, MemId)
    VALUES (" . $newPNo .",'" . $insname ."','". $memID."')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //ADD To Insurance - Insurance Name, Member ID, Group Number, Expiration Date
    $sql = "INSERT INTO Insurance (InsName, MemId, GrNo, ExpDate)
    VALUES ('" . $insname ."','" . $memID ."','". $group."','". $expdate."')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    for ($i = 0; $i < count($defObservation); $i++) {
        $q = "INSERT INTO Observations (PNo, ONo, O) VALUES (" . $newPNo . ", " . $i . ", '" . $defObservation[$i] . "')";
        $conn->query($q);
    }
    
    for ($i = 0; $i < count($defTreatment); $i++) {
        $q = "INSERT INTO Treatment (PNo, TNo, T) VALUES (" . $newPNo . ", " . $i . ", '" . $defTreatment[$i] . "')";
        $conn->query($q);
    }

    for ($i = 0; $i < count($defAssessment); $i++) {
        $q = "INSERT INTO Assessment (PNo, ANo, A) VALUES (" . $newPNo . ", " . $i . ", '" . $defAssessment[$i] . "')";
        $conn->query($q);
    }

    for ($i = 0; $i < count($defPlan); $i++) {
        $q = "INSERT INTO Plan (PNo, PlNo, P) VALUES (" . $newPNo . ", " . $i . ", '" . $defPlan[$i] . "')";
        $conn->query($q);
    }
    // Close connection and redirect to assignRoom.html
    $conn->close();
    header("Location: assignRoom.html");
?>