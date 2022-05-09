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
//Add in try-catch blocks in apropreate places, have own error handler.
</script>

<button onclick="home()">Home</button>

<?php

@date_default_timezone_set("GMT");

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
ini_set('auto_detect_line_endings', TRUE);

$csvToCreate = array(
    "188" => fopen("data-188.csv","w"), 
    "203" => fopen("data-203.csv","w"),
    "206" => fopen("data-206.csv","w"),
    "209" => fopen("data-209.csv","w"),
    "213" => fopen("data-213.csv","w"),
    "215" => fopen("data-215.csv","w"),
    "228" => fopen("data-228.csv","w"),
    "270" => fopen("data-270.csv","w"),
    "271" => fopen("data-271.csv","w"),
    "375" => fopen("data-375.csv","w"),
    "395" => fopen("data-395.csv","w"),
    "452" => fopen("data-452.csv","w"),
    "447" => fopen("data-447.csv","w"),
    "459" => fopen("data-459.csv","w"),
    "463" => fopen("data-463.csv","w"),
    "481" => fopen("data-481.csv","w"),
    "500" => fopen("data-500.csv","w"),
    "501" => fopen("data-501.csv","w")
);

$fileHeader = "siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long" . PHP_EOL;

// This function splits a given line in a CSV file into an array containing each feild in row.
function multiSpliter($string){
    $array = array();
    $chars = str_split($string);// Split string into array of chars.
    $entry = "";
    $count = count($chars);
    for($i = 0; $i < $count + 1; $i++){// loop through all chars in array.
        if($count == $i && $entry != ""){ // Appends final entry.
            array_push($array, $entry);
        } 
        else if($chars[$i] == ","){ // Handles commas.
            array_push($array, $entry);
            $entry = "";
        } 
        else if($chars[$i] == ";"){
            if($entry != ""){// If entry is not empty then entry must be complete.
                array_push($array, $entry);
            }else{ // If entry is empty then the field must be blank.
                array_push($array,";");
            }
            $entry = "";
        }  
        else{
            $entry = $entry . $chars[$i]; // Constructs entry char by char.
        }
    }
    return $array;
}

// Converts date and time into a Unix Time stamp
function convertToTimeStamp($dateTime){
    $dataSplit = array();
    $dataSplitFurther = array();
    $dataSplit =  explode("T", $dateTime);
    $dataSplitFurther = explode("+", $dataSplit[1]);
    return strtotime($dataSplit[0]." ".$dataSplitFurther[0]);
 }
// Handles sorting the CSV data from main file into subsequent smaller CSV files.
function sortCsv($csvToCreate, $fileHeader){

    foreach($csvToCreate as &$initalCSV){// appends header for each new CSV file.
        fwrite($initalCSV, $fileHeader);
    }
    $file = fopen("air-quality-data-2004-2019.csv","r");
    $flagSkipedFirst = false;
    while ($data = fgets($file)) {// For each line in air-quality-data-2004-2019 CSV file.
        if($flagSkipedFirst){// Skips first row as it contains the file header.
            $dataSplitArray = array();
            $dataSplitArray = multiSpliter($data);// Splits row from CSV into an array
            $date = convertToTimeStamp($dataSplitArray[0]); //Converts date and time from air-quality-data-2004-2019 csv file to Unix timestamp
            
            //Next section of code reformats the CSV data row into new CSV row format and writes to file.
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
// Code use to check time taken to complete task.
$st = microtime(true);
sortCsv($csvToCreate,$fileHeader);
echo '<p>It took ';
echo microtime(true) - $st;
?>
</body>
</html>
