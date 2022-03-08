<!DOCTYPE html>

<html>
    <head>
    </head>
<body>
<h1>Generate CSV</h1>
<?php

@date_default_timezone_set("GMT");

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
ini_set('auto_detect_line_endings', TRUE);

$csvToCreate = array(
    "188" => fopen("csvFiles/data-188.csv", "a"), 
    "203" => fopen("csvFiles/data-203.csv", "a"),
    "206" => fopen("csvFiles/data-206.csv", "a"),
    "209" => fopen("csvFiles/data-209.csv","a"),
    "213" => fopen("csvFiles/data-213.csv", "a"),
    "215" => fopen("csvFiles/data-215.csv", "a"),
    "228" => fopen("csvFiles/data-228.csv","a"),
    "270" => fopen("csvFiles/data-270.csv","a"),
    "271" => fopen("csvFiles/data-271.csv","a"),
    "375" => fopen("csvFiles/data-375.csv","a"),
    "395" => fopen("csvFiles/data-395.csv","a"),
    "452" => fopen("csvFiles/data-452.csv","a"),
    "447" => fopen("csvFiles/data-447.csv","a"),
    "459" => fopen("csvFiles/data-459.csv","a"),
    "463" => fopen("csvFiles/data-463.csv","a"),
    "481" => fopen("csvFiles/data-481.csv","a"),
    "500" => fopen("csvFiles/data-500.csv","a"),
    "501" => fopen("csvFiles/data-501.csv","a")
);

$fileHeader = "siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long" . PHP_EOL;

function multiSpliter($string){
    $array = array();
    $chars = str_split($string);
    $entry = "";
    for($i = 0; $i < count($chars) + 1; $i++){
        if(count($chars) == $i && $entry != ""){
            array_push($array, $entry);
        } 
        elseif($chars[$i] == ","){
            array_push($array, $entry);
            $entry = "";
        } 
        elseif($chars[$i] == ";"){
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
    $date = explode("-",$dataSplit[0]);
    
    if((int) $date[0] >= 2010){
        echo "<br/>";
        echo $date[0];
        return strtotime($dataSplit[0]." ".$dataSplitFurther[1]);
    }else{
        return "none";
    }
    
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
            
            if(strcmp($date, "none") !== 0){
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
        //siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long
           
        }
        $flagSkipedFirst = true;
    }
    foreach($csvToCreate as &$files){
        fclose($files);
    }
    fclose($file);
}

sortCsv($csvToCreate,$fileHeader);




?>
</body>
</html>
