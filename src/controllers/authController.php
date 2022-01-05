<?php

class AuthController extends Controller {

    function getLoginAction()
    {   
        $template = new Template("auth");
        $template->view_no_data("artisan.login.view");  
    }

    function loginAction() {

        $db = initializeDb();

        $artisan = new Artisan($db);
        $result = $artisan->login();

        if($result['response'])
        {

            $profile = $artisan->get_profile();
            $view_data["profile"] = $profile;
            $view_data["average_rating"] = $artisan->get_average_artisan();

            $template = new Template("artisan.dashboard");
            $template->view("artisan.dashboard.view", $view_data);  

        }
        else{
            $view_data['result'] = $result['message'];
            $template = new Template("auth");
            $template->view("artisan.login.view", $view_data);              
        }

    }

    function getAdminLoginAction()
    {   
        $template = new Template("auth");
        $template->view_no_data("admin.login.view");  
    }

    function adminLoginAction() {

        $db = initializeDb();

        $admin = new Admin($db);
        $result = $admin->login();

        if($result['response'])
        {
            $view_data["profile"] = $admin->get_profile();
            $view_data["users"] = $admin->get_users();
            $template = new Template("admin.dashboard");
            $template->view("admin.dashboard.view", $view_data);  

        }
        else{
            $view_data['result'] = $result['message'];
            $template = new Template("auth");
            $template->view("admin.login.view", $view_data);              
        }

    }

    function getSignupAction(){   
        $template = new Template("auth");
        $template->view_no_data("artisan.signup.view");  
    }
   
    function signupAction() 
    {
        $db = initializeDb();
        $artisan = new Artisan($db);
        $result = $artisan->register();
        if($result['response'])
        {
            $view_data['result'] = $result['message'];
            $template = new Template("auth");
            $template->view("artisan.login.view", $view_data);      
        }
        else{
            $view_data['result'] = $result['message'];
            $template = new Template("auth");
            $template->view("artisan.signup.view", $view_data);              
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