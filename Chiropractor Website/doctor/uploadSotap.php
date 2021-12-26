<?php

//server information
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

//connect to server
$conn = new mysqli($servername, $username, $password, $dbname);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
     }
    
     foreach($_POST as $key => $value) {
        clean($value); //cleans each value of the post request.
      }

    $_POST = json_decode(file_get_contents("php://input"), true);

    date_default_timezone_set("EST");
    $today = date("Y-m-d");
    $PNo =  $_POST["PNo"];

    $RNo = $_POST["rno"];


    //gets the index to add new symptoms to the table
    $newSNoIndex = $conn->query("SELECT MAX(SNo) FROM Symptoms WHERE PNo = " . $PNo . " ORDER BY SNo DESC")->fetch_assoc()["MAX(SNo)"] + 1;
    if($newSNoIndex == 1){
        $newSNoIndex = 0;
    }
    //inserts new symptoms to the table
    for ($i = $newSNoIndex; $i < count($_POST["newSym"]); $i++) {
        $q = "INSERT INTO Symptoms (PNo, SNo, S) VALUES (" . $PNo . ", " . $i . ", '" . $_POST["newSym"][$i] . "')";
        $conn->query($q);
    }

    //inserts  new symptom attribute to the table
    for ($i = 0; $i < count($_POST["newSym"]); $i++) {
        if ($_POST["newSymAtt"][$i] != "") {
            $q = "INSERT INTO SymptomsDesc (PNo, SNo, AptDate, SAtt) VALUES (" . $PNo . ", " . $i . ", '" . $today . "', '" . $_POST["newSymAtt"][$i] . "')";
            echo $q;
            $conn->query($q);
        }
    }

    //gets the index to add new observations to the table
    $newObsIndex = $conn->query("SELECT MAX(ONo) FROM Observations WHERE PNo = " . $PNo . " ORDER BY ONo DESC")->fetch_assoc()["MAX(ONo)"] + 1;
    //inserts new observations to the table
    if($newObsIndex == 1){
        $newObsIndex = 0;
    }
    for ($i = $newObsIndex; $i < count($_POST["newObs"]); $i++) {
        $q = "INSERT INTO Observations (PNo, ONo, O) VALUES (" . $PNo . ", " . $i . ", '" . $_POST["newObs"][$i] . "')";
        $conn->query($q);
    }

    //inserts  new observation attributes to the table
    for ($i = 0; $i < count($_POST["newObs"]); $i++) {
        if ($_POST["newObsAtt"][$i] != "") {
            $q = "INSERT INTO ObservationDesc (PNo, ONo, AptDate, OAtt) VALUES (" . $PNo . ", " . $i . ", '" . $today . "', '" . $_POST["newObsAtt"][$i] . "')";
            $conn->query($q);
        }
    }

    //gets the index to add new treatments to the table
    $newTreatIndex = $conn->query("SELECT MAX(TNo) FROM Treatment WHERE PNo = " . $PNo . " ORDER BY TNo DESC")->fetch_assoc()["MAX(TNo)"] + 1;
    //inserts new treatments to the table
    if($newTreatIndex == 1){
        $newTreatIndex = 0;
    }
    for ($i = $newTreatIndex; $i < count($_POST["newTreat"]); $i++) {
        $q = "INSERT INTO Treatment (PNo, TNo, T) VALUES (" . $PNo . ", " . $i . ", '" . $_POST["newTreat"][$i] . "')";
        $conn->query($q);
    }

    //inserts new treatment attributes to the table
    for ($i = 0; $i < count($_POST["newTreat"]); $i++) {
        if ($_POST["newTreatAtt"][$i] != "") {
            $q = "INSERT INTO TreatmentDesc (PNo, TNo, AptDate, TAtt) VALUES (" . $PNo . ", " . $i . ", '" . $today . "', '" . $_POST["newTreatAtt"][$i] . "')";
            $conn->query($q);
        }
    }

    //gets the index to add new assessments to the table
    $newAssessIndex = $conn->query("SELECT MAX(ANo) FROM Assessment WHERE PNo = " . $PNo . " ORDER BY ANo DESC")->fetch_assoc()["MAX(ANo)"] + 1;
    //inserts new assessments to the table
    if($newAssessIndex == 1){
        $newAssessIndex = 0;
    }
    for ($i = $newAssessIndex; $i < count($_POST["newAssessAtt"]); $i++) {
        $q = "INSERT INTO Assessment (PNo, ANo, A) VALUES (" . $PNo . ", " . $i . ", '" . $_POST["newAssess"][$i] . "')";
        $conn->query($q);
    }

    //inserts new assessment attributes to the table
    for ($i = 0; $i < count($_POST["newAssess"]); $i++) {
        if ($_POST["newAssessAtt"][$i] != "") {
            $q = "INSERT INTO AssessmentDesc (PNo, ANo, AptDate, AAtt) VALUES (" . $PNo . ", " . $i . ", '" . $today . "', '" . $_POST["newAssessAtt"][$i] . "')";
            $conn->query($q);
        }
    }

    //gets the index to add new plans to the table
    $newPlanIndex = $conn->query("SELECT MAX(PlNo) FROM Plan WHERE PNo = " . $PNo . " ORDER BY PlNo DESC")->fetch_assoc()["MAX(PlNo)"] + 1;
    //inserts new plans to the table
    if($newPlanIndex == 1){
        $newPlanIndex = 0;
    }
    for ($i = $newPlanIndex; $i < count($_POST["newPlan"]); $i++) {
        $q = "INSERT INTO Plan (PNo, PlNo, P) VALUES (" . $PNo . ", " . $i . ", '" . $_POST["newPlan"][$i] . "')";
        $conn->query($q);
    }

    //inserts new plan attributes to the table
    for ($i = 0; $i < count($_POST["newPlan"]); $i++) {
        if ($_POST["newPlanAtt"][$i] != "") {
            $q = "INSERT INTO PlanDesc (PNo, PlNo, AptDate, PlAtt) VALUES (" . $PNo . ", " . $i . ", '" . $today . "', '" . $_POST["newPlanAtt"][$i] . "')";
            $conn->query($q);
        }
    }

    //if the doctor wrote notes, add to the table
    if ($_POST["notes"] != "") {
        $q = "INSERT INTO ApptNotes (PNo, AptDate, Notes) VALUES (" . $PNo . ", '" . $today . "', '" . $_POST["notes"] . "')";
        echo $q;
        echo "fdsag";
        $conn->query($q);
    }
    
    //make room blank, so another patient can go into this room
    $sql = "UPDATE Rooms SET PNo = -1 WHERE RNo = " .  $RNo;

    if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
    } else {
    echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
