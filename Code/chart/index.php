
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
    const dateSplitArray = [splitDate[1],splitDate[0],splitDate[2],splitTime[0], splitTime[1],splitTime[2]];
    return dateSplitArray;
}
function loadXMLDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("rec").innerHTML = this.responseText;
    }
    };
    xhttp.open("GET", "data-481.xml", true);
    xhttp.send();
}

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
      
function drawChart() {
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

<button onclick="loadXMLDoc()">Test</button>


<div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>

