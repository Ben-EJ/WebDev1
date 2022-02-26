<!DOCTYPE html>
<h1>Generate XML</h1>
<html>
    <head>

    </head>
<body>
<?php
$csvToPull = array(
    fopen("csvFiles/data-188.csv", "r"), 
    fopen("csvFiles/data-203.csv", "r"),
    fopen("csvFiles/data-206.csv", "r"),
    fopen("csvFiles/data-209.csv","r"),
    fopen("csvFiles/data-213.csv", "r"),
    fopen("csvFiles/data-215.csv", "r"),
    fopen("csvFiles/data-228.csv","r"),
    fopen("csvFiles/data-270.csv","r"),
    fopen("csvFiles/data-271.csv","r"),
    fopen("csvFiles/data-375.csv","r"),
    fopen("csvFiles/data-395.csv","r"),
    fopen("csvFiles/data-452.csv","r"),
    fopen("csvFiles/data-447.csv","r"),
    fopen("csvFiles/data-459.csv","r"),
    fopen("csvFiles/data-463.csv","r"),
    fopen("csvFiles/data-481.csv","r"),
    fopen("csvFiles/data-500.csv","r"),
    fopen("csvFiles/data-501.csv","r")
);
$xmlToCreate = array(
    fopen("xmlFiles/data-188.xml", "a"), 
    fopen("xmlFiles/data-203.xml", "a"),
    fopen("xmlFiles/data-206.xml", "a"),
    fopen("xmlFiles/data-209.xml","a"),
    fopen("xmlFiles/data-213.xml", "a"),
    fopen("xmlFiles/data-215.xml", "a"),
    fopen("xmlFiles/data-228.xml","a"),
    fopen("xmlFiles/data-270.xml","a"),
    fopen("xmlFiles/data-271.xml","a"),
    fopen("xmlFiles/data-375.xml","a"),
    fopen("xmlFiles/data-395.xml","a"),
    fopen("xmlFiles/data-452.xml","a"),
    fopen("xmlFiles/data-447.xml","a"),
    fopen("xmlFiles/data-459.xml","a"),
    fopen("xmlFiles/data-463.xml","a"),
    fopen("xmlFiles/data-481.xml","a"),
    fopen("xmlFiles/data-500.xml","a"),
    fopen("xmlFiles/data-501.xml","a")
);

function xmlCreate($xmlToCreate){
    $firstLine = "<?xml version='1.0' encoding='UTF-8' ?>". PHP_EOL;
    foreach ($xmlToCreate as &$xmlFiles){
        fwrite($xmlFiles, $firstLine);
    }
}

function createXMLRecordd($array){
    unset($array[0]);
    unset($array[14]);
    unset($array[15]);
    unset($array[16]);
    $array = array_values($array);

    $fieldArray = array(" ts='"," nox='"," no2='"," no='"," pm10='"," nvpm10='"," vpm10='",
    " nvpm2.5='"," pm2.5='", " vpm2.5='"," co='"," o3='"," so2='");
    
    $finalString = "<rec";
    
    for($i = 0; $i < count($array); $i++){
        if($array[$i] != ";"){
            $finalString = $finalString." ".$fieldArray[$i].$array[$i]."' ";
        }
    }
    $finalString = $finalString."/>";
    return $finalString;
}
function test(){
    $array = array("188","1084492800","73.0","42.0","20.0","14.0",";",";",";",";",";","0.2","38.0","3.0","AURN Bristol Centre","51.4572041156","-2.58564914143");
    $xml = createXMLRecordd($array);
    $testFile = fopen("test.xml", "a");
    fWrite($testFile, $xml);
}
//ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2
function xmlWrite($xmlToCreate, $csvToPull){
    for($i = 0; $i < count($xmlToCreate); $i++){
       $flagSecondLine = true;
       $array = array();
       $count = 0;
       while ($data = fgets($csvToPull[$i])){
            $array = explode(",", $data);
            if($flagSecondLine && $count == 1){
                $secondLine = "<station id='".$array[0]."' "."name='".$array[14]."' "."geocode='".$array[15].",".$array[16]."'>".PHP_EOL;
                fWrite($xmlToCreate[$i], $secondLine);
                $flagSecondLine = false;
            }elseif($count > 1){//Code to add records goes here
                $string = createXMLRecordd($array);
                fWrite($xmlToCreate[$i], $string. PHP_EOL);
            }
            $count++;
        }
        fWrite($xmlToCreate[$i], "</station>". PHP_EOL);
    }
}
xmlCreate($xmlToCreate);
xmlWrite($xmlToCreate, $csvToPull);

?>
</body>
</html>
