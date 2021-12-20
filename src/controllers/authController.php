<?php

class AuthController extends Controller {

    function defaultAction(){
        
        include 'views/login.view.php';
    }

    function loginAction() {

        include 'models/artisan.php';

        require 'models/database.php';
        
        $db = initializeDb();

        // create new artisan and call login function on artisan 
        $artisan = new Artisan($db);

        $artisan->login();
        
    }
    
}
?>