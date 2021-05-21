<?php

function dbSimpleExecute($query)
{
    #mysql_query("SET NAMES 'utf8'");
    mysql_query($query) or die("Erreur SQL: " . mysql_error());
    return true;
}

function dbExecute($query)
{
    #mysql_query("SET NAMES 'utf8'");
    $result = mysql_query($query) or die("Erreur SQL: " . $query . mysql_error());
    $array = mysql_fetch_assoc($result);
    $array2 = array();
    if (count($array) != 0) {
        foreach ($array as $k => $v) {
            $array2[$k] = utf8_encode($v);
        }
    }
    return $array2;
}

function dbExecuteArray($query, $id = "id")
{
    if (dbExecuteCountArray($query) != 0) {
        #mysql_query("SET NAMES 'utf8'");
        $results = mysql_query($query) or die("Erreur SQL: " . mysql_error());
        while ($result = mysql_fetch_assoc($results)) {
            if ($result[$id]) {
                $array[$result[$id]] = $result;
            } else {
                $array[] = $result;
            }

        }

        return $array;
    }

}
function dbExecuteCountArray($query)
{
    #mysql_query("SET NAMES 'utf8'");
    $result = mysql_query($query) or die("Erreur SQL: " . mysql_error());
    $array = mysql_num_rows($result);
    return $array;
}