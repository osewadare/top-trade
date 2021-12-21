<?php 
class Template {

    private $layout;

    function __construct($layout){
        $this->layout = $layout;
    }

    function view($template, $view_data){
        extract($view_data);
        include   'layouts/' . $this->layout .  '.html';  
    }

    function view_no_data($template){
        include   'layouts/' . $this->layout .  '.html';  
    }
}
?>