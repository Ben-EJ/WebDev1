
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

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
google.charts.setOnLoadCallback(drawChart);
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
function displayLine(arrayData) {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

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

    var selectPollutants  = document.getElementById('pollutant');
    var valueTime = selectPollutants.options[selectPollutants.selectedIndex].value;

    const promises = [];

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
        
        for(var i =0; i < xmlDocs.length; i++){
            const recElements = xmlDoc[i].getElementsByTagName("rec");
            for(var x = 0; x < recElements.length; x++){
                
            }
        }
    });
} 
</script>

<!DOCTYPE html>
<html>
    <head>
    </head>
<body>
<h1>Home Page</h1>
<button onclick="extractToCSV()">Extract To CSV</button>
<button onclick="normalizeToXML()">Normalize To XML</button>
<br></br>
<select name="station" id="station">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>

<select name="year" id="year">
    <option value="" selected="selected">Select Year</option>
    <option value="2015" selected="selected">2015</option>
    <option value="2016" selected="selected">2016</option>
    <option value="2017" selected="selected">2017</option>
    <option value="2018" selected="selected">2018</option>
    <option value="2019" selected="selected">2019</option>
</select>

<select name="time" id="time">
    <option value="" selected="selected">Select Time</option>
    <option value="01" selected="selected">01:00</option>
    <option value="02" selected="selected">02:00</option>
    <option value="03" selected="selected">03:00</option>
    <option value="04" selected="selected">04:00</option>
    <option value="05" selected="selected">05:00</option>
    <option value="06" selected="selected">06:00</option>
    <option value="07" selected="selected">07:00</option>
    <option value="08" selected="selected">08:00</option>
    <option value="09" selected="selected">09:00</option>
    <option value="10" selected="selected">10:00</option>
    <option value="11" selected="selected">11:00</option>
    <option value="12" selected="selected">12:00</option>
    <option value="13" selected="selected">13:00</option>
    <option value="14" selected="selected">14:00</option>
    <option value="15" selected="selected">15:00</option>
    <option value="16" selected="selected">16:00</option>
    <option value="17" selected="selected">17:00</option>
    <option value="18" selected="selected">18:00</option>
    <option value="19" selected="selected">19:00</option>
    <option value="20" selected="selected">20:00</option>
    <option value="21" selected="selected">21:00</option>
    <option value="22" selected="selected">22:00</option>
    <option value="23" selected="selected">23:00</option>
    <option value="00" selected="selected">00:00</option>
</select>

<button onclick="loadXMLDocScatter()">Populate Scatter Graph</button>
<br></br>
<select name="station1" id="station1">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>
<select name="station2" id="station2">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>
<select name="station3" id="station3">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>
<select name="station4" id="station4">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>
<select name="station5" id="station5">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>
<select name="station6" id="station6">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>

<select name="station6" id="station6">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-213.xml" selected="selected">data-213</option>
    <option value="data-215.xml" selected="selected">data-215</option>
    <option value="data-228.xml" selected="selected">data-228</option>
    <option value="data-270.xml" selected="selected">data-270</option>
    <option value="data-271.xml" selected="selected">data-271</option>
    <option value="data-375.xml" selected="selected">data-375</option>
    <option value="data-395.xml" selected="selected">data-395</option>
    <option value="data-447.xml" selected="selected">data-447</option>
    <option value="data-452.xml" selected="selected">data-452</option>
    <option value="data-459.xml" selected="selected">data-459</option>
    <option value="data-463.xml" selected="selected">data-463</option>
    <option value="data-481.xml" selected="selected">data-481</option>
    <option value="data-500.xml" selected="selected">data-500</option>
    <option value="data-501.xml" selected="selected">data-501</option>
</select>
<select name="year2" id="year2">
    <option value="" selected="selected">Select Year</option>
    <option value="2015" selected="selected">2015</option>
    <option value="2016" selected="selected">2016</option>
    <option value="2017" selected="selected">2017</option>
    <option value="2018" selected="selected">2018</option>
    <option value="2019" selected="selected">2019</option>
</select>
<select name="month" id="month">
    <option value="" selected="selected">Select Month</option>
    <option value="01" selected="selected">January</option>
    <option value="02" selected="selected">Febuary</option>
    <option value="03" selected="selected">March</option>
    <option value="04" selected="selected">April</option>
    <option value="05" selected="selected">May</option>
    <option value="06" selected="selected">June</option>
    <option value="07" selected="selected">July</option>
    <option value="08" selected="selected">August</option>
    <option value="09" selected="selected">September</option>
    <option value="10" selected="selected">October</option>
    <option value="11" selected="selected">November</option>
    <option value="12" selected="selected">December</option>
</select>
<select name="day" id="day">
    <option value="" selected="selected">Select Day</option>
    <option value="01" selected="selected">1</option>
    <option value="02" selected="selected">2</option>
    <option value="03" selected="selected">3</option>
    <option value="04" selected="selected">4</option>
    <option value="05" selected="selected">5</option>
    <option value="06" selected="selected">6</option>
    <option value="07" selected="selected">7</option>
    <option value="08" selected="selected">8</option>
    <option value="09" selected="selected">9</option>
    <option value="10" selected="selected">10</option>
    <option value="11" selected="selected">11</option>
    <option value="12" selected="selected">12</option>
    <option value="13" selected="selected">13</option>
    <option value="14" selected="selected">14</option>
    <option value="15" selected="selected">15</option>
    <option value="16" selected="selected">16</option>
    <option value="17" selected="selected">17</option>
    <option value="18" selected="selected">18</option>
    <option value="19" selected="selected">19</option>
    <option value="20" selected="selected">20</option>
    <option value="21" selected="selected">21</option>
    <option value="22" selected="selected">22</option>
    <option value="23" selected="selected">23</option>
    <option value="24" selected="selected">24</option>
    <option value="25" selected="selected">25</option>
    <option value="26" selected="selected">26</option>
    <option value="27" selected="selected">27</option>
    <option value="28" selected="selected">28</option>
    <option value="29" selected="selected">29</option>
    <option value="30" selected="selected">30</option>
    <option value="31" selected="selected">31</option>
</select>
<select name="pollutant" id="pollutant">
    <option value="" selected="selected">Select Pollutant</option>
    <option value="nox" selected="selected">nox</option>
    <option value="no" selected="selected">no</option>
    <option value="no2" selected="selected">no2</option>
</select>
<button onclick="loadXMLDocLine()">Populate Line Graph</button>

<div id="chart_div" style="width: 900px; height: 500px;"></div>
<div id="curve_chart" style="width: 900px; height: 500px"></div>

</body>
</html>

