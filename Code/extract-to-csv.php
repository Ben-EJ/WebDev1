<!DOCTYPE html>

<html>
    <head>
    </head>
<body>
<h1>Generated CSV</h1>

<script>
function home() 
{ 
    location.href = 'chart/index.php'; 
}
</script>

<button onclick="home()">Home</button>

<?php

@date_default_timezone_set("GMT");

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
ini_set('auto_detect_line_endings', TRUE);

$csvToCreate = array(
    "188" => fopen("csvFiles/data-188.csv","w"), 
    "203" => fopen("csvFiles/data-203.csv","w"),
    "206" => fopen("csvFiles/data-206.csv","w"),
    "209" => fopen("csvFiles/data-209.csv","w"),
    "213" => fopen("csvFiles/data-213.csv","w"),
    "215" => fopen("csvFiles/data-215.csv","w"),
    "228" => fopen("csvFiles/data-228.csv","w"),
    "270" => fopen("csvFiles/data-270.csv","w"),
    "271" => fopen("csvFiles/data-271.csv","w"),
    "375" => fopen("csvFiles/data-375.csv","w"),
    "395" => fopen("csvFiles/data-395.csv","w"),
    "452" => fopen("csvFiles/data-452.csv","w"),
    "447" => fopen("csvFiles/data-447.csv","w"),
    "459" => fopen("csvFiles/data-459.csv","w"),
    "463" => fopen("csvFiles/data-463.csv","w"),
    "481" => fopen("csvFiles/data-481.csv","w"),
    "500" => fopen("csvFiles/data-500.csv","w"),
    "501" => fopen("csvFiles/data-501.csv","w")
);

$fileHeader = "siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long" . PHP_EOL;

function multiSpliter($string){
    $array = array();
    $chars = str_split($string);
    $entry = "";
    $count = count($chars);
    for($i = 0; $i < $count + 1; $i++){
        if($count == $i && $entry != ""){
            array_push($array, $entry);
        } 
        else if($chars[$i] == ","){
            array_push($array, $entry);
            $entry = "";
        } 
        else if($chars[$i] == ";"){
            if($entry != ""){
                array_push($array, $entry);
            }else{
                array_push($array,";");
            }
            $entry = "";
        }  
        else{
            $entry = $entry . $chars[$i];
        }
    }
    return $array;
}
function convertToTimeStamp($dateTime){//2004-05-14T07:00:00+00:00
    $dataSplit = array();
    $dataSplitFurther = array();
    $dataSplit =  explode("T", $dateTime);
    $dataSplitFurther = explode("+", $dataSplit[1]);
    return strtotime($dataSplit[0]." ".$dataSplitFurther[0]);
 }
//4 element is 
function sortCsv($csvToCreate, $fileHeader){

    foreach($csvToCreate as &$initalCSV){
        fwrite($initalCSV, $fileHeader);
    }
    $file = fopen("air-quality-data-2004-2019.csv","r");
    $flagSkipedFirst = false;
    while ($data = fgets($file)) {
        if($flagSkipedFirst){
            $dataSplitArray = array();
            $dataSplitArray = multiSpliter($data);
            $date = convertToTimeStamp($dataSplitArray[0]);
    
            if($dataSplitArray[11] != ";" || $dataSplitArray[1] != ";"){
                $reformated = 
                $dataSplitArray[4]  . "," .  $date  . ","
              . $dataSplitArray[1]  . "," .  $dataSplitArray[2]  . ","
              . $dataSplitArray[3]  . "," .  $dataSplitArray[5]  . ","
              . $dataSplitArray[6]  . "," .  $dataSplitArray[7]  . ","
              . $dataSplitArray[8]  . "," .  $dataSplitArray[9]  . ","
              . $dataSplitArray[10] . "," .  $dataSplitArray[11] . ","
              . $dataSplitArray[12] . "," .  $dataSplitArray[13] . ","
              . $dataSplitArray[17] . "," .  $dataSplitArray[18] . ","
              . $dataSplitArray[19] . PHP_EOL;
             fwrite($csvToCreate[$dataSplitArray[4]], $reformated);
            }
               
    }
        $flagSkipedFirst = true;
    }
}
$st = microtime(true);
sortCsv($csvToCreate,$fileHeader);
echo '<p>It took ';
echo microtime(true) - $st;
?>
</body>
</html>
