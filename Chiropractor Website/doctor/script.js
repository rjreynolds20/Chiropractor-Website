
let coll = document.getElementsByClassName("collapsible");
let i;
//creates collapsible container for SOTAP
for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
        this.classList.toggle("active");
        let content = this.nextElementSibling;
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
}


// populates the page with the patient information
document.getElementById("name").innerHTML = Pname;
document.getElementById("headerName").innerHTML = Pname;
document.getElementById("dob").innerHTML = Pdob;
document.getElementById("age").innerHTML = Page;
document.getElementById("gender").innerHTML = Pgender;
document.getElementById("address").innerHTML = Paddy;
document.getElementById("city").innerHTML = Pcity;
document.getElementById("state").innerHTML = Pstate;
document.getElementById("zip").innerHTML = Pzip;
document.getElementById("phone").innerHTML = Pphone;
document.getElementById("email").innerHTML = Pemail;
document.getElementById("insurancename").innerHTML = PinsName;
document.getElementById("memberid").innerHTML = Pmemid;
document.getElementById("groupnumber").innerHTML = PgroupNum;
document.getElementById("expirationdate").innerHTML = PexDate;

//PRE: arr is a valid array 
//POST: the php sends each element as an array, so this converts the 1d array to a string.
function arrToElem(arr) {
    for (let i = 0; i < arr.length; i++) {
        arr[i] = arr[i][0];
    }
}

arrToElem(symptomList);
arrToElem(symptomAttList);
arrToElem(obsList);
arrToElem(obsAttList);
arrToElem(treatList);
arrToElem(treatAttList);
arrToElem(assessList);
arrToElem(assessAttList);
arrToElem(planList);
arrToElem(planAttList);

let symptoms = document.getElementById("symptom");
let symptomCounter = 0;
const symptomIdentifier = "sym";

let obs = document.getElementById("observation");
let obsCounter = 0;
const obsIdentifier = "obs";

let treat = document.getElementById("treatment");
let treatCounter = 0;
const treatIdentifier = "tre";

let assess = document.getElementById("assessment");
let assessCounter = 0;
const assessIdentifier = "ase";

let plan = document.getElementById("plan");
let planCounter = 0;
const planIdentifier = "pln";

//initializes lists
let newSym = symptomList;
let newSymAtt = new Array(symptomList.length).fill("");

let newObs = obsList;
let newObsAtt = new Array(obsList.length).fill("");


let newTreat = treatList;
let newTreatAtt = new Array(treatList.length).fill("");

let newAssess = assessList;
let newAssessAtt = new Array(assessList.length).fill("");

let newPlan = planList;
let newPlanAtt = new Array(planList.length).fill("");

// fills page with lists
fillCollapse(symptomList, symptomAttList, symptom, symptomCounter, symptomIdentifier);
fillCollapse(obsList, obsAttList, obs, obsCounter, obsIdentifier);
fillCollapse(treatList, treatAttList, treat, treatCounter, treatIdentifier);
fillCollapse(assessList, assessAttList, assess, assessCounter, assessIdentifier);
fillCollapse(planList, planAttList, plan, planCounter, planIdentifier);

//PRE: list, attList are valid arrays, container is a valid div in HTML,
//       identifier is a valid id
//POST: fills associated collapsible content with values
function fillCollapse(list, attList, container, counter, identifier) {
    for (let i = 0; i < list.length; i++) {
        addElemFromList(list, attList, container, counter, identifier, i);
        counter++;
    }

    if (identifier == "sym") { symptomCounter = counter; }
    else if (identifier == "obs") { obsCounter = counter; }
    else if (identifier == "tre") { treatCounter = counter; }
    else if (identifier == "ase") { assessCounter = counter; }
    else if (identifier == "pln") { planCounter = counter; }

}

//PRE: list are valid arrays, container is a valid div in HTML,
//       identifier is a valid id
//POST: adds an element from a list to the specified container
function addElemFromList(list, attList = [], container, counter, identifier, i = 0) {
    let index = document.createElement("span");
    index.innerText = counter + 1;
    index.style.fontWeight = "bold";
    index.style.fontSize = "20px";
    index.style.marginLeft = "-50px";
    index.style.marginTop = "17px";

    let left = document.createElement("p");
    left.innerHTML = list[i];
    container.appendChild(left);

    let right = document.createElement("input");
    if (attList.length == 1) {
        right.value = attList[i];
    }
    right.addEventListener("keyup", function () { addDesc(right.id) });

    container.appendChild(right);

    let button = document.createElement("button");
    button.innerHTML = "History";
    button.id = "history"
    button.addEventListener("click", function () { displayHistory(button.id) });
    container.appendChild(button);

    left.classList.add("input");
    right.classList.add("input");
    button.classList.add("button");

    index.id = identifier + "Count-" + counter;
    left.id = identifier + "-" + counter;
    right.id = identifier + "Att-" + counter;
    button.id = identifier + "Btn-" + counter;
}

