
function extractToCSV() 
{ 
    location.href = 'extract-to-csv.php'; 
}
function normalizeToXML() 
{ 
    location.href = 'normalize-to-xml.php'; 
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

google.charts.load('current', {'packages':['corechart']});
//google.charts.setOnLoadCallback(drawChart);

// Function to find average of values in a given array
function average(theArray){
    var lenArray = theArray.length;
    var runningTotal = 0;
    for (let i = 0; i < lenArray; i++){
        runningTotal = runningTotal + parseInt(theArray[i]);
    }
    return runningTotal / lenArray;
}

// Builds and displays Scatter chart based on input array 
function displayScatter(monthsArray){
    //Next two lines delete any pre existing charts and hide the No Data Img.
    document.getElementById("chart_div").innerHTML = "";
    document.getElementById('NoDataImg').hidden = true;
    
    // Formats data into array to be visualised by chart
    var data = google.visualization.arrayToDataTable([
        ['Month', 'NO Levels'],
        [1,monthsArray[0]],
        [2,monthsArray[1]],
        [3,monthsArray[2]],
        [4,monthsArray[3]],
        [5,monthsArray[4]],
        [6,monthsArray[5]],
        [7,monthsArray[6]],
        [8,monthsArray[7]],
        [9,monthsArray[8]],
        [10,monthsArray[9]],
        [11,monthsArray[10]],
        [12,monthsArray[11]]
    ]);
    // Sets options for charts.
    var options = {
        title: 'A scatter chart to show a years worth of data (averaged by month) from a specific station for Carbon Monoxide.',
        hAxis: {title: 'Month', minValue: 0, maxValue: 12},
        vAxis: {title: 'NO Levels', minValue: 0, maxValue: Math.max(monthsArray)},
        legend: 'none'
    };
    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));// Selects chart div in html document.
    chart.draw(data, options);//Draws chart.
}
// Processes XML doc to turn into a scatter chart.
function loadXMLDocScatter() {
    // Bellow lines of code get and store data from the UI options on HTML page.
    var selectStation = document.getElementById('station');
    var valueStation = selectStation.options[selectStation.selectedIndex].value;

    var selectYear = document.getElementById('year');
    var valueYear = selectYear.options[selectYear.selectedIndex].value;

    var selectTime = document.getElementById('time');
    var valueTime = selectTime.options[selectTime.selectedIndex].value;
    
    // Creates new XMLHttpRequest 
    const xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        const monthArray = {
            "01": [],
            "02": [],
            "03": [],
            "04": [],
            "05": [],
            "06": [],
            "07": [],
            "08": [],
            "09": [],
            "10": [],
            "11": [],
            "12": []
        };
        var finished = false;
        if (this.readyState == 4 && this.status == 200) {// When file is received: 
            const xmlDoc = this.responseXML;
            const x = xmlDoc.getElementsByTagName("rec");// Get all rec elements and store in array.
            let txt = "";
            for (let i = 0; i < x.length; i++) {// For all rec elements
                ts = x[i].getAttribute('ts');// Get the ts attrabute.
                dateTime = getDate(ts); // Convert Unix timestamp into readable data and time.
                no = x[i].getAttribute('no'); // Get no attrabute from rec element.
                if(dateTime[2].trim() == valueYear && dateTime[3].trim() == valueTime){// If the year and time is correct then
                    monthArray[dateTime[1].toString()].push(no); // Store NO data in monthArray. 
                }
            }
            finished = true;
        };
        if(finished == true){// When all data has been added to monthArray then:
            //Average all months in year and store in monthAverages array.
            const monthAverages = []
            for(const [key, value] of Object.entries(monthArray)){
                if(value.length != 0){
                    monthAverages.push(average(value));
                }else{
                    monthAverages.push(0);
                } 
            }
            displayScatter(monthAverages); // Display the scatter chart.
        }
    }
    xhttp.open("GET","/" + valueStation);
    xhttp.send();
} 
// Function gets station number from station xml file name.
function getStationNumber(stations){
    var stationsFormated = [];
    for(var i = 0; i < stations.length; i++){
        split1 = stations[i].split("-");
        split2 = split1[1].split(".");
        stationsFormated.push(split2[0]);
    }
    return stationsFormated;
}
// Function to display line chart.
function displayLine(storage, times, stations, pollutant, day,month,year) {   
    //Next two lines delete any pre existing charts and hide the No Data Img.
    document.getElementById("chart_div").innerHTML = "";
    document.getElementById('NoDataImg').hidden = true;

    var stationsFormated = getStationNumber(stations);
    var stationListNotEmpty = [];
    var stationsDataNotEmpty = [];
    var stationsEmpty = [];
    // Sorts both the names of the stations and station data into an array,
    // based on whether a given station has data or not.
    for (var k = 0; k < storage.length; k++){// For each station in storage
        var empty = false;
        for (const [key, value] of Object.entries(storage[k])) {// Check to see if station has data.
            if(value == null){
                empty = true;
            }else{
                empty = false;
            }
        } 
        if(empty == false){// If the station has data:
            // Append station name and data to respective arrays.
            stationsDataNotEmpty.push(storage[k]); // Append data
            stationListNotEmpty.push(stationsFormated[k]); // Append station name.
        }else{
            // Append station name to stationsEmpty array if the station has no data.
            stationsEmpty.push(stationsFormated[k]);
        }
    }
    if(stationsEmpty.length != 6){ // Ensures atleast one station has data.
        stationListNotEmpty.unshift(pollutant); // Inserts pollutant at begining of stationListNotEmpty array.
        var dataToDisplay = [stationListNotEmpty]
         
        for(var z = 0; z < times.length; z++){ 
            var data = [times[z]];// Adds the time to beginning of the array.
            // Next few lines of code add data from a given station for a spesific time,
            // if it matches the current time in the times[z] array.
            for(var x = 0; x < stationsDataNotEmpty.length; x++){
                for (const [key, value] of Object.entries(stationsDataNotEmpty[x])) {
                    if(key.toString().trim() == times[z]){
                        data.push(parseInt(value));
                    }
                    
                }
            }
            dataToDisplay.push(data);
        }
        
        // next few lines of code create line chart.
        var data = google.visualization.arrayToDataTable(dataToDisplay);

            var options = {
            title: pollutant + " " + "Pollutant Levels For 6 Stations for the date: " + day + "-" + month + "-" + year,
            curveType: "function",
            legend: { position: "bottom"},
            interpolateNulls: true,
            hAxis: {title: "Time (24hr) " + " \n " + "(No Data for time specified: "  + stationsEmpty + ")"},
            vAxis: {title: pollutant + " Levels"}
            };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }else{
        // Display no data image if none of the stations have any data for the parameters selected.
        document.getElementById('NoDataImg').hidden = false;
    }
}
// Function is used to get all hours inbetween start and end times.
function countUpTime(numStart, numEnd){
    var arr = [];
    // If the end number is 0 then it is the equivelent to 24 hours therefore numEnd is set to 24.
    if(numEnd == 0){
        numEnd = 24;
    }
    // Count up from numStart to numEnd.
    for(var num = numStart; num < numEnd + 1; num++){
        if(num.toString().length == 1){// if the length of number is 1 then append 0 to start of number
            arr.push("0" + num.toString());
        }else{
            // if a 2 digit number append straight to output array.
            if(num == 24){// Convert 24 into 00
                arr.push("00");
            }else{
                arr.push(num.toString());
            } 
        }
    }
    return arr;
}
// Function ensures that time2 is not greater than time1
function timeCheck(time1,time2){
    if(parseInt(time2) == 0){
        time2 = 24;
    }
    if(parseInt(time1) >= parseInt(time2)){
        return false;//Invalid time
    }else{
        return true;//Valid time
    }
}
var xmlDocs = [];
var finishedFlag = false;
// Loads XML data from XML document to be used to produce line graph.
function loadXMLDocLine() {
    var selectedStations = [];
    // Next lines obtain user input data and store in a given variable.
    var selectStation1 = document.getElementById('station1');
    selectedStations.push(selectStation1.options[selectStation1.selectedIndex].value);

    var selectStation2 = document.getElementById('station2');
    selectedStations.push(selectStation2.options[selectStation2.selectedIndex].value);

    var selectStation3 = document.getElementById('station3');
    selectedStations.push(selectStation3.options[selectStation3.selectedIndex].value);

    var selectStation4 = document.getElementById('station4');
    selectedStations.push(selectStation4.options[selectStation4.selectedIndex].value);

    var selectStation5 = document.getElementById('station5');
    selectedStations.push(selectStation5.options[selectStation5.selectedIndex].value);

    var selectStation6 = document.getElementById('station6');
    selectedStations.push(selectStation6.options[selectStation6.selectedIndex].value);


    var selectYear = document.getElementById('year2');
    var valueYear = selectYear.options[selectYear.selectedIndex].value;

    var selectMonth = document.getElementById('month');
    var valueMonth = selectMonth.options[selectMonth.selectedIndex].value;

    var selectDay = document.getElementById('day');
    var valueDay = selectDay.options[selectDay.selectedIndex].value;

    var selectTimeLine1 = document.getElementById('timeLine1');
    var timeLine1 = selectTimeLine1.options[selectTimeLine1.selectedIndex].value;

    var selectTimeLine2 = document.getElementById('timeLine2');
    var timeLine2 = selectTimeLine2.options[selectTimeLine2.selectedIndex].value;

    var selectPollutants  = document.getElementById('pollutant');
    var pollutant = selectPollutants.options[selectPollutants.selectedIndex].value;

    const promises = [];// Stores promises.

    // Checks user input and ensures timeLine2 is not greater than timeLine1.
    var checkPassed = timeCheck(timeLine1,timeLine2);

    if(checkPassed == true){// If the time check is passed then:
        // For each of the selected stations get XML document:
        for(var i = 0; i < selectedStations.length; i++){ 
            let ajaxPromise = new Promise(function(myResolve, myReject) {// Create new promise
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    myResolve(this.responseXML);
                }
                xhttp.onerror = function() {
                    myReject("error");
                }
                xhttp.open("GET","/" + selectedStations[i]);
                xhttp.send();
            });
            promises.push(ajaxPromise);
        }
        Promise.all(promises).then((xmlDocs) => {// After all promises are complete:
            start = parseInt(timeLine1);
            end = parseInt(timeLine2);
            times = countUpTime(start,end);
            var storage = [{},{},{},{},{},{}];

            //Populate storage with null values
            for(var k = 0; k < storage.length; k++){
                for(var h = 0; h< times.length; h++){
                    storage[k][times[h]] = null;
                }
            }

            for(var i = 0; i < xmlDocs.length; i++){// For each XML Document.
                const recElements = xmlDocs[i].getElementsByTagName("rec");// Gets rec elements from XML document.
                for(var x = 0; x < recElements.length; x++){// For all rec elements:
                    ts = recElements[x].getAttribute('ts');// Gets unixtime stamp.
                    dateTime = getDate(ts); // converts unixtime stamp back into readable date and time.
                    // If recs date matches that of the users inputed date then.
                    if(dateTime[2] == valueYear && dateTime[1] == valueMonth && dateTime[0] == valueDay){
                        for(var z = 0; z < times.length; z++){// For each of the chosen times.
                            // If the time of the rec element is inbetween the times selected by the user then:
                            if(dateTime[3].toString().trim() == times[z].toString().trim()){
                                //Add the data to the storage array depending on the selected polutant by user.
                                if(pollutant.trim() == "nox"){
                                    storage[i][dateTime[3].toString().trim()] = recElements[x].getAttribute('nox');
                                }
                                else if(pollutant.trim() == "no"){
                                    storage[i][dateTime[3].toString().trim()] = recElements[x].getAttribute('no');
                                }
                                else if(pollutant.trim() == "no2"){
                                    storage[i][dateTime[3].toString().trim()] = recElements[x].getAttribute('no2');
                                }
                            }   
                        }                 
                    }
                }
            }
            //Display line graph.
            displayLine(storage,times, selectedStations,pollutant, valueDay,valueMonth,valueYear);
        });
    }else{
        alert("Invalid Times");
    }
} 