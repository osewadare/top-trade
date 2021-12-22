<?php

class AuthController extends Controller {

    function defaultAction(){   
        $template = new Template("auth");
        $template->view_no_data("login.view");  
    }

    function loginAction() {

        $db = initializeDb();

        $artisan = new Artisan($db);
        $result = $artisan->login();

        if($result['response'])
        {

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
        else{
            $view_data['result'] = $result['message'];
            $template = new Template("auth");
            $template->view("login.view", $view_data);              
        }

    }

    function logoutAction() {

        $db = initializeDb();

        $artisan = new Artisan($db);
        $artisan->logout();
        $template = new Template("auth");

        $template->view_no_data("index.view.php");  
    }
    
}
?>