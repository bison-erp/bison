<?php
function cleanPOST($var) {
	if(!is_array($var))
	{	return addslashes($var); }	
	return  $var ;
}

//clean the user's input
function cleanInput($value)
{
    //if the variable is an array, recurse into it
    if(is_array($value))
    {
    	//for each element in the array...
    	foreach($value as $key => $val)
    	{
    		//...clean the content of each variable in the array
    		$value[$key] = cleanInput($val);
    	}

    	//return clean array
    	return $value;
    }
    else
    {
    	return cleanPOST(utf8_decode($value));
    }
}

function redirect($url) {
	echo '
	<html>
	<head>
	<title>Redirection</title>
	<meta http-equiv="refresh" content="0; URL=' . $url .'">
	</head>
	<body>
	</body>
	</html>';
	exit();
}

function dateSlashes($date){
	$date2 = explode("-",$date);
	return $date2[2]."/".$date2[1]."/".$date2[0];
}

function dateTimeSlashes($date){
    $date2 = explode(" ",$date);
    return dateSlashes($date2[0])." ".$date2[1];
}








?>