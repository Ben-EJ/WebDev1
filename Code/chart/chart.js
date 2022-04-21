
function extractToCSV() 
{ 
    location.href = '/WebDev1/Code/extract-to-csv.php'; 
}
function normalizeToXML() 
{ 
    location.href = '/WebDev1/Code/normalize-to-xml.php'; 
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

google.charts.load('current', {'packages':['corechart']});
//google.charts.setOnLoadCallback(drawChart);

function average(theArray){
    var lenArray = theArray.length;
    var runningTotal = 0;
    for (let i = 0; i < lenArray; i++){
        runningTotal = runningTotal + parseInt(theArray[i]);
    }
    return runningTotal / lenArray;
}
function displayScatter(monthsArray){
    parser = new DOMParser();
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
    var options = {
        title: 'A scatter chart to show a years worth of data (averaged by month) from a specific station for Carbon Monoxide.',
        hAxis: {title: 'Month', minValue: 0, maxValue: 12},
        vAxis: {title: 'NO Levels', minValue: 0, maxValue: Math.max(monthsArray)},
        legend: 'none'
    };
    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

function loadXMLDocScatter() {
    var selectStation = document.getElementById('station');
    var valueStation = selectStation.options[selectStation.selectedIndex].value;

    var selectYear = document.getElementById('year');
    var valueYear = selectYear.options[selectYear.selectedIndex].value;

    var selectTime = document.getElementById('time');
    var valueTime = selectTime.options[selectTime.selectedIndex].value;
    
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
        if (this.readyState == 4 && this.status == 200) {
            const xmlDoc = this.responseXML;
            const x = xmlDoc.getElementsByTagName("rec");
            let txt = "";
            for (let i = 0; i < x.length; i++) {
                ts = x[i].getAttribute('ts');
                dateTime = getDate(ts);
                no = x[i].getAttribute('no');
                if(dateTime[2].trim() == valueYear && dateTime[3].trim() == valueTime){
                    monthArray[dateTime[1].toString()].push(no);
                }
            }
            finished = true;
        };
        if(finished == true){
            const monthAverages = []
            for(const [key, value] of Object.entries(monthArray)){
                if(value.length != 0){
                    monthAverages.push(average(value));
                }else{
                    monthAverages.push(0);
                } 
            }
            displayScatter(monthAverages)
        }
    }
    xhttp.open("GET", "/WebDev1/Code/xmlFiles/" + valueStation);
    xhttp.send();
} 

function displayLine(storage, times, stations, pollutant, day,month,year) {   
    var stationsFormated = []
    var stationListNotEmpty = []
    var stationsDataNotEmpty = []
    var stationsEmpty = []

    for(var i = 0; i < stations.length; i++){
        split1 = stations[i].split("-");
        split2 = split1[1].split(".");
        stationsFormated.push(split2[0]);
    }

    for (var k = 0; k < storage.length; k++){
        var empty = false;
        for (const [key, value] of Object.entries(storage[k])) {
            if(value == null){
                empty = true;
            }else{
                empty = false;
            }
        } 
        if(empty == false){
            stationsDataNotEmpty.push(storage[k]);
            stationListNotEmpty.push(stationsFormated[k]);
        }else{
            stationsEmpty.push(stationsFormated[k]);
        }
    }
    
    stationListNotEmpty.unshift(pollutant);
    var dataToDisplay = [stationListNotEmpty]
    
    for(var z = 0; z < times.length; z++){
        var data = [times[z]];
        for(var x = 0; x < stationsDataNotEmpty.length; x++){
            for (const [key, value] of Object.entries(stationsDataNotEmpty[x])) {
                if(key.toString().trim() == times[z]){
                    data.push(parseInt(value));
                }
                
            }
        }
        dataToDisplay.push(data);
    }
    
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
}
function countUpTime(numStart, numEnd){
    var arr = [];
    if(numEnd == 0){
        numEnd = 24;
    }
    for(var num = numStart; num < numEnd + 1; num++){
        if(num.toString().length == 1){
            arr.push("0" + num.toString());
        }else{
            if(num == 24){
                arr.push("00");
            }else{
                arr.push(num.toString());
            }
            
        }
    }
    return arr;
}
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
function loadXMLDocLine() {
    var selectedStations = [];

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

    const promises = [];
    
    var checkPassed = timeCheck(timeLine1,timeLine2);
    if(checkPassed == true){
        for(var i = 0; i < selectedStations.length; i++){
            let ajaxPromise = new Promise(function(myResolve, myReject) {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    myResolve(this.responseXML);
                }
                xhttp.onerror = function() {
                    myReject("error");
                }
                xhttp.open("GET", "/WebDev1/Code/xmlFiles/" + selectedStations[i]);
                xhttp.send();
            });
            promises.push(ajaxPromise);
        }
        Promise.all(promises).then((xmlDocs) => {
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

            for(var i = 0; i < xmlDocs.length; i++){
                
                const recElements = xmlDocs[i].getElementsByTagName("rec");
                for(var x = 0; x < recElements.length; x++){
                    ts = recElements[x].getAttribute('ts');
                    dateTime = getDate(ts);
                    if(dateTime[2] == valueYear && dateTime[1] == valueMonth && dateTime[0] == valueDay){
                        for(var z = 0; z < times.length; z++){
                            if(dateTime[3].toString().trim() == times[z].toString().trim()){
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
            displayLine(storage,times, selectedStations,pollutant, valueDay,valueMonth,valueYear);
        });
    }else{
        alert("Invalid Times");
    }
} 