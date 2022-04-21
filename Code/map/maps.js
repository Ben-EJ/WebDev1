let map;
//16 elements (Green = 0-5, Orange = 6-10 Red = 11-16)
function newColourArray(len){
    const colours = ["#ccffcc","#80ff80","#4dff4d","#33ff33","#00cc00","#006600",  "#ffc299", "#ff944d", "#ff6600", "#e65c00", "#b34700",  "#ff8080", "#ff3333", "#ff0000", "#cc0000", "#990000"];

    const newGreen = [];
    const newOrange = [];
    const newRed = [];

    var usedGreen = false;
    var usedOrange = false;
    var usedRed = false; 

    var currentGreen = 0;
    var currentOrange = 6;
    var currentRed = 11;

    for(let i = 0; i < len; i++){
        if(usedGreen == false && currentGreen != 5){
            newGreen.push(colours[currentGreen]);
            currentGreen = currentGreen + 1;
            usedGreen = true;
        }
        else if(usedOrange == false && currentOrange != 10){
            newOrange.push(colours[currentOrange]);
            currentOrange = currentOrange + 1;
            usedOrange = true;
        }
        else if(currentRed != 15){
            newRed.push(colours[currentRed]);
            currentRed = currentRed + 1;
            usedGreen = false;
            usedOrange = false;
        }
    }
    console.log(newGreen);
    console.log(newOrange);
    console.log(newRed);
    return newGreen.concat(newOrange,newRed);
}
const colourEncodings = ["#9CFF9C","#31FF00","#31CF00",  "#FFFF00","#FFCF00","#FF9A00","#FF6464","#FF0000","#990000","#CE30FF"];
function colourLevel(level){
    if(level <= 67){
        return colourEncodings[0];
    }
    else if(level >= 68 && level <= 134){
        return colourEncodings[1];
    }
    else if(level >= 135 && level <= 200){
        return colourEncodings[2];
    }
    else if(level >= 201 && level <= 267){
        return colourEncodings[3];
    }
    else if(level >= 268 && level <= 334){
        return colourEncodings[4];
    }
    else if(level >= 335 && level <= 400){
        return colourEncodings[5];
    }
    else if(level >= 401 && level <= 467){
        return colourEncodings[6];
    }
    else if(level >= 468 && level <= 534){
        return colourEncodings[7];
    }
    else if(level >= 535 && level <= 600){
        return colourEncodings[8];
    }
    else if(level >= 601){
        return colourEncodings[9];
    }
}

