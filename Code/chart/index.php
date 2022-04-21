<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="chart.js"></script>
    </head>
<body>
<h1>Charts</h1>
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
<button onclick="loadXMLDocLine()">Populate Line Graph</button>

<div class="main">
<div id="chart_div" style="width: 900px; height: 500px;"></div>
</div>

</body>
</html>

