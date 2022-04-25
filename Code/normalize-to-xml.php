<!DOCTYPE html>
<h1>Generated XML</h1>
<html>
    <head>

    </head>
<body>
    
<script>
function home() 
{ 
    location.href = 'chart/index.php'; 
}
</script>

<button onclick="home()">Home</button>

<?php
$csvToPull = array(
    fopen("csvFiles/data-188.csv","r"), 
    fopen("csvFiles/data-203.csv","r"),
    fopen("csvFiles/data-206.csv","r"),
    fopen("csvFiles/data-209.csv","r"),
    fopen("csvFiles/data-213.csv","r"),
    fopen("csvFiles/data-215.csv","r"),
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
    fopen("xmlFiles/data-188.xml","w"), 
    fopen("xmlFiles/data-203.xml","w"),
    fopen("xmlFiles/data-206.xml","w"),
    fopen("xmlFiles/data-209.xml","w"),
    fopen("xmlFiles/data-213.xml","w"),
    fopen("xmlFiles/data-215.xml","w"),
    fopen("xmlFiles/data-228.xml","w"),
    fopen("xmlFiles/data-270.xml","w"),
    fopen("xmlFiles/data-271.xml","w"),
    fopen("xmlFiles/data-375.xml","w"),
    fopen("xmlFiles/data-395.xml","w"),
    fopen("xmlFiles/data-452.xml","w"),
    fopen("xmlFiles/data-447.xml","w"),
    fopen("xmlFiles/data-459.xml","w"),
    fopen("xmlFiles/data-463.xml","w"),
    fopen("xmlFiles/data-481.xml","w"),
    fopen("xmlFiles/data-500.xml","w"),
    fopen("xmlFiles/data-501.xml","w")
);

function xmlCreate($xmlToCreate){
    $firstLine = "<?xml version='1.0' encoding='UTF-8' ?>". PHP_EOL;
    foreach ($xmlToCreate as &$xmlFiles){
        fwrite($xmlFiles, $firstLine);
    }
}

function createXMLRecord($array){
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
function xmlStringReFormater($string){
    $chars = str_split($string);
    $charsToAvoid = ["&","'"];
    $reconstructedString = "";
    for ($i = 0; $i < count($chars); $i++){
        $containsFlag = true;
        for($z = 0; $z < count($charsToAvoid); $z++){
            if($chars[$i] == $charsToAvoid[$z]){
                $containsFlag = false;
            }
        }
        if($containsFlag){
            $reconstructedString = $reconstructedString . $chars[$i];
        }
    }
    return $reconstructedString;
}
//ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,c
function xmlWrite($xmlToCreate, $csvToPull){
    for($i = 0; $i < count($xmlToCreate); $i++){
       $flagSecondLine = true;
       $array = array();
       $count = 0;
       while ($data = fgets($csvToPull[$i])){
            $array = explode(",", $data);
            if($flagSecondLine && $count == 1){
                //rtrim() used to mitigate a bug is cause by PHP_EOL adding a ghost char after $array[16] making "'> " move on the next line
                $secondLine = "<station id='".$array[0]."' "."name='".xmlStringReFormater($array[14])."' " . "geocode='" .$array[15]. "," . rtrim($array[16], PHP_EOL) . "'> ";
                $secondLine = $secondLine . PHP_EOL;
                fWrite($xmlToCreate[$i], $secondLine);
                $flagSecondLine = false;
                
                $string = createXMLRecord($array);
                fWrite($xmlToCreate[$i], $string. PHP_EOL);

            }elseif($count > 1){//Code to add records goes here
               //siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long
                if ( $array[2] !== ";" || $array[4] !== ";" && $array[3] !== ";"){
                $string = createXMLRecord($array);
                fWrite($xmlToCreate[$i], $string. PHP_EOL);
                }
            }
            $count++;
        }
        if($count == 1){
            $splitStationFileName = explode("/", stream_get_meta_data($xmlToCreate[$i])["uri"])[1];
            $splitStation = explode("-", $splitStationFileName)[1];
            $splitStationNumber = explode(".", $splitStation)[0];
            $secondLine = "<station id='".$splitStationNumber."' "."name='"."NO-DATA"."' " . "geocode='"."NO-DATA"."'> ";
            fWrite($xmlToCreate[$i], $secondLine. PHP_EOL);
        }
        fWrite($xmlToCreate[$i], "</station>". PHP_EOL);
    }
}
$st = microtime(true);
xmlCreate($xmlToCreate);
xmlWrite($xmlToCreate, $csvToPull);
echo '<p>It took ';
echo microtime(true) - $st;
?>
</body>
</html>