<?php

class DashboardController extends Controller {


    function defaultAction(){   

        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("login.view.php");  
        }
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
    
        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("login.view.php");  
        }
        
        $db = initializeDb();
        $artisan = new Artisan($db);
        $view_data["profile"] = $artisan->get_profile();
        $template = new Template("dashboard");
        $template->view("profile.view", $view_data);  
    }

    function updateProfileAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $result = $artisan->update_profile();
        $view_data["result"] = $result;
        $view_data["profile"] = $artisan->get_profile();

        $template = new Template("dashboard");
        $template->view("profile.view", $view_data);  
    }

    function getchangePasswordPageAction() {

        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("login.view.php");  
        }
        $db = initializeDb();
        $artisan = new Artisan($db);
        $view_data["profile"] = $artisan->get_profile();
        $template = new Template("dashboard");
        $template->view("password.view", $view_data);  

    }

    function changePasswordAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $result = $artisan->update_password();
        $view_data["result"] = $result;
        $view_data["profile"] = $artisan->get_profile();

        $template = new Template("dashboard");
        $template->view("password.view", $view_data);  
    }

    
    function getupdateSkillsPageAction() {

        $db = initializeDb();
        $artisan = new Artisan($db);
        $view_data["profile"] = $artisan->get_profile();

        $artisanSkills = $artisan->get_artisan_skills();
        $trade = new Trade($db);
        $trades = $trade->get_trades();

        foreach($artisanSkills as $skill)
        {
            $skills[] = $skill[0];

        }

        foreach($trades as $item){

            if(in_array($item[0], $skills))
            {
                $result[$item[0]] = true;
            }
            else{
                $result[$item[0]] = false;
            }
        }
        $view_data["result"] = $result;

        $template = new Template("dashboard");
        $template->view("skills.view", $view_data);  

    }

    function updateSkillsAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $result = $artisan->update_skills();
        $view_data["result"] = $result;
        $view_data["profile"] = $artisan->get_profile();

        $template = new Template("dashboard");
        $template->view("profile.view", $view_data);  
    }
    
}
?>