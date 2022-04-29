// Converts unixTime Stamp into readable date.
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
// This function checks to see which of the XML files have useable data between 2015 and 2019,
//and populates the selection boxes in the HTML document with those stations.
function init() {
    const stations = ["data-188.xml","data-203.xml","data-206.xml","data-209.xml","data-213.xml","data-215.xml", "data-228.xml","data-270.xml",
    "data-271.xml", "data-375.xml","data-395.xml","data-447.xml","data-452.xml","data-459.xml","data-463.xml","data-481.xml","data-500.xml","data-501.xml"];
    const promises=[];
    // Next few lines gets all station XML files.
    for(var i = 0; i < stations.length; i++){
      let ajaxPromise = new Promise(function(myResolve, myReject) {// Create new promise
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
              myResolve(this.responseXML);
          }
          xhttp.onerror = function() {
              myReject("error");
          }
          xhttp.open("GET", "/WebDev1/Code/xmlFiles/" + stations[i]);
          xhttp.send();
      });
      promises.push(ajaxPromise);
  }
  Promise.all(promises).then((xmlDocs) => {// After all promises complete therefore all files have been obtained:
      const validYears = ["2015","2016","2017","2018", "2019"];
      const validStations = [];
      for(var i = 0; i < xmlDocs.length; i++){// For each XML document
          const recElements = xmlDocs[i].getElementsByTagName("rec");// get rec elements for that document and store in array.
            for(var x = 0; x < recElements.length; x++){// For each rec element.
                ts = recElements[x].getAttribute('ts');// Get time stamp
                dateTime = getDate(ts);// convert time stamp to readable date and time.
                
                var found = false;
                // Check to see if rec element year is within validYears and if it add xml document file name to valid stations array. 
                for(let z = 0; z < validYears.length; z++){
                    if(dateTime[2].trim() == validYears[z].trim()){
                        validStations.push(stations[i]);
                        var found = true;
                        break;// if useful data was found in file break out of loop.
                    }
                }
                if(found == true){// if useful data was found in file break out of loop.
                    break;
                }
            }
        }
    
    // Removes loading image from page.
    var loadingBodyImg = document.getElementById('loadingBodyImg');
    loadingBodyImg.style.display = "none";

    // Shows main body of page.
    var wholeBody = document.getElementById('wholeBody');
    wholeBody.style.display = "block";
    
    // Next section of code populates all selectionboxes on html page with stations in the validStations array.
    stationSelection = [document.getElementById('station'),document.getElementById('station1'),document.getElementById('station2'),
    document.getElementById('station3'),document.getElementById('station4'),document.getElementById('station5'),
    document.getElementById('station6')];
    
    for(let b = 0; b < stationSelection.length; b++){
        for(let k = 0; k < validStations.length; k++){
            var option = document.createElement("option");
            option.text = validStations[k];
            option.value = validStations[k];
            stationSelection[b].add(option);
        }
    }
  });
}

//Function ensures the correct UI options are showing depending on which chart type is selected,
//furthermore function hides noDataImg and the body of the webpage.
function initCharts() {

    document.getElementById('NoDataImg').hidden = true;

    var wholeBody = document.getElementById('wholeBody');
    wholeBody.style.display = "none";

    if(document.getElementById('scatter').checked == false){
        var scatterOptions = document.getElementById('scatterMain');
        scatterOptions.hidden = true;
    }else{
        var scatterOptions = document.getElementById('scatterMain');
        scatterOptions.hidden = false;
    }

    if(document.getElementById('line').checked == false){
        var lineOptions = document.getElementById('lineMain');
        lineOptions.hidden = true;
    }else{
        var lineOptions = document.getElementById('lineMain');
        lineOptions.hidden = false;
    }
}