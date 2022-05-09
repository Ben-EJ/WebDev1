let map;

// Generates an array of colours ranging from light green to dark red, 
//ammount of colours generated depends on ammount of stations with data. 
function newColourArray(len){
    const colours = ["#ccffcc","#80ff80","#4dff4d","#33ff33","#00cc00","#006600",  "#ffc299", "#ff944d", "#ff6600", "#e65c00", "#b34700",  "#ff8080", "#ff3333", "#ff0000", "#cc0000", "#990000"];

    const newGreen = [];
    const newOrange = [];
    const newRed = [];

    var usedGreen = false;
    var usedOrange = false;

    var currentGreen = 0;
    var currentOrange = 6;
    var currentRed = 11;

    for(let i = 0; i < len; i++){// For each station with data
        // If have not added a green colour to array and current index of green colours is not yet 5 then:
        if(usedGreen == false && currentGreen != 5){ 
            // Add a green hex code to array.
            newGreen.push(colours[currentGreen]);
            currentGreen = currentGreen + 1;
            usedGreen = true;
        }
        // If have not added a orange colour to array and current index of orange colours is not yet 10 then:
        else if(usedOrange == false && currentOrange != 10){
            // Add a orange hex code to array.
            newOrange.push(colours[currentOrange]);
            currentOrange = currentOrange + 1;
            usedOrange = true;
        }
        // If have not added a red colour to array and current index of red colours is not yet 15 then:
        else if(currentRed != 15){
            // Add a red hex code to array.
            newRed.push(colours[currentRed]);
            currentRed = currentRed + 1;
            usedGreen = false;
            usedOrange = false;
        }
    }
    return newGreen.concat(newOrange,newRed);
}

const colourEncodings = ["#9CFF9C","#31FF00","#31CF00",  "#FFFF00","#FFCF00","#FF9A00","#FF6464","#FF0000","#990000","#CE30FF"];
//Function returns colour depending on the polution level given in level parameter.
// Colour selection is based on colour encodings table on assignment brief. 
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

// Function creates new marker based on location, pollutantAmt, colour parameters.
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
// Converts Unix timestamp back into readable date and time.
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
// Generates an empty map to display on HTML document.
function emptyMap(){
    console.log("initStart");
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 51.4545, lng: -2.5879 },
        zoom: 12,
    });
}
//Function generates key table based on the selected colours in colourEncodings and
// the highest and lowest values in a given dataset.
function generateTableKey(colourEncodings, start, end){
    var colourTable = document.getElementById("colourTable");
        colourTable.innerHTML = "";
        for(let i = 0; i < colourEncodings.length; i++){// For each colour
            var row = colourTable.insertRow(); // Insert row in table
            var cellA = row.insertCell(0);// Insert cell in table
            var cellB = row.insertCell(1);// Insert cell in table
            
            // Put a coloured div in cell, the colour is set to a given colour in colourEncodings.
            cellA.innerHTML = '<div class="colorCell" style="background-color:' +  colourEncodings[i] + ';"></div>';
            // The code bellow determines whether the cell in the second column should be a:
            // "v"(Down arrow) or "|" (Line) or start (Lowest value in data set) or end (highest value in data set).
            if(i == 0){
                cellB.innerHTML = start;
            }else if(i == colourEncodings.length - 2){
                cellB.innerHTML = "v";
            }
            else if(i == colourEncodings.length - 1){
                cellB.innerHTML = end;
            }else{
                cellB.innerHTML = "|";
            }
        }
}
// Generates a map with heatmap style markers to display on HTML document.
function initMap() {
    console.log("initStart");
    // Next few lines creates and empty map to plot markers.
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 51.4545, lng: -2.5879 },
        zoom: 12,
        draggable: false
    });
    // Next few lines take user input and store in variables.
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
        // For each of the stations get XML document:
        let ajaxPromise = new Promise(function(myResolve, myReject) {// Create new promise
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                myResolve(this.responseXML);
            }
            xhttp.onerror = function() {
                myReject("error");
            }
            xhttp.open("GET","/" + dataXML[i]);
            xhttp.send();
        });
        promises.push(ajaxPromise);
    }
    Promise.all(promises).then((xmlDocs) => {// After all promises are complete:
        console.log("Promises Complete");
        var data = [];
        for(var i = 0; i < xmlDocs.length; i++){// For each XML Document.
            const station = xmlDocs[i].getElementsByTagName("station"); //Get station element
            const recElements = xmlDocs[i].getElementsByTagName("rec");// Get rec elements
            for(var x = 0; x < recElements.length; x++){// For each of the rec elements
                ts = recElements[x].getAttribute('ts');// Gets unixtime stamp.
                dateTime = getDate(ts);// converts unixtime stamp back into readable date and time.
                // If recs date matches that of the users inputed date then.
                if(dateTime[2] == valueYear && dateTime[1] == valueMonth && dateTime[0] == valueDay){
                    // If the time of the rec element matches the time selected by the user then:
                    if(dateTime[3].toString().trim() == time.trim()){
                        var latLonRaw = station[0].getAttribute('geocode');// gets rec geocode
                        if(pollutant.trim() == "nox"){// if user selected pollutant is nox then:
                            var thePolNOX = recElements[x].getAttribute('nox');// get nox attrabute from rec
                            if(thePolNOX == null){// Checks to see if pollutant has no value
                                console.log(thePolNOX);
                            }else{
                                // Push the NOX value and lat and log value in an array and push array to data array.
                                // Will be used to make a marker for the map
                                var noDecimalsNOX = parseInt(thePolNOX);// To remove everything after decimal point
                                data.push([noDecimalsNOX.toString(),latLonRaw]);
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no"){// if user selected pollutant is no then:
                            var thePolNO = recElements[x].getAttribute('no');
                            if(thePolNO == null){// Checks to see if pollutant has no value
                                console.log(thePolNO);
                            }else{
                                // Push the NO value and lat and log value in an array and push array to data array.
                                // Will be used to make a marker for the map
                                var noDecimalsNO = parseInt(thePolNO);// To remove everything after decimal point
                                data.push([noDecimalsNO.toString(),latLonRaw]);
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no2"){// if user selected pollutant is no2 then:
                            var thePolNO2 = recElements[x].getAttribute('no2');
                            if(thePolNO2 == null){// Checks to see if pollutant has no value
                                console.log(thePolNO2);
                            }else{
                                // Push the NO2 value and lat and log value in an array and push array to data array.
                                // Will be used to make a marker for the map
                                var noDecimalsNO2 = parseInt(thePolNO2);// To remove everything after decimal point
                                data.push([noDecimalsNO2.toString(),latLonRaw]);
                                console.log("Found");
                            }
                        }
                    }                    
                }
            }
        }
        
        // Sort the data by second element (pollutant) in nested array.
        var sorted = data.sort(function(a, b) {
            return a[0] - b[0];
        });

        // Generate list of colours with the number of colours in said array being,
        // the same as the number of stations with data
        colours = newColourArray(sorted.length);

        // Create marker on map for each station with data.
        for(let i = 0; i < sorted.length; i++){
            var array = sorted[i][1].split(",");
            generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, sorted[i][0], colours[i]);
        }

        //Generate key table.
        generateTableKey(colours, parseInt(data[0][0].toString()), parseInt(data[data.length - 1][0]));
    });
}
// Generates a map where the markers are coloured based on the colour encodings table on the assignment brief.
function initMapColourEncodings() {
    console.log("initStart");
    // Next few lines creates and empty map to plot markers.
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 51.4545, lng: -2.5879 },
        zoom: 12,
        draggable: false
    });
    // Next few lines take user input and store in variables.
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
    // For each of the stations get XML document:
    for(var i = 0; i < dataXML.length; i++){// Create new promise
        let ajaxPromise = new Promise(function(myResolve, myReject) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                myResolve(this.responseXML);
            }
            xhttp.onerror = function() {
                myReject("error");
            }
            xhttp.open("GET","/" + dataXML[i]);
            xhttp.send();
        });
        promises.push(ajaxPromise);
    }
    Promise.all(promises).then((xmlDocs) => {// After all promises are complete:
        console.log("Promises Complete");
        var data = [];
        for(var i = 0; i < xmlDocs.length; i++){// For each XML Document.
            const station = xmlDocs[i].getElementsByTagName("station"); //Get station element
            const recElements = xmlDocs[i].getElementsByTagName("rec");// Get rec elements
            for(var x = 0; x < recElements.length; x++){// For each of the rec elements
                ts = recElements[x].getAttribute('ts');// Gets unixtime stamp.
                dateTime = getDate(ts);// converts unixtime stamp back into readable date and time.
                // If recs date matches that of the users inputed date then.
                if(dateTime[2] == valueYear && dateTime[1] == valueMonth && dateTime[0] == valueDay){
                    // If the time of the rec element matches the time selected by the user then:
                    if(dateTime[3].toString().trim() == time.trim()){
                        var latLonRaw = station[0].getAttribute('geocode');// gets rec geocode
                        var array = latLonRaw.split(",");
                        if(pollutant.trim() == "nox"){// if user selected pollutant is nox then:
                            var thePolNOX = recElements[x].getAttribute('nox');// get nox attrabute from rec
                            if(thePolNOX == null){// Checks to see if pollutant has no value
                                console.log(thePolNOX);
                            }else{
                                // Use Log, lat and nox pollutant to create a marker
                                var thePolNOXInt = parseInt(thePolNOX);// Removes decimal places
                                generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, thePolNOXInt.toString(), colourLevel(thePolNOX));
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no"){// if user selected pollutant is no then:
                            var thePolNO = recElements[x].getAttribute('no');
                            
                            if(thePolNO == null){// Checks to see if pollutant has no value
                                console.log(thePolNO);
                            }else{
                                // Use Log, lat and no pollutant to create a marker
                                var thePolNOInt = parseInt(thePolNO);// Removes decimal places
                                generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, thePolNOInt.toString(), colourLevel(thePolNO));
                                console.log("Found");
                            }
                        }
                        else if(pollutant.trim() == "no2"){// if user selected pollutant is no2 then:
                            var thePolNO2 = recElements[x].getAttribute('no2');
                            if(thePolNO2 == null){// Checks to see if pollutant has no value
                                console.log(thePolNO2);
                            }else{
                                // Use Log, lat and no2 pollutant to create a marker
                                var thePolNO2Int = parseInt(thePolNO2);// Removes decimal places
                                generateMarker(map, { lat: parseFloat(array[0]), lng: parseFloat(array[1]) }, thePolNO2Int.toString(), colourLevel(thePolNO2));
                                console.log("Found");
                            }
                        }
                    }                    
                }
            }
        }
        //Generate key table.
        generateTableKey(colourEncodings, 0, 601);
    });
}
window.initMap = initMap;
