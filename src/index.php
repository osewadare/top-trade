<?php

require_once 'controllers/controller.php';

$section = $_GET['section'] ?? $_POST['section'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';


if ($section=='auth') {
    
    include 'controllers/authController.php';
    $authController = new authController();
    $authController->runAction($action);   
} 

else {
    include 'controllers/homePage.php';
}

