<?php
    // Starts session
    session_start();

    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    // Create connection to DB
    $conn = new mysqli($servername, $username, $password, $dbname);
    $rno = $_POST["roomButton"];

    // Checks connection to DB
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $PNo = $_SESSION["PNo"];
    $patient = "SELECT * FROM Patients WHERE PNo = " .$patientNo;
    $result = $conn->query($patient);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $PName = $row["PName"];
            $Dob = $row["Dob"];
        }
    }
    
    // Collects Variables from DB using SQL

    $name = "SELECT PName FROM Patients WHERE PNO = '".$PNo."'";
    $dob = "SELECT Dob FROM Patients WHERE PNO = '".$PNo."'";
    $age = "SELECT Age FROM Patients WHERE PNO = '".$PNo."'";
    $gender = "SELECT Gender FROM Patients WHERE PNO = '".$PNo."'";
    $addy = "SELECT Addrs FROM Patients WHERE PNO = '".$PNo."'";

    $zip = "SELECT Zip FROM Patients WHERE PNO = '".$PNo."'";
    $phone = "SELECT Phone FROM Patients WHERE PNO = '".$PNo."'";
    $email = "SELECT Mail FROM Patients WHERE PNO = '".$PNo."'";
    $insName = "SELECT InsName FROM PatientInsurance WHERE PNO = '".$PNo."'";
    $memid = "SELECT MemId FROM PatientInsurance WHERE PNO = '".$PNo."'";

    $AddrsQ = json_encode(($conn->query($addy)->fetch_assoc()["Addrs"]));
    $zipQ = json_encode(($conn->query($zip)->fetch_assoc()["Zip"]));
    
    $insNameQ = json_encode(($conn->query($insName)->fetch_assoc()["InsName"]));
    $memidQ = json_encode(($conn->query($memid)->fetch_assoc()["MemId"]));

    $city = "SELECT City FROM FullAddress WHERE Addrs = " . $AddrsQ . " and Zip=" . $zipQ;
    $state = "SELECT St8 FROM FullAddress WHERE Addrs = " . $AddrsQ . " and Zip=" . $zipQ;

    $groupNum = "SELECT GrNo FROM Insurance WHERE InsName = " . $insNameQ . " and MemId=" . $memidQ;
    $exDate = "SELECT ExpDate FROM Insurance WHERE InsName = " . $insNameQ . " and MemId=" . $memidQ;


    //PRE 
    //POST 
    function injectListToJs($queryString, $desc, $conn) {
        $result = $conn->query($queryString);
        $arr = json_encode($result->fetch_all());
        echo ("<script> const $desc = $arr</script>");
    }

    // Injects the variables above into JS for implementation
    injectListToJs($name, "Pname", $conn);
    injectListToJs($dob, "Pdob", $conn);
    injectListToJs($age, "Page", $conn);
    injectListToJs($gender, "Pgender", $conn);
    injectListToJs($addy, "Paddy", $conn);
    injectListToJs($city, "Pcity", $conn);
    injectListToJs($state, "Pstate", $conn);
    injectListToJs($zip, "Pzip", $conn);
    injectListToJs($phone, "Pphone", $conn);
    injectListToJs($email, "Pemail", $conn);
    injectListToJs($insName, "PinsName", $conn);
    injectListToJs($memid, "Pmemid", $conn);
    injectListToJs($groupNum, "PgroupNum", $conn);
    injectListToJs($exDate, "PexDate", $conn);

    // Closes Connection.
    $myfile = fopen('patientInformation.html', 'r') or die('unable to open html source');
    echo fread($myfile, filesize('patientInformation.html'));
    fclose($myfile);
    $conn -> close();
    header("Location: patientInformation.php");
?>