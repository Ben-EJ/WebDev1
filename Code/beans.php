<!DOCTYPE html>
<h1>Hello World</h1>
<html>
    <head>

    </head>
<body>
<?php

$csvToCreate = array("data-188", "data-203", "data-206", "data-209","data-213", "data-215", "data-228",
"data-270","data-271","data-375","data-395","data-452","data-447","data-459","data-463","data-481","data-500",
"data-501");

$st = microtime(true);
$file = fopen("air-quality-data-2004-2019.csv","r");
$fileDataArray = array();
while ($data = fgets($file)) {
   array_push($fileDataArray, $data);
}
echo $fileDataArray[0];
echo "<br/>";
echo $fileDataArray[1];
echo "<br/>";
echo $fileDataArray[2];
echo "<br/>";
echo $fileDataArray[3];
echo "<br/>";
echo $fileDataArray[4];
fclose($file);

?>
</body>
</html>
