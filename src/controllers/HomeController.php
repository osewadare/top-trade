
<?php


class HomeController extends Controller {

    function defaultAction()
    {   
        $db = initializeDb();
        
        $trade = new Trade($db);
        $view_data["trades"] = $trade->get_trades();

        $artisan = new Artisan($db);
        $view_data["artisans"] = $artisan->get_artisans();

        $city = new City($db);
        $view_data["cities"] = $city->get_cities();

        $template = new Template("index");
        $template->view("index.view", $view_data);  
    }

    function searchArtisanAction()
    {
        $db = initializeDb();
        $artisan = new Artisan($db);

        $view_data['searchResults'] = $artisan->search_artisans();

        $view_data["profile"] = $artisan->get_profile();
        $city = new City($db);
        $view_data["cities"] = $city->get_cities();
        $trade = new Trade($db);
        $view_data["trades"] = $trade->get_trades();

        $template = new Template("index");
        $template->view("searchResults.view", $view_data);  
    }
    
}