function generateMarker(map,location, pollutantAmt, colour){
    return new google.maps.Marker({
        position: location,
        map,
        label:pollutantAmt,
        icon:{path: "M 0 0 z M 0 -6.984 q 2.906 0 4.945 2.039 t 2.039 4.945 q 0 1.453 -0.727 3.328 t -1.758 3.516 t -2.039 3.07 t -1.711 2.273 l -0.75 0.797 q -0.281 -0.328 -0.75 -0.867 t -1.688 -2.156 t -2.133 -3.141 t -1.664 -3.445 t -0.75 -3.375 q 0 -2.906 2.039 -4.945 t 4.945 -2.039 z",
                fillColor: colour,
                fillOpacity: 1,
                strokeWeight: 1,
                rotation: 0,
                scale: 2.5,
            },
    });
}
function getDate(timeStamp){
    var date = new Date(timeStamp * 1000);
    var humanReadableDate = date.toLocaleString(); 
    const dateAndTime = humanReadableDate.split(",");
    const splitDate = dateAndTime[0].split("/");
    const splitTime = dateAndTime[1].split(":");
                        //Day         Month        Year,        hour,         minute,      Second
    const dateSplitArray = [splitDate[0],splitDate[1],splitDate[2],splitTime[0], splitTime[1],splitTime[2]];
    return dateSplitArray;
}
function emptyMap(){
    console.log("initStart");
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 51.4545, lng: -2.5879 },
        zoom: 12,
    });
}
function initMap() {
    console.log("initStart");
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 51.4545, lng: -2.5879 },
        zoom: 12,
    });

    var selectYear = document.getElementById('year');
    var valueYear = selectYear.options[selectYear.selectedIndex].value;

    var selectMonth = document.getElementById('month');
    var valueMonth = selectMonth.options[selectMonth.selectedIndex].value;

    var selectDay = document.getElementById('day');
    var valueDay = selectDay.options[selectDay.selectedIndex].value;

    var selectTime = document.getElementById('time');
    var time = selectTime.options[selectTime.selectedIndex].value;

    var selectPollutants  = document.getElementById('pollutant');
    var pollutant = selectPollutants.options[selectPollutants.selectedIndex].value;

    const promises = [];
    const dataXML = ["data-188.xml", "data-203.xml", "data-206.xml", "data-209.xml", "data-213.xml", "data-215.xml", "data-228.xml", "data-270.xml", "data-271.xml", "data-375.xml", "data-395.xml", "data-452.xml", "data-447.xml", "data-459.xml", "data-463.xml", "data-500.xml", "data-501.xml"]//"data-481.xml"
    
    for(var i = 0; i < dataXML.length; i++){
        let ajaxPromise = new Promise(function(myResolve, myReject) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                myResolve(this.responseXML);
            }
            xhttp.onerror = function() {
                myReject("error");
            }
            xhttp.open("GET", "/WebDev1/Code/xmlFiles/" + dataXML[i]);
            xhttp.send();
        });
        promises.push(ajaxPromise);
    }
    Promise.all(promises).then((xmlDocs) => {
        console.log("Promises Complete");
        var data = [];
        for(var i = 0; i < xmlDocs.length; i++){
            const station = xmlDocs[i].getElementsByTagName("station");
            const recElements = xmlDocs[i].getElementsByTagName("rec");
            for(var x = 0; x < recElements.length; x++){
                ts = recElements[x].getAttribute('ts');
                dateTime = getDate(ts);
                if(dateTime[2] == valueYear && dateTime[1] == valueMonth && dateTime[0] == valueDay){
                    if(dateTime[3].toString().trim() == time.trim()){
                        var latLonRaw = station[0].getAttribute('geocode');
                        if(pollutant.trim() == "nox"){
                            var thePolNOX = recElements[x].getAttribute('nox');
                            if(thePolNOX == null){
                                console.log(thePolNOX);
                            }else{
                                data.push([thePolNOX,latLonRaw]);
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no"){
                            var thePolNO = recElements[x].getAttribute('no');
                            if(thePolNO == null){
                                console.log(thePolNO);
                            }else{
                                data.push([thePolNO,latLonRaw]);
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no2"){
                            var thePolNO2 = recElements[x].getAttribute('no2');
                            if(thePolNO2 == null){
                                console.log(thePolNO2);
                            }else{
                                data.push([thePolNO2,latLonRaw]);
                                console.log("Found");
                            }
                        }
                    }                    
                }
            }
        }
        
        var sorted = data.sort(function(a, b) {
            return a[0] - b[0];
        });
        
        console.log(sorted);
        colours = newColourArray(sorted.length);
        console.log(colours);
        for(let i = 0; i < sorted.length; i++){
            var array = sorted[i][1].split(",");
            console.log(array);
            generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, sorted[i][0], colours[i]);
        }

        var colourTable = document.getElementById("colourTable");
        colourTable.innerHTML = "";
        for(let i = 0; i < colours.length; i++){
            var row = colourTable.insertRow();
            var cellA = row.insertCell(0);
            var cellB = row.insertCell(1);
            
            cellA.innerHTML = '<div class="colorCell" style="background-color:' +  colours[i] + ';"></div>';
            if(i == 0){
                cellB.innerHTML = parseInt(data[0][0].toString());
            }else if(i == colours.length - 2){
                cellB.innerHTML = "v";
            }
            else if(i == colours.length - 1){
                cellB.innerHTML = parseInt(data[data.length - 1][0]);
            }else{
                cellB.innerHTML = "|";
            }
        }
    });
}

