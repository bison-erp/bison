<?php

/* * **************** ESPACE USERS **************** */

function isUserByUsernameAndPassword($username, $password)
{
    $password = cryptPassword($password);
    $query = "SELECT * FROM ab_superadmin WHERE username = '$username' AND password = '$password'";
    if (dbExecuteCountArray($query) != 0) {
        return true;
    } else {
        return false;
    }

}

function getUserInfoByUsernameAndPassword($username, $password)
{
    $password = cryptPassword($password);
    $query = "SELECT * FROM ab_superadmin WHERE username = '$username' AND password = '$password'";
    return dbExecute($query);
}

function isUserById($id)
{
    $query = "SELECT * FROM ab_superadmin WHERE id = '$id'";
    if (dbExecuteCountArray($query) != 0) {
        return true;
    } else {
        return false;
    }

}

function getUserInfoById($id)
{

    $query = "SELECT * FROM ab_superadmin WHERE id = '$id'";
    return dbExecute($query);
}

function updateProfil($post)
{
    $fullname = $post['fullname'];
    $password = cryptPassword($post['password']);
    $update_password = $post['update_password'];

    if ($update_password == 1) {
        $query = "UPDATE `ab_superadmin`SET
            `fullname` = '$fullname',
            `password` = '$password'

             WHERE id = 1";
    } else {
        $query = "UPDATE `ab_superadmin`SET
            `fullname` = '$fullname'

             WHERE id = 1";
    }

    echo $query;
    dbSimpleExecute($query);
    return true;
}

function connectUser($id)
{
    global $session_name;
    $_SESSION[$session_name]['superadmin_id'] = $id;
    $_SESSION[$session_name]['logged'] = true;
}

function isUserConnected()
{
    global $session_name;
    if (isset($_SESSION[$session_name]['logged']) && isset($_SESSION[$session_name]['superadmin_id']) && $_SESSION[$session_name]['logged'] == true && $_SESSION[$session_name]['superadmin_id'] != 0 && isUserById($_SESSION[$session_name]['superadmin_id'])) {
        return true;
    } else {
        return false;
    }

}

function logoutUser()
{
    global $session_name;
    $_SESSION[$session_name]['superadmin_id'] = 0;
    $_SESSION[$session_name]['logged'] = false;
}

/* * **************** FIN ESPACE USERS **************** */