<?php

function generatePassword()
{
    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwxyZ0123456789';

    $serial = '';

    for ($i = 0; $i < 2; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $serial .= $tokens[rand(0, 61)];
        }

//        if ($i < 4) {
        //            $serial .= '-';
        //        }
    }
    return $serial;
    if (existLicenceKey($serial)) {
        return 0;
    } else {
        return $serial;
    }
}

function generateLicenceKey2()
{
    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $serial = '';

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $serial .= $tokens[rand(0, 35)];
        }

        if ($i < 4) {
            $serial .= '-';
        }
    }
    return $serial;
    if (existLicenceKey($serial)) {
        return 0;
    } else {
        return $serial;
    }
}

function generateLicenceKey()
{
    $serial = getRandLicence();
    if (existLicenceKey($serial)) {
        return generateLicenceKey();
    } else {
        return $serial;
    }
}

function getRandLicence()
{

    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tokens = '0123456789';

    $serial = '';

    for ($i = 0; $i < 1; $i++) {
        for ($j = 0; $j < 4; $j++) {
            $serial .= $tokens[rand(0, 9)];
        }

        if ($i < 0) {
            $serial .= '-';
        }
    }
    return $serial;
}

function existLicenceKey($licence)
{

    $query = "SELECT * FROM ab_abonnes WHERE licence_key = '$licence'";
    if (dbExecuteCountArray($query) != 0) {
        return true;
    } else {
        return false;
    }

}

function cryptPassword($password)
{
    return sha1($password);
}

// FUNCTIONS DB
function existDB($dbname)
{
    $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $dbname . "'";
    if (dbExecuteCountArray($query) != 0) {
        return true;
    } else {
        return false;
    }

}

function createDb($dbname)
{
    $query = "CREATE DATABASE IF NOT EXISTS $dbname ";
    dbSimpleExecute($query);
}

function deleteDb($dbname)
{
    $query = "DROP DATABASE IF EXISTS $dbname ";
    dbSimpleExecute($query);
}

function insertDbFirstTime($dbname)
{
    createDb($dbname);
    global $config_database;

    $mysqlUserName = $config_database['username'];
    $mysqlPassword = $config_database['password'];
    $mysqlImportFilename = 'sql/default_erp.sql';

//DO NOT EDIT BELOW THIS LINE
    $mysqlHostName = 'localhost';
//Export the database and output the status to the page
    $command = 'mysql -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $dbname . ' < ' . $mysqlImportFilename;
    exec($command, $output = array(), $worked);
    if ($worked == 0) {
        return true;
    } else {
        return false;
    }
}

function exportDb($dbname, $path)
{
    global $config_database;
    $mysqlUserName = $config_database['username'];
    $mysqlPassword = $config_database['password'];
    $mysqlHostName = $config_database['host'];
    $mysqlExportPath = $path;
    $command = 'mysqldump --opt -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $dbname . ' > ' . $mysqlExportPath;
    echo $command;
    exec($command, $output = array(), $worked);
    if ($worked == 0) {
        return true;
    } else {
        return false;
    }
}

function salt()
{
    return substr(sha1(mt_rand()), 0, 22);
}

function generate_password($password, $salt)
{
    return crypt($password, '$2a$10$' . $salt);
}

function check_password($hash, $password)
{
    $new_hash = crypt($password, $hash);

    return ($hash == $new_hash);
}

function recursiveDelete($directory)
{
    // if the path is not valid or is not a directory ...
    if (!file_exists($directory) || !is_dir($directory)) {
        return false;
    } elseif (!is_readable($directory)) { // ... if the path is not readable
        return false;
    } else { // ... else if the path is readable
        // open the directory
        $handle = opendir($directory);

        // and scan through the items inside
        while (false !== ($item = readdir($handle))) {
            // if the filepointer is not the current directory
            // or the parent directory
            if ($item != '.' && $item != '..') {
                // we build the new path to delete
                $path = $directory . '/' . $item;

                // if the new path is a directory
                if (is_dir($path)) {
                    // we call this function with the new path
                    recursiveDelete($path);
                } else { // if the new path is a file
                    // remove the file
                    if (!is_writable($path)) {
                        chmod($path, 0644);
                    }
                    @unlink($path);
                }
            }
        }

        // close the directory
        closedir($handle);

        // try to delete the now empty directory
        if (@!rmdir($directory)) {
            return false;
        }

        return true;
    }
}
function recurse_copy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