let addId = "";

//PRE: id is a valid identifier of SOTAP
//POST: displays the history of the associated symptom
function displayHistory(id) {

    const myNode = document.getElementById("addHistory");
    myNode.innerHTML = '';
    identifier = id.substring(0, 3);
    index = id.substring(id.length - 1);

    let object = identifier + "-" + index;
    let val = document.getElementById(object).innerHTML;

    //adds history to the history popup on the page
    function callback(data) { 
        data.forEach(element => {
            const newElem = document.createElement("p");
            newElem.innerHTML = element;
            document.getElementById('addHistory').appendChild(newElem);
        });
    }

    //xml request to retrieve history of symptom
    var xmlhttp = new XMLHttpRequest;
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4) { //request is done
            if (xmlhttp.status === 200) { //request was successful
                callback(JSON.parse(xmlhttp.response)); 
            } else { //there is no history found for this element
                const newElem = document.createElement("p");
                newElem.innerHTML = "No history found for " + val;
                document.getElementById('addHistory').appendChild(newElem);
            }
        }
    };
    xmlhttp.open('POST', "./history.php");
    xmlhttp.send(JSON.stringify({ PNo: PNo, list: identifier, elem: val }));

    document.getElementById('historyForm').style.display = "block";
}

//PRE: id is a valid container on the page
//POST: displays form on page
function openForm(id) {
    document.getElementById("left").value = "";
    document.getElementById("right").value = "";
    addId = id;
    document.getElementById('myForm').style.display = "block";
}

//PRE: id is a valid container on the page
//POST: closes form on page
function closeForm(id) {
    document.getElementById(id).style.display = "none";

}

//PRE:
//POST: checks identifier to populate new elem 
function addDriver() {
    if (addId === "sym") {
        addElem(symptoms, symptomCounter++, symptomIdentifier);
    } else if (addId === "obs") {
        addElem(obs, obsCounter++, obsIdentifier);
    } else if (addId === "treat") {
        addElem(treat, treatCounter++, treatIdentifier);
    } else if (addId === "assess") {
        addElem(assess, assessCounter++, assessIdentifier);
    } else if (addId === "plan") {
        addElem(plan, planCounter++, planIdentifier);
    }
}

//PRE: container is an element in the HTML, identifier
//      is a valid SOTAP identifier
//POST: adds element on button click 
function addElem(container, counter, identifier) {
    const left = document.getElementById("left").value;
    const right = document.getElementById("right").value;
    if (left !== "" && right !== "") {
        addElemFromList([left], [right], container, counter, identifier);
        document.getElementById("myForm").style.display = "none";

        if (identifier === "sym") {
            newSym.push(left);
            newSymAtt.push(right);
        } else if (identifier === "obs") {
            newObs.push(left);
            newObsAtt.push(right);
        } else if (identifier === "tre") {
            newTreat.push(left);
            newTreatAtt.push(right);
        } else if (identifier === "ase") {
            newAssess.push(left);
            newAssessAtt.push(right);
        } else if (identifier === "pln") {
            newPlan.push(left);
            newPlanAtt.push(right);
        }

    }

}

let notes = "";
document.getElementById("notes").addEventListener("keyup", function () { addNotes() });

//PRE:
//POST: updates notes variable on change
function addNotes() {
    notes = document.getElementById("notes").value;
}

//PRE: id is a valid HTML object
//POST: adds description 
function addDesc(id) {
    identifier = id.substring(0, 3);
    index = id.substring(id.length - 1);
    container = document.getElementById(id).value;

    if (identifier === "sym") {
        newSymAtt[index] = container;
    } else if (identifier === "obs") {
        newObsAtt[index] = container;
    } else if (identifier === "tre") {
        newTreatAtt[index] = container;
    } else if (identifier === "ase") {
        newAssessAtt[index] = container;
    } else if (identifier === "pln") {
        newPlanAtt[index] = container;
    }

}

//PRE:
//POST: uploads sotap information to php
function submitSotap() {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "uploadSotap.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.send(JSON.stringify({
        newSym: newSym,
        newSymAtt: newSymAtt,
        newObs: newObs,
        newObsAtt: newObsAtt,
        newTreat: newTreat,
        newTreatAtt: newTreatAtt,
        newAssess: newAssess,
        newAssessAtt: newAssessAtt,
        newPlan: newPlan,
        newPlanAtt: newPlanAtt,
        PNo: PNo,
        notes: notes,
        rno: rno
    }));
    window.location.href = "redirect.html";
}
