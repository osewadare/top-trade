<?php

class AuthController extends Controller {

    function defaultAction(){   
        $template = new Template("auth");
        $template->view_no_data("login.view");  
    }

    function loginAction() {
        include 'models/artisan.php';
        require 'models/database.php';  
        $db = initializeDb();
        $artisan = new Artisan($db);
        $artisan->login();

        $view_data["username"] = $artisan->get_username();
        $view_data["messages_count"] = "1000";
        $view_data["profile_views"] = "1000";
        $view_data["average_rating"] = "1000";
        $view_data["rating_count"] = "1000";

        $view_data["recent_messages"] = array("Hi, It's Peter Parker. Are you available for a plumbong job");
        $template = new Template("dashboard");
        $template->view("artisan.dashboard.view", $view_data);  
    }

    function change_passwordAction() {

        $view_data[""] = "";
        $template = new Template("auth");
        $template->view("change_password.view.php", $view_data);  
    }

    function logoutAction() {

        $view_data[""] = "";
        $template = new Template("auth");
        $template->view("index.view.php", $view_data);  
    }
    
}
?>