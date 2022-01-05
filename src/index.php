<?php

//This Files handles routing of requests to controllers

session_start();
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

//Include Models Required in the Controller
include 'models/artisan.php';
include 'models/admin.php';
include 'models/trade.php';
include 'models/city.php';

//Require Database Config, Controller and Template
require 'models/database.php'; 
require_once 'controllers/controller.php';
require 'views/template.php';


$section = $_GET['section'] ?? $_POST['section'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';


//Router
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

