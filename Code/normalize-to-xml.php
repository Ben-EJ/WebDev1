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

// Creates and opens XML files.
function xmlCreate($xmlToCreate){
    $firstLine = "<?xml version='1.0' encoding='UTF-8' ?>". PHP_EOL;
    foreach ($xmlToCreate as &$xmlFiles){
        fwrite($xmlFiles, $firstLine);
    }
}

// Create new XML element for a given CSV line.
function createXMLRecord($array){
    // Deletes unneeded data.
    unset($array[0]);
    unset($array[14]);
    unset($array[15]);
    unset($array[16]);
    $array = array_values($array);

    $fieldArray = array(" ts='"," nox='"," no2='"," no='"," pm10='"," nvpm10='"," vpm10='",
    " nvpm2.5='"," pm2.5='", " vpm2.5='"," co='"," o3='"," so2='");
    
    $finalString = "<rec";
    
    // Creates new XML <rec> Element with attrabutes in $array.
    for($i = 0; $i < count($array); $i++){
        if($array[$i] != ";"){ // if the data is not empty then add it
            $finalString = $finalString." ".$fieldArray[$i].$array[$i]."' ";
        }
    }
    $finalString = $finalString."/>"; // Close XML tag
    return $finalString; // Return finished element
}

// Reformats a given string to remove prohibited charicters like & and '
function xmlStringReFormater($string){
    $chars = str_split($string);// Split string into chars.
    $charsToAvoid = ["&","'"];
    $reconstructedString = "";
    for ($i = 0; $i < count($chars); $i++){// For each char in string.
        $containsFlag = true;
        // Check to see if char is within the charsToAvoid list.
        for($z = 0; $z < count($charsToAvoid); $z++){
            if($chars[$i] == $charsToAvoid[$z]){// If it is set containsFlag to false.
                $containsFlag = false;
            }
        }
        if($containsFlag){// If the char is not forbidden add the char back to the string.
            $reconstructedString = $reconstructedString . $chars[$i];
        }
    }
    return $reconstructedString;// Return reconstructed string.
}

//Writes XML elements to XML file.
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

            }elseif($count > 1){// Skips the first element
                // Creates a new record so long as NOX or NO and NO2 have values.
                if ( $array[2] !== ";" || $array[4] !== ";" && $array[3] !== ";"){
                $string = createXMLRecord($array);
                fWrite($xmlToCreate[$i], $string. PHP_EOL);
                }
            }
            $count++;
        }
        if($count == 1){// If CSV file is empty ensures that the XML station tags are completed regardless to produce valid XML file.
            // Gets station number out of file name
            $splitStationFileName = explode("/", stream_get_meta_data($xmlToCreate[$i])["uri"])[1];
            $splitStation = explode("-", $splitStationFileName)[1];
            $splitStationNumber = explode(".", $splitStation)[0];
            // Creates and writes station element to file.
            $secondLine = "<station id='".$splitStationNumber."' "."name='"."NO-DATA"."' " . "geocode='"."NO-DATA"."'> ";
            fWrite($xmlToCreate[$i], $secondLine. PHP_EOL);
        }
        fWrite($xmlToCreate[$i], "</station>". PHP_EOL);
    }
}
// Code use to check time taken to complete task.
$st = microtime(true);
xmlCreate($xmlToCreate);
xmlWrite($xmlToCreate, $csvToPull);
echo '<p>It took ';
echo microtime(true) - $st;
?>
</body>
</html>