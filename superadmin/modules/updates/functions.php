<?php

function getUpdatesList() {

    $query = "SELECT * FROM ab_updates ORDER BY id DESC";
    return dbExecuteArray($query);
}

function getUpdateInfo($id) {

    $query = "SELECT * FROM ab_updates WHERE id = '$id'";
    return dbExecute($query);
}

function isUpdate($id) {

    $query = "SELECT * FROM ab_updates WHERE id = '$id'";
    if (dbExecuteCountArray($query) != 0)
        return true;
    else
        return false;
}

function getNextVersion() {
    $query = "SELECT Max(`version`) as max FROM ab_updates";
    $query = dbExecute($query);
    $max = (float) $query['max'];
    $next = $max >= 1 ? $max + 0.1 : 1;
    return $next;
}

function addUpdate($post) {
    $description = $post['description'];
    $database_query = $post['query'];
    $version = getNextVersion();
    $date = date("Y-m-d H:i:s");
    $query = "INSERT INTO `ab_updates`(`created`, `description`, `database_query`, `version`) VALUES('" . $date . "','" . $description . "','" . $database_query . "','" . $version . "') ";
    dbExecute($query);
    echo mysql_insert_id();
}
function editUpdate($post) {
    $description = $post['description'];
    $id_update = $post['id_update'];
    $query = "UPDATE `ab_updates` SET `description` = '" . $description . "' WHERE id = $id_update ";
    dbExecute($query);

}

?>