
<?php


class HomeController extends Controller {

    function defaultAction()
    {   
        $db = initializeDb();
        $trade = new Trade($db);
        $trades = $trade->get_trades();

        $artisan = new Artisan($db);
        $view_data["artisans"] = $artisan->get_artisans();

        $view_data["trades"] = $trades;

        $template = new Template("");
        $template->view_no_layout("index.view", $view_data);  
    }
    
}


