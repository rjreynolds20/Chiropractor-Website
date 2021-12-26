<?php

$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $_POST = json_decode(file_get_contents("php://input"), true);
    
    //sends history for this symptom to JS
    if ($_POST["list"] === "sym") {
        $SNo = $conn->query("SELECT SNo FROM Symptoms WHERE S = '".$_POST["elem"]. "'")->fetch_assoc()["SNo"];

        $queryString = "SELECT SAtt from SymptomsDesc where PNo=" . $_POST["PNo"] . " and SNo=" . $SNo;
        
        $result = $conn->query($queryString);

        $arr = json_encode($result->fetch_all());
        echo ($arr);
    }
    //sends history for this observation to JS
    if ($_POST["list"] === "obs") {
        $ONo = $conn->query("SELECT ONo FROM Observations WHERE O = '".$_POST["elem"]. "'")->fetch_assoc()["ONo"];

        $queryString = "SELECT OAtt from ObservationDesc where PNo=" . $_POST["PNo"] . " and ONo=" . $ONo;
        
        $result = $conn->query($queryString);

        $arr = json_encode($result->fetch_all());
        echo ($arr);
    }
    //sends history for this treatment to JS
    if ($_POST["list"] === "tre") {
        $TNo = $conn->query("SELECT TNo FROM Treatment WHERE T = '".$_POST["elem"]. "'")->fetch_assoc()["TNo"];

        $queryString = "SELECT TAtt from TreatmentDesc where PNo=" . $_POST["PNo"] . " and TNo=" . $TNo;
        
        $result = $conn->query($queryString);

        $arr = json_encode($result->fetch_all());
        echo ($arr);
    }
    //send history for this assessment to JS
    if ($_POST["list"] === "ase") {
        $ANo = $conn->query("SELECT ANo FROM Assessment WHERE A = '".$_POST["elem"]. "'")->fetch_assoc()["ANo"];

        $queryString = "SELECT AAtt from AssessmentDesc where PNo=" . $_POST["PNo"] . " and ANo=" . $ANo;
        
        $result = $conn->query($queryString);

        $arr = json_encode($result->fetch_all());
        echo ($arr);
    }
    //sends history for this plan to JS
    if ($_POST["list"] === "pln") {
        $PlNo = $conn->query("SELECT PlNo FROM Plan WHERE P = '".$_POST["elem"]. "'")->fetch_assoc()["PlNo"];

        $queryString = "SELECT PlAtt from PlanDesc where PNo=" . $_POST["PNo"] . " and PlNo=" . $PlNo;
        
        $result = $conn->query($queryString);

        $arr = json_encode($result->fetch_all());
        echo ($arr);
    }

    
 
 }


?>