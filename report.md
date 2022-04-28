# ATIWD2 Report
## Parsing methods
There are many methods of parsing files like XML. The first being DOM, this is where the document is treated like tree data struckture, where in nodes of said tree, represent a given part of the document (MDN, 2022). This method of document parsing is supported by many languages, such as Javascript and Python.
### Example of DOM with HTML and Javascript
Here is an example of how this can be used in Javascript/HTML:
#### HTML Example:
```
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <select name="favouriteFood" id="favouriteFood">
                <option value="" selected="selected">Select Option</option>
        </select>
    </body>
</html>
```
#### Javascript Example:
```
function addOption(){
    var scatterOptions = document.getElementById('favouriteFood'); // Get element of html document
    var option = document.createElement("option"); //Create new element option
    option.text = "Cheese Burger"; // Set new option text to Cheese Burger
    option.value = "CheeseBurger"; // Set new option value to CheeseBurger
    scatterOptions.add(option); // Add option to selection box
}
```
As can be seen in the code above, ```document.getElementById``` gets an element within the document by its id. This can then be utalised within Javascript to add a new option to the selection box. 

### Example of DOM with XML and Javascript
DOM also can be used with XML for example:

#### XML Document Example:
```
<?xml version='1.0' encoding='UTF-8' ?>
<menu name="Lunch Menu">
    <foodItem name="CheeseBurger" price="5" />
    <foodItem name="CodAndChips" price="10" />
    <foodItem name="Pizza" size="10" price="15" />
    <foodItem name="Pizza" size="20" price="15" />
</menu>
```

#### Javascript Example:
```
function printMenu(fileName){
    const xhttp = new XMLHttpRequest(); // Create new XML Http Request.
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var xmlDoc = this.responseXML; //store xml response in var.
            var foodItem = xmlDoc.getElementsByTagName("foodItem"); // Get all xml tags with the name foodItem.
            for(let i = 0; i < foodItem.length; i++){ // Loop through all food items.
                var itemName = foodItem.getAttribute("name");  // Get the attrabute name from foodItem tags.
                console.log(itemName); // Output the foods name.
            }
        }
    };
    xhttp.open("GET", fileName);
    xhttp.send();
}
```
As can be seen from the code above it is possible to use XML with

## How Charting Can Be Enhanced. 
### Genralistation
There are many ways in which the charting task code could be imporroved, the first being the introducton of genralization. There are many ways to acheve this For example, instead of declearing a const array of station.xml files as so:
```
const stations = ["data-188.xml","data-203.xml","data-206.xml","data-209.xml","data-213.xml",
"dta-215.xml", "data-228.xml","data-270.xml","data-271.xml","data-375.xml","data-395.xml","data-447.xml","data-452.xml","data-459.xml","data-463.xml","data-481.xml","data-500.xml","data-501.xml"];
```
A config file could be created so the user can configure what files they want to be included, to be proccessed and visulized. Furthermore a way for a user to upload more, similar files, to be proccessed would also make this program more flexable and less restricted to a hardcoded selection of data files, such as in the block of code shown above.

### User Interface Improvements
Another highly important aspect of improvement for the charting task is to impove the user interface. There are many ways in which to do this however, due to many users, using mobile technology to access and interact with websites, in future to improve this task it would have been better to go for a more mobile first aproach to the UI design. This can be acheved in many ways. For example by using the CSS framework BootStrap. This allows developers to utalise CSS already created and enhanced for a whole range of devices, such as mobile. Furthermore due to it's plethera of supported devices, it can be used to allow all devices to view the charting webpage with well formatted webpages.

### Vadility Of Data To Be Charted
Data vadility is increadably important. One way in which the charting website/task could be improved is with the introduction of the use of XML Schemas to validate the xml data to be proccessed. This does many things, namely ensures the reliability of the data, and ensures any imputed data will not generate errors whilst it is being proccessed.
### Possible Dilivery Method Of The Final Product
There many ways in which the product can be hosted or packedged for use in production. One way in which this can be done is using Docker. Docker allows a given developer to package there code and any dependancies there within a container. A container allows a developer to package there software so that it is abstracted from the enviroment it is run in. Meaning they can be used simply and realiably, and run anywhere without any hastle. 

## Disscussion of learning outcomes
During the course of this assignment and all it's task I have gained a plethera of new knowleage, mainly about javascript and php. In terms of javascript the new knowledge includes, working with asyncrounous functions like AJAX, and using things like promises to ensure the complition of asyncronous tasks before the start of another. My general knowlage of both javascript and php has been enhanced also. For example, the diffrence in speed between functions that do similar things in php, for example, ```fgets()``` and  ```fgetcsv()```. ```fgets()``` is far quicker than ```fgetcsv()```. 

# Refrences
MDN(2022) Introduction to the DOM. Available from: https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model/Introduction [Accessed 28 April 2022].
