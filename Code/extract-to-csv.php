<!DOCTYPE html>
<h1>Web Dev Coursework</h1>
<html>
    <head>

    </head>
<body>
<?php

$st = microtime(true);
$file = fopen("air-quality-data-2004-2019.csv","r");

$csvToCreate = array("data-188.csv", "data-203.csv", "data-206.csv", "data-209.csv","data-213.csv", "data-215.csv", "data-228.csv",
"data-270.csv","data-271.csv","data-375.csv","data-395.csv","data-452.csv","data-447.csv","data-459.csv","data-463.csv","data-481.csv","data-500.csv",
"data-501.csv");

$count = 0;
$fileDataArray = array();

while ($data = fgets($file)) {
    $count = $count + 1;
   array_push($fileDataArray, explode(",", $data));
   if($count == 100){
    $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

    fwrite($myfile, $txt);
    
    fclose($myfile);
   }
}

fclose($file);

?>
</body>
</html>
