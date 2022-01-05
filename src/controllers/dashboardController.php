<?php

class DashboardController extends Controller {

    function defaultAction(){   

        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("artisan.login.view");  
        }

        $db = initializeDb();
        $artisan = new Artisan($db);

        $profile = $artisan->get_profile();

        $view_data["profile"] = $profile;
        $view_data["average_rating"] = $artisan->get_average_artisan();

        $template = new Template("artisan.dashboard");
        $template->view("artisan.dashboard.view", $view_data);  
    }
    
    function profileAction() {
    
        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("artisan.login.view");  
        }
        
        $db = initializeDb();
        $artisan = new Artisan($db);
        $view_data["profile"] = $artisan->get_profile();


        $city = new City($db);
        $view_data["cities"] = $city->get_cities();


        $template = new Template("artisan.dashboard");
        $template->view("artisan.profile.view", $view_data);  
    }

    function updateProfileAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $result = $artisan->update_profile();
        $view_data["result"] = $result;
        $view_data["profile"] = $artisan->get_profile();

        $city = new City($db);
        $view_data["cities"] = $city->get_cities();

        $template = new Template("artisan.dashboard");
        $template->view("artisan.profile.view", $view_data);  
    }

    function getchangePasswordPageAction() {

        if(!$_SESSION['is_logged']){
            $template = new Template("auth");
            $template->view_no_data("artisan.login.view");  
        }
        $db = initializeDb();
        $artisan = new Artisan($db);
        $view_data["profile"] = $artisan->get_profile();
        $template = new Template("artisan.dashboard");
        $template->view("artisan.password.view", $view_data);  

    }

    function changePasswordAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $result = $artisan->update_password();
        $view_data["result"] = $result;
        $view_data["profile"] = $artisan->get_profile();

        $template = new Template("artisan.dashboard");
        $template->view("artisan.password.view", $view_data);  
    }

    function getupdateSkillsPageAction() {

        $db = initializeDb();
        $artisan = new Artisan($db);

        $view_data["profile"] = $artisan->get_profile();
        $view_data["skills"] = $artisan->get_artisan_skills();

        $trade = new Trade($db);
        $view_data["trades"] = $trade->get_trades();


        $template = new Template("artisan.dashboard");
        $template->view("artisan.skills.view", $view_data);  

    }

    function updateSkillsAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $view_data["result"] = $artisan->update_skills();

        $view_data["profile"] = $artisan->get_profile();
        $view_data["skills"] = $artisan->get_artisan_skills();
        $trade = new Trade($db);
        $view_data["trades"] = $trade->get_trades();

        $template = new Template("artisan.dashboard");
        $template->view("artisan.skills.view", $view_data);  
    }

    function getProfRegistrationPageAction() {

        $db = initializeDb();
        $artisan = new Artisan($db);

        $view_data["profile"] = $artisan->get_profile();
        $view_data["profReg"] = $artisan->get_professional_registration();

        $trade = new Trade($db);
        $view_data["trades"] = $trade->get_trades();

        $template = new Template("artisan.dashboard");
        $template->view("artisan.profRegistrations.view", $view_data);  

    }

    function updateProfRegistrationsAction() {
    
        $db = initializeDb();
        $artisan = new Artisan($db);

        $view_data["result"] = $artisan->update_professional_registrations();

        $view_data["profile"] = $artisan->get_profile();
        $view_data["profReg"] = $artisan->get_professional_registration();
        $trade = new Trade($db);
        $view_data["trades"] = $trade->get_trades();

        $template = new Template("artisan.dashboard");
        $template->view("artisan.profRegistrations.view", $view_data);  
    }

    function switchAvailabilityAction() {
        $db = initializeDb();
        $artisan = new Artisan($db);
        $artisan->switch_availability();
        return $this->defaultAction();
    }

    function deleteuserAction() {

        $db = initializeDb();
        $admin = new Admin($db);
        $admin->delete_user();
        $view_data["profile"] = $admin->get_profile();
        $view_data["users"] = $admin->get_users();
        $template = new Template("admin.dashboard");
        $template->view("admin.dashboard.view", $view_data);  

    }

  
    
}
?>