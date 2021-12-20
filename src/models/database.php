<?php

function initializeDb(){
    require_once('config/db.php');
    $db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if ($db->connect_errno) {
        echo 'Database connection problem: ' . $db->connect_errno;
        exit();
    }
    return $db;
}


?>