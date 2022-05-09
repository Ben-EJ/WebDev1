# **ATIWD2 Report**
## Parsing methods
### DOM 
There are many methods of parsing files like XML that exist in a whole range of programming languages. The first of which being DOM. This is where the document is treated like tree data structure, where in nodes of said tree, represent a given part of the document (MDN, 2022). This method of document parsing is supported by many languages, such as JavaScript and Python.

#### Example of DOM with HTML and JavaScript
Here is an example of how this can be used in JavaScript/HTML:
##### HTML Example:
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
##### JavaScript Example:
```
function addOption(){
    var scatterOptions = document.getElementById('favouriteFood'); 
    var option = document.createElement("option"); 
    option.text = "Cheese Burger"; 
    option.value = "CheeseBurger"; 
    scatterOptions.add(option);
}
```
As can be seen in the code above, ```document.getElementById``` gets an element within the document by its id. This can then be utilised within JavaScript to add a new option to the selection box. 

### SAX
Another parsing method, commonly referred to as SAX or "Simple API for XML" is an event-driven method of accessing XML documents (Oracle). It is most notably used in Java. It is used in a variety of applications but most notably network oriented programs as it is that fastest and least memory intensive method when dealing with XML documents besides StAX also referred to as the Streaming API for XML (Oracle).

### Stream Oriented parsers 
A streams-oriented parser unlike a DOM parser does not transmit and represent the whole document in a tree format and storing the whole thing in memory (Oracle). Instead, it transmits the XML infosets where they are sent and parsed serially when the application is run (Oracle). One example of a steam-oriented parser can be found in PHP, or more specifically the XMLReader class whereas the reader is like a cursor that moves forward along the document stream then stops at each node on the way to the end of said document (PHP).

### DOM oriented parsers compared with Stream Oriented Parsers
There are many differences, advantages and disadvantages to both DOM parsers and Stream oriented parsers. Most notably as previously stated, DOM parsers represent an entire document in a tree like data structure, storing the whole thing in memory. Whereas the stream-oriented approach XML infosets are sent and parsed serially, the main advantage of the serial approach is it uses less memory as the Document is not stored in its entirety at the same time. This is not an issue with smaller documents, but the larger the document, the worse this will become. Therefore, in situations where one would need to use as little memory and have less proccessing power avalable a Stream orented parser may be the best aproach. A great example of this was one laid out by Oracle, in which they said most of XML business logic would actually benefit from stream processing, as applications that have strict memory limits or must process simultaneous many requests would benefit from a stream-oriented approach (Oracle). 

Another example in which a Stream-Oriented approach could be applied is within this assignment, as in the code, for all tasks, DOM was used, the assignment required the processing of large datasets, symptoms of this can be found when the data is being processed as this does take a lot of time as the whole file must be sent from the server and loaded into memory before any proccesing can be done, if a stream-oriented approach was adopted, this would likely not take as long as only the parts of the document that are required are accessesed. However, when dealing with small files, DOM is perfectly suitable and is likely the better choice. 

## How Charting Can Be Enhanced. 
### Generalization
There are many ways in which the charting task code could be improved, the first being the introduction of generalization. There are many ways to achieve this For example, instead of declearing a const array of station.xml files as so:

![Figure 1 XML Files Hard Coded](Code/XML%20Files.png)

A way for a user to upload more, similar files, to be processed would also make this program more flexible and less restricted to a hardcoded selection of data files, such as in Figure 1 shown above. 

Further genralisation could be applied if a config file was created to handle user choice, such as in the case as Figure 2 shown bellow:

![Figure 2 Valid Years](Code/ValidYears.png)

This sort of parameter could be placed in a config file, giving the user more control and allowing for further flexability.

### Futher Optimisation
Furthermore, as disscussed in the research setction of this report regarding the benefits of stream-oriented parsing and DOM, it was concluded that Stream-Oprented parsing would have been the better choice, as it works better and is much faster when it comes to dealing with larger datasets and requires less memeory and proccessing power. Knowing this implementing stream-oriented parsing over DOM, would be a majour improvement in terms of optimising the code. Either this or the data could be sorted further, I.E XML files containing spesific dates could be created allowing quicker access to spesific dates and times, instead of sorting the data set each time it is needed. 

### User Interface Improvements
Another highly important aspect of improvement for the charting task is to impove the user interface. 
There are many ways in which to do this however, due to many users, using mobile technology to access and interact with websites, in future to improve this task it would have been better to go for a more mobile first approach to the UI design. 
This can be achieved in many ways. For example, by using the CSS framework Bootstrap. This allows developers to utilise CSS already created and enhanced for a whole range of devices, 
such as mobile. Furthermore, due to its plethora of supported devices, 
it can be used to allow all devices to view the charting webpage with well formatted webpages.

### Validity Of Data To Be Charted
Data validity is incredibly important. One way in which the charting website/task could be improved is with the introduction of the use of XML Schemas to validate the xml data to be processed. This does many things, namely ensures the reliability of the data, and ensures any imputed data will not generate errors whilst it is being processed.

### Possible Delivery Method of The Final Product
There many ways in which the product can be hosted or packaged for use in production. One way in which this can be done is using Docker. Docker allows a given developer to package their code and any dependencies there within a container. A container allows a developer to package there software so that it is abstracted from the environment it is run in. Meaning they can be used simply and reliably and run anywhere without any hassle. 

## Discussion of learning outcomes
During the course of this assignment and all its task I have gained a plethora of new knowledge, mainly about JavaScript and PHP. In terms of JavaScript the new knowledge includes, working with asynchronous functions like AJAX, and using things like promises to ensure the completion of asynchronous tasks before the start of another. My general knowledge of both JavaScript and PHP has been enhanced also. For example, the difference in speed between functions that do similar things in PHP, for example, ```fgets()``` and  ```fgetcsv()```. ```fgets()``` is far quicker than ```fgetcsv()```. 

# References
MDN (2022) Introduction to the DOM. Available from: https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model/Introduction [Accessed 28 April 2022].

PHP (No Date) The XMLReader Class Available from:
https://www.php.net/manual/en/class.xmlreader.php [Accessed 29 April 2022].

Oracle (No Date) Java tutorials. Available from:
https://docs.oracle.com/javase/tutorial/jaxp/sax/index.html [Accessed 29 April 2022].

Oracle (No Date) Streaming Versus DOM. Available from:
https://docs.oracle.com/cd/E19316-01/819-3669/bnbdx/index.html [Accessed 29 April 2022].

