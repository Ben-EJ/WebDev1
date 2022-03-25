
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
    var date = new Date(1084518000 * 1000);
    var humanReadableDate = date.toLocaleString(); 
    const dateAndTime = humanReadableDate.split(",");
    const splitDate = dateAndTime[0].split("/");
    const splitTime = dateAndTime[1].split(":");
                           //Day         Month        Year,        hour,         minute,      Second
    const dateSplitArray = [splitDate[1],splitDate[0],splitDate[2],splitTime[0], splitTime[1],splitTime[2]];
    document.write(dateSplitArray[3]);
    return dateSplitArray;
}

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function loadXMLDoc() {
    var selectStation = document.getElementById('station');
    var valueStation = selectStation.options[selectStation.selectedIndex].value;

    var selectYear = document.getElementById('year');
    var valueYear = selectYear.options[selectYear.selectedIndex].value;

    var selectTime = document.getElementById('time');
    var valueTime = selectTime.options[selectTime.selectedIndex].value;
    
    if(valueStation.length == 0){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
        const xmlDoc = this.responseXML;
        const x = xmlDoc.getElementsByTagName("rec");
        let txt = "";
        for (let i = 0; i < x.length; i++) {
            ts = txt + x[i].getAttribute('ts');
            ts = txt + x[i].getAttribute('no');
        }
        document.getElementById("demo").innerHTML = txt;
        }
        xhttp.open("GET", "/WebDev1/Code/xmlFiles/" + valueStation);
        xhttp.send();
    }

    parser = new DOMParser();
    
    var data = google.visualization.arrayToDataTable([
        ['Month', 'NO Levels'],
        [0,0]
    ]);

    var options = {
        title: 'A scatter chart to show a years worth of data (averaged by month) from a specific station for Carbon Monoxide.',
        hAxis: {title: 'Month', minValue: 0, maxValue: 12},
        vAxis: {title: 'NO Levels', minValue: 0, maxValue: 100},
        legend: 'none'
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

    chart.draw(data, options);
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

<select name="station" id="station">
    <option value="" selected="selected">Select Station</option>
    <option value="data-188.xml" selected="selected">data-188</option>
    <option value="data-203.xml" selected="selected">data-203</option>
    <option value="data-206.xml" selected="selected">data-206</option>
    <option value="data-209.xml" selected="selected">data-209</option>
    <option value="data-113.xml" selected="selected">data-113</option>
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
    <option value="00:00" selected="selected">01:00</option>
    <option value="00:00" selected="selected">02:00</option>
    <option value="00:00" selected="selected">03:00</option>
    <option value="00:00" selected="selected">04:00</option>
    <option value="00:00" selected="selected">05:00</option>
    <option value="00:00" selected="selected">06:00</option>
    <option value="00:00" selected="selected">07:00</option>
    <option value="00:00" selected="selected">08:00</option>
    <option value="00:00" selected="selected">09:00</option>
    <option value="00:00" selected="selected">10:00</option>
    <option value="00:00" selected="selected">11:00</option>
    <option value="00:00" selected="selected">12:00</option>
    <option value="00:00" selected="selected">13:00</option>
    <option value="00:00" selected="selected">14:00</option>
    <option value="00:00" selected="selected">15:00</option>
    <option value="00:00" selected="selected">16:00</option>
    <option value="00:00" selected="selected">17:00</option>
    <option value="00:00" selected="selected">18:00</option>
    <option value="00:00" selected="selected">19:00</option>
    <option value="00:00" selected="selected">20:00</option>
    <option value="00:00" selected="selected">21:00</option>
    <option value="00:00" selected="selected">22:00</option>
    <option value="00:00" selected="selected">23:00</option>
    <option value="00:00" selected="selected">00:00</option>
</select>

<button onclick="loadXMLDoc()">Populate Scatter Graph</button>
<p id="demo"></p>

<div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>

