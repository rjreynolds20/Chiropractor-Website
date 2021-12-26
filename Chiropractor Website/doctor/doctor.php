<?php

    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    //opens connection to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    $rno = $_POST["roomButton"];

    //checks connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //grabs the correct PNo 
    $pno_sql = "SELECT PNo FROM Rooms WHERE RNo = ". $rno;
    $result = $conn->query($pno_sql);
    if ($result->num_rows > 0) {
        $PNo = $result->fetch_assoc()["PNo"]; 
    }
    //queries for SOTAP
    $symptomList = "SELECT S FROM Symptoms WHERE PNo = '".$PNo ."'";
    $symptomAttList = "SELECT SAtt FROM SymptomsDesc WHERE PNo = '".$PNo ."'";

    $obsList = "SELECT O FROM Observations WHERE PNo = '".$PNo ."'";
    $obsAttList = "SELECT OAtt FROM ObservationDesc WHERE PNo = '".$PNo ."'";

    $treatList = "SELECT T FROM Treatment WHERE PNo = '".$PNo ."'";
    $treatAttList = "SELECT TAtt FROM TreatmentDesc WHERE PNo = '".$PNo ."'";

    $assessList = "SELECT A FROM Assessment WHERE PNo = '".$PNo ."'";
    $assessAttList = "SELECT AAtt FROM AssessmentDesc WHERE PNo = '".$PNo ."'";

    $planList = "SELECT P FROM Plan WHERE PNo = '".$PNo ."'";
    $planAttList = "SELECT PlAtt FROM PlanDesc WHERE PNo = '".$PNo ."'";
    
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

    //saves address of the associated PNo
    $AddrsQ = json_encode(($conn->query($addy)->fetch_assoc()["Addrs"]));
    //saves zip of the associated PNo 
    $zipQ = json_encode(($conn->query($zip)->fetch_assoc()["Zip"]));
    //saves insuarance name of associated PNo
    $insNameQ = json_encode(($conn->query($insName)->fetch_assoc()["InsName"]));
    //saves member id of associated PNo
    $memidQ = json_encode(($conn->query($memid)->fetch_assoc()["MemId"]));

    //queries to grab city and state (they use address and zip)
    $city = "SELECT City FROM FullAddress WHERE Addrs = " . $AddrsQ . " and Zip=" . $zipQ;
    $state = "SELECT St8 FROM FullAddress WHERE Addrs = " . $AddrsQ . " and Zip=" . $zipQ;

    //queries to grab group number and expiration date (they use insuarance name and member id)
    $groupNum = "SELECT GrNo FROM Insurance WHERE InsName = " . $insNameQ . " and MemId=" . $memidQ;
    $exDate = "SELECT ExpDate FROM Insurance WHERE InsName = " . $insNameQ . " and MemId=" . $memidQ;

    //PRE: querystring is a valid string, conn is a current connection to a db
    //POST: echos the queries as lists into javascript
    function injectListToJs($queryString, $desc, $conn) {
        $result = $conn->query($queryString);
        $arr = json_encode($result->fetch_all());
        //echo $arr;
        echo ("<script> const $desc = $arr</script>");
    }
    
    //injects user information to JS
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

    //injects SOTAP information to JS 
    injectListToJs($symptomList, "symptomList", $conn);
    injectListToJs($symptomAttList, "symptomAttList", $conn);
    injectListToJs($obsList, "obsList", $conn);
    injectListToJs($obsAttList, "obsAttList", $conn);   
    injectListToJs($treatList, "treatList", $conn);
    injectListToJs($treatAttList, "treatAttList", $conn);
    injectListToJs($assessList, "assessList", $conn);
    injectListToJs($assessAttList, "assessAttList", $conn);
    injectListToJs($planList, "planList", $conn);
    injectListToJs($planAttList, "planAttList", $conn);


    //injects PNo and rno to JS
    echo("<script> PNo = $PNo </script>");
    echo("<script> rno = $rno </script>");

    // opens html file with loaded data from SQL
    $myfile = fopen('room_1.html', 'r') or die('unable to open html source');
    echo fread($myfile, filesize('room_1.html'));
    fclose($myfile);
    $conn -> close();
    
    ?>