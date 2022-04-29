// Function to make scatter chart options visable
function visibleScatter(){
    var scatterOptions = document.getElementById('scatterMain');
    scatterOptions.hidden = false;

    var lineOptions = document.getElementById('lineMain');
    lineOptions.hidden = true;
}
// Function to make line chart options visable
function visibleLine(){
    var scatterOptions = document.getElementById('scatterMain');
    scatterOptions.hidden = true;

    var lineOptions = document.getElementById('lineMain');
    lineOptions.hidden = false;
}