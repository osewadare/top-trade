<?php

session_start();
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);


require_once 'controllers/controller.php';
require 'views/template.php';


$section = $_GET['section'] ?? $_POST['section'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';


if ($section=='auth') {
    include 'controllers/authController.php';
    $authController = new authController();
    $authController->runAction($action);   
} 
else if ($section=='dashboard') {
    include 'controllers/dashboardController.php';
    $dashboardController = new dashboardController();
    $dashboardController->runAction($action);   
} 

else {
    include 'controllers/homePage.php';
}

