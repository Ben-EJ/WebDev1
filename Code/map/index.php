<!DOCTYPE html>
<html>
  <head>
    <title>Heatmaps</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  </head>
    <script>
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
        window.initMap = initMap;
        
    </script>
  
  <body>
    <style>
        html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        }
        .MainMapDiv{
            top:25%;
            left:25%;
            height:100%;
            width:100%;
            position: absolute;
        }
        #map {
            height:50%;
            width:50%;
        }
        table {
            border: 1px solid black;
        }
        td {
            width: 10px;
            text-align: center;
            padding: 5px;
        }
        .ColourTable{
            top:10%;
            left:50%;
            position: absolute;
        }
        .colorCell{
            padding: 15px;
            height:20%;
            width:40%;
        }
    </style>
    <div class="MainMapDiv">
    <select name="year" id="year">
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
    </select>
    <button onclick="initMap()">Generate Map</button>

    
    <div id="map"></div>
    <div class="ColourTable"><table id="colourTable"></table></div>
    </div>

    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy3DhKi_LhOqHmhS-HEbtw6nO63vt5HDc&v=weekly"
      defer
    ></script>
  </body>
</html>