<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Heatmaps</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script type="text/javascript" src="maps.js"></script>
    <link rel="stylesheet" href="maps.css" />
    <meta charset="utf-8">

    <script type="text/javascript" src="init.js"></script>
    <script type="text/javascript">
        window.onload = init;
    </script>

  </head>  

  <body>

  <div class="Options">
    <select name="year" id="year" class="button">
    <option value="" selected="selected">Select Year</option>
    <option value="2010" selected="selected">2010</option>
    <option value="2011" selected="selected">2011</option>
    <option value="2012" selected="selected">2012</option>
    <option value="2013" selected="selected">2013</option>
    <option value="2014" selected="selected">2014</option>
    <option value="2015" selected="selected">2015</option>
    <option value="2016" selected="selected">2016</option>
    <option value="2017" selected="selected">2017</option>
    <option value="2018" selected="selected">2018</option>
    <option value="2019" selected="selected">2019</option>
</select>
<select name="month" id="month" class="button">
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
<select name="day" id="day" class="button">
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
<select name="pollutant" id="pollutant" class="button">
    <option value="" selected="selected">Select Pollutant</option>
    <option value="nox" selected="selected">nox</option>
    <option value="no" selected="selected">no</option>
    <option value="no2" selected="selected">no2</option>
</select>
<select name="time" id="time" class="button">
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

    <button onclick="initMap()" class="button">Generate Map(Heat Map Markers)</button>
    
    <button onclick="initMapColourEncodings()" class="button">Generate Map(Colour Encodings)</button>
    </div>

    <div class="MainMapDiv">
    <div id="map"></div>
    <div class="ColourTable"><table id="colourTable"></table></div>
    </div>

    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy3DhKi_LhOqHmhS-HEbtw6nO63vt5HDc&libraries=visualization&callback=emptyMap"></script>
  </body>
</html>