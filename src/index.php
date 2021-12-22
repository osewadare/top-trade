<?php

session_start();
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

include 'models/artisan.php';
include 'models/trade.php';
require 'models/database.php'; 


require_once 'controllers/controller.php';
require 'views/template.php';


$section = $_GET['section'] ?? $_POST['section'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';


if ($section=='auth') 
{
    include 'controllers/authController.php';
    $authController = new AuthController();
    $authController->runAction($action);   
} 
else if ($section=='dashboard') 
{
    include 'controllers/dashboardController.php';
    $dashboardController = new DashboardController();
    $dashboardController->runAction($action);   
} 

else 
{
    include 'controllers/homeController.php';
    $homeController = new HomeController();
    $homeController->runAction($action); 
}

