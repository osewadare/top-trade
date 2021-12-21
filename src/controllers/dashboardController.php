<?php

class DashboardController extends Controller {


    function defaultAction(){   

        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("login.view.php");  
        }

        include 'models/artisan.php';
        require 'models/database.php';  
        $db = initializeDb();
        $artisan = new Artisan($db);

        $profile = $artisan->get_profile();
        $view_data["profile"] = $profile;
        $view_data["messages_count"] = "1000";
        $view_data["profile_views"] = "1000";
        $view_data["average_rating"] = "1000";
        $view_data["rating_count"] = "1000";

        $view_data["recent_messages"] = array("Hi, It's Peter Parker. Are you available for a plumbong job");

        $template = new Template("dashboard");
        $template->view("artisan.dashboard.view", $view_data);  
    }


    function messagesAction() {
        $view_data[""] = "";
        $template = new Template("dashboard");
        $template->view("index.view.php", $view_data);  
    }


    function profileAction() {

        include 'models/artisan.php';
        require 'models/database.php'; 
    
        $db = initializeDb();
        $artisan = new Artisan($db);
        $view_data["profile"] = $artisan->get_profile();
        $template = new Template("dashboard");
        $template->view("profile.view", $view_data);  
    }

    function updateProfileAction() {

        include 'models/artisan.php';
        require 'models/database.php'; 
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $result = $artisan->update_profile();
        $view_data["result"] = $result;
        $view_data["profile"] = $artisan->get_profile();

        $template = new Template("dashboard");
        $template->view("profile.view", $view_data);  
    }
    
}
?>