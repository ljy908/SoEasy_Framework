
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
A:link {
	COLOR: black;
	TEXT-DECORATION: none
}

A:visited {
	COLOR: blue;
	TEXT-DECORATION: none
}

A:hover {
	COLOR: orange;
	TEXT-DECORATION: underline
}
</style>

<style type="text/css">
.button_set {
	width: 300px;
	font-color: #000000;
}

.file_input_textbox {
	width: 200px;
	float: left
}

.file_import_textbox {
	width: 170px;
	float: left
}

.file_input_div {
	position: relative;
	width: 100px;
	height: 23px;
	overflow: hidden;
}

.file_input_button {
	width: 100px;
	position: absolute;
	top: 0px;
	color: #000000;
}

.file_input_hidden {
	font-size: 45px;
	position: absolute;
	right: 0px;
	top: 0px;
	opacity: 0;
	filter: alpha(opacity = 0);
	-ms-filter: "alpha(opacity=0)";
	-khtml-opacity: 0;
	-moz-opacity: 0;
}
</style>

<script>

	var input = 0;
	var setting = 0;
	var settingColor = 0;
	var settingBackground = 0;

	function settingOn(){
		setting = 1;
	}

	function settingColorOn(){
		settingColor = 1;
	}

	function settingBackgroundOn(){
		settingBackground = 1;
	}

	function inputText(){
		input = document.getElementById("backup_file_name").value; 
	}
	
	function loadDoc( loadPage ) {
		var xhttp = new XMLHttpRequest();
	
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {					
				var result = this.responseText;
				window.location.assign(result);
			}
		};
		
		xhttp.open("POST", loadPage, true);
		xhttp.send(input); 
	}

	function Backup_button(){
		inputText();
		loadDoc("file_export.php?backup="+input);
	}
	
</script>

</head>

<?php

/* ***************** Setting page ****************** */
$menuSelect = $_GET['menuSelect'];

$i = 0;
$j = 0;
$color = array(
    "#F44336",
    "#E91E63",
    "#9c27b0",
    "#673ab7",
    "#3f51b5",
    "#2196f3",
    "#03a9f4",
    "#00bcd4",
    "#009688",
    "#4caf50",
    "#8bc34a",
    "#cddc39",
    "#ffeb3b",
    "#ffc107",
    "#ff9800",
    "#ff5722",
    "#795548",
    "#9e9e9e",
    "#607d8b",
    "#000000",
    "#FFFFFF"
);
$colorName = array(
    "Red",
    "Pink",
    "Purple",
    "Deep Purple",
    "Indigo",
    "Blue",
    "Light Blue",
    "Cyan",
    "Teal",
    "Green",
    "Light Green",
    "Lime",
    "Yellow",
    "Amber",
    "Orange",
    "Deep Orange",
    "Brown",
    "Grey",
    "Blue Grey",
    "Black",
    "White"
);
// Title path
$titleLocation = "/var/www/project_os/DB/homepage/title";
$fpTitle = fopen($titleLocation, "r");
$title = fread($fpTitle, 255);

// Image path
$imageLocation = "/var/www/project_os/DB/homepage/image";
$imageLocationResult = "/var/www/project_os/DB/homepage/image";

// Read all the files in the folder..
$fpImage = dir($imageLocation);

$imageLocation = "/var/www/project_os/DB/homepage/image";

// External library
$outsideLocation = "/var/www/project_os/DB/outside_library";

// Read the external library value.
$fpOutside = dir("/var/www/project_os/DB/outside_library");

// Table background color
require ('./functionList.php');
$TableColorResult = bgColor();

// Load the desktop picture saved in DB.
$fpImageDown = fopen("/var/www/project_os/DB/homepage/image/imageWhere/down", "r");
$fpImageResult = fread($fpImageDown, 255);
$imageResult = $imageLocation . "/" . $fpImageResult;

$imageSearch = strpos($imageResult, ".jpg");
$imageResult = substr($imageResult, 0, $imageSearch + 4);

echo "<body background	=	'$imageResult'>";
echo "<form action=setting_ok.php method=post>";

while (NULL != ($fileResult = $fpImage->read())) {
    $fileList[$i ++] = $fileResult;
}

// echo "$TableColorResult";

// include topTitle.php
include_once "./topTitle.php";

echo "<br>";
echo "<table border = '1' frame = hsides align = center width = '400' cellpadding='3' cellspacing='0' bordercolor='silver' bordercolorlight='white'><tr align='center'>";
echo "<tr><td align = 'center' colspan = 3 bgcolor = $TableColorResult><b><a href = setting.php?menuSelect=1><font color = 'white' size= '2'>Setting</font></a></b>";

if ($menuSelect == 1) {
    echo "<tr><td width = '50' align = 'center' colspan = 2 bgcolor = white>Control Program</td><td align = center bgcolor = white><a href = cProgram.php?power=on><font color = black>Execute</font></a>&nbsp&nbsp&nbsp<a href = cProgram.php?power=off><font color = 'black'>Exit</font></a><br></td></tr>";
    echo "<tr><td width = '50' align = 'center' colspan = 2 bgcolor = white>Title</td><td bgcolor = white><input type=edit name = title></td></tr>";
    echo "<tr><td width = '50' align = 'center' colspan = 2 bgcolor = white>Refresh Time</td><td bgcolor = white><input type=edit name = refreshTime></td></tr>";
    
    echo "<tr><td width = '50' align = 'center' colspan = 2 bgcolor = white>Export</td><td bgcolor = white>
       <br>
			<div style='float:left;'>
                &nbsp File Name : &nbsp 
            </div>
                <input type='text' id='backup_file_name'                            class='file_import_textbox'>
                <input type='button' value='Submit' onclick=\"Backup_button()\"     class='button_set' style= 'color:ffffff; background-color:$TableColorResult'>  
            <br>
            <br>
		</td></tr>";
    
    echo "<tr><td width = '50' align = 'center' colspan = 2 bgcolor = white>Import</td><td bgcolor = white> 
            <br> 
                <form action='file_import.php' enctype='multipart/form-data' method='POST'>  </form>
                <form action='file_import.php' enctype='multipart/form-data' method='POST'>
                    <input type='hidden' name='MAX_FILE_SIZE' value='30000' />
                    <input type='text' id='fileName'                                class='file_input_textbox' readonly='readonly'>
                    <div                                                            class='file_input_div'>
                        <input type='button' value='Select File'                    class='file_input_button' style= 'color:ffffff; background-color:$TableColorResult'/>
                        <input type='file'   name='importFile'                      class='file_input_hidden' onchange=\"javascript: document.getElementById('fileName').value = this.value\"/>
                    </div>
    				<input type='submit' value='Submit'                             class='button_set' style= 'color:ffffff; background-color:$TableColorResult'/>
    			</form>
            <br>
            <br>
        </td></tr>";
}

echo "</table><br>";

echo "<table border ='1' frame = hsides align = center width = '400' cellpadding='3' cellspacing='0' bordercolor='silver' bordercolorlight='white' bgcolor = white><tr align='center'>";
echo "<tr><td align = 'center' colspan = 5 bgcolor = $TableColorResult><font size=4><b><a href = setting.php?menuSelect=2><font color = white size = 2>Table Color</font></a></font></b></td></tr>";

if ($menuSelect == 2) {
    for ($i = 0; $i < sizeof($color); $i ++) {
        echo "<tr><td align = 'center' colspan = 2 bgcolor = $color[$i] width = 30  bgcolor = white></td>
					  <td bgcolor = white>	<font size = 1>$color[$i] </font></td>
					  <td bgcolor = white>	<b><font size = 2>$colorName[$i]</b></font></td>
					  <td bgcolor = white>	<input type=radio name = tableColor value=$color[$i]></td>";
    }
    
    echo "</tr>";
    echo "</table>";
}

echo "<table border ='1' frame = hsides align = center width = '400' cellpadding='3' cellspacing='0' bordercolor='silver' bordercolorlight='white' bgcolor = white><tr align='center'>";
echo "<tr><td align = 'center' colspan = 5 bgcolor = $TableColorResult><font size=4><b><a href = setting.php?menuSelect=3><font color = white size = 2>Background Image</font></a></font></b></td></tr>";

echo "<br>";

if ($menuSelect == 3) {
    echo " <tr><td colspan = 2 align = center  bgcolor = white>	<font size = 1> Initialize the above <input type = radio name = initUpBackground value = 1> Initialize below <input type = radio name = initDownBackground value = 1> </font></td></tr>";
    for ($i = 0; $i < sizeof($fileList); $i ++) {
        if ($fileList[$i] != "." && $fileList[$i] != ".." && $fileList[$i] != "imageWhere") {
            $imageResult = $imageLocationResult . "/" . $fileList[$i];
            echo "<tr><td align = 'center' colspan = 2 width = 30  bgcolor = white><img src = $imageResult width = 330 height = 330></td>
					  <tr><td colspan = 2  bgcolor = white>	<font size = 1>$fileList[$i] </font></td></tr>
					  <tr><td width = 10  bgcolor = white>	Select </td> <td align = center><input type = radio name = backgroundImage value = $fileList[$i]</td></tr>
					  <tr><td  bgcolor = white> Background location </td><td align = center> <input type = radio name = whereImage value = 'up'> UP <input type = radio name = whereImage value = 'down'> DOWN";
        }
    }
}
echo "</tr>";
echo "</table>";

echo "<p align = center><input type ='submit' value=' O K ' onClick='checkSolution(sb.onoff)'></form>";

?> 
