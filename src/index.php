<?php 
require("functions.php");
require('config/db.php');
?>

<?php

//Get all Artisans and there ratings
//Get all Trades


$db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query = 'SELECT * FROM Users WHERE userRole= "tradesman"';
$result = $db->query($query);
$view_model = [];
if($result)
{
    $view_bag['tradesmen'] = $result;
}
else
{
    $view_bag['message'] = "No Tradesmen";
}
view("index", $view_model);

?>