function initMapColourEncodings() {
    console.log("initStart");
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 51.4545, lng: -2.5879 },
        zoom: 12,
    });

    var selectYear = document.getElementById('year');
    var valueYear = selectYear.options[selectYear.selectedIndex].value;

    var selectMonth = document.getElementById('month');
    var valueMonth = selectMonth.options[selectMonth.selectedIndex].value;

    var selectDay = document.getElementById('day');
    var valueDay = selectDay.options[selectDay.selectedIndex].value;

    var selectTime = document.getElementById('time');
    var time = selectTime.options[selectTime.selectedIndex].value;

    var selectPollutants  = document.getElementById('pollutant');
    var pollutant = selectPollutants.options[selectPollutants.selectedIndex].value;

    const promises = [];
    const dataXML = ["data-188.xml", "data-203.xml", "data-206.xml", "data-209.xml", "data-213.xml", "data-215.xml", "data-228.xml", "data-270.xml", "data-271.xml", "data-375.xml", "data-395.xml", "data-452.xml", "data-447.xml", "data-459.xml", "data-463.xml", "data-500.xml", "data-501.xml"]//"data-481.xml"
    
    for(var i = 0; i < dataXML.length; i++){
        let ajaxPromise = new Promise(function(myResolve, myReject) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                myResolve(this.responseXML);
            }
            xhttp.onerror = function() {
                myReject("error");
            }
            xhttp.open("GET", "/WebDev1/Code/xmlFiles/" + dataXML[i]);
            xhttp.send();
        });
        promises.push(ajaxPromise);
    }
    Promise.all(promises).then((xmlDocs) => {
        console.log("Promises Complete");
        var data = [];
        for(var i = 0; i < xmlDocs.length; i++){
            const station = xmlDocs[i].getElementsByTagName("station");
            const recElements = xmlDocs[i].getElementsByTagName("rec");
            for(var x = 0; x < recElements.length; x++){
                ts = recElements[x].getAttribute('ts');
                dateTime = getDate(ts);
                if(dateTime[2] == valueYear && dateTime[1] == valueMonth && dateTime[0] == valueDay){
                    if(dateTime[3].toString().trim() == time.trim()){
                        var latLonRaw = station[0].getAttribute('geocode');
                        var array = latLonRaw.split(",");
                        if(pollutant.trim() == "nox"){
                            var thePolNOX = recElements[x].getAttribute('nox');
                            if(thePolNOX == null){
                                console.log(thePolNOX);
                            }else{
                                var thePolNOXInt = parseInt(thePolNOX);
                                generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, thePolNOXInt.toString(), colourLevel(thePolNOX));
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no"){
                            var thePolNO = recElements[x].getAttribute('no');
                            
                            if(thePolNO == null){
                                console.log(thePolNO);
                            }else{
                                var thePolNOInt = parseInt(thePolNO);
                                generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, thePolNOInt.toString(), colourLevel(thePolNO));
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no2"){
                            var thePolNO2 = recElements[x].getAttribute('no2');
                            if(thePolNO2 == null){
                                console.log(thePolNO2);
                            }else{
                                var thePolNO2Int = parseInt(thePolNO2);
                                generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, thePolNO2Int.toString(), colourLevel(thePolNO2));
                                console.log("Found");
                            }
                        }
                    }                    
                }
            }
        }

        var colourTable = document.getElementById("colourTable");
        colourTable.innerHTML = "";
        for(let i = 0; i < colourEncodings.length; i++){
            var row = colourTable.insertRow();
            var cellA = row.insertCell(0);
            var cellB = row.insertCell(1);
            
            cellA.innerHTML = '<div class="colorCell" style="background-color:' +  colourEncodings[i] + ';"></div>';
            if(i == 0){
                cellB.innerHTML = "0";
            }else if(i == colourEncodings.length - 2){
                cellB.innerHTML = "v";
            }
            else if(i == colourEncodings.length - 1){
                cellB.innerHTML = "601";
            }else{
                cellB.innerHTML = "|";
            }
        }
    });
}

window.initMap = initMap;
