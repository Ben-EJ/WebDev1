<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="chart.js"></script>
    <script type="text/javascript" src="divHandle.js"></script>
    <link rel="stylesheet" href="chart.css" />

    <script type="text/javascript" src="init.js"></script>
    <script type="text/javascript">
        window.onload=function(){
            init();
            initCharts();
        }
    </script>

    </head>
<body>
<img id="loadingBodyImg" src="loadingCharts.jpg" alt="Loading" style="width: 900px; height: 500px;">
<div id="wholeBody">

<h1>Charts</h1>
<button onclick="extractToCSV()">Extract To CSV</button>
<button onclick="normalizeToXML()">Normalize To XML</button>
<br></br>

<div class="main">
<div class="selectChartType">
<input type="radio" id="scatter" name="selectChart" value="scatter" onclick="visibleScatter()">
<label for="scatter">Scatter Chart</label><br>
<input type="radio" id="line" name="selectChart" value="line" onclick="visibleLine()">
<label for="line">Line Chart</label><br> 
</div>

<div id="chart_div" style="width: 900px; height: 500px;">
</div>
<img id="NoDataImg" src="NoData.jpg" alt="No Data" style="width: 900px; height: 500px;">
<div class="options">
    <div id="scatterMain">
        <select name="station" id="station">
            <option value="" selected="selected">Select Station</option>
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

        <br></br>

        <button onclick="loadXMLDocScatter()">Generate Chart</button>
    </div>

    <div id="lineMain">
        <div class="stationsChart2">
            <select name="station1" id="station1">
                <option value="" selected="selected">Select Station</option>
            </select>
            <select name="station2" id="station2">
                <option value="" selected="selected">Select Station</option>
            </select>
            <select name="station3" id="station3">
                <option value="" selected="selected">Select Station</option>
            </select>
            <select name="station4" id="station4">
                <option value="" selected="selected">Select Station</option>
            </select>
            <select name="station5" id="station5">
                <option value="" selected="selected">Select Station</option>
            </select>
            <select name="station6" id="station6">
                <option value="" selected="selected">Select Station</option>
            </select>
        </div>

        <div class="dateTimeChart2">
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
            <select name="timeLine1" id="timeLine1">
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
            </select>
            <select name="timeLine2" id="timeLine2">
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
            <select name="pollutant" id="pollutant">
                <option value="" selected="selected">Select Pollutant</option>
                <option value="nox" selected="selected">nox</option>
                <option value="no" selected="selected">no</option>
                <option value="no2" selected="selected">no2</option>
            </select>
        </div>

        <br></br>
        <button onclick="loadXMLDocLine()">Generate Chart</button>

        </div>
    </div>
</div>
</div>
    </div>
</body>
</html>

