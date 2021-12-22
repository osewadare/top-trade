<?php

require 'user.php';

class Artisan extends User {

    private $db;

    function __construct($db)
    {
        parent::__construct($db);
        $this->db = $db;
    }
    
    public function get_artisan_skills()
	{
		$artisanId = $_SESSION['userId'];
		$query  = 'SELECT name FROM ArtisanTrades LEFT JOIN Trades ON ArtisanTrades.tradeId = Trades.Id WHERE artisanId = ' . $artisanId;
        $result = array();

		$result = $this->db->query($query)->fetch_all();
		return $result;
	}

    public function update_skills()
    {
        $artisanId = $_SESSION['userId'];
        if( isset($_POST['skills']) && is_array($_POST['skills']) ) {
            $skills = implode("', '", $_POST['skills']);
            $query  = "SELECT Id FROM Trades WHERE name in ('$skills')";
            echo $query;
            $result = $this->db->query($query)->fetch_all();
            foreach($result as $trade){
                $updateQuery = "UPDATE ArtisanTrades SET tradeId= " . $trade[0] . " WHERE artisanId = " . $artisanId;
            }
            

        }
    }

    public function get_artisans()
	{
		$query  = 'SELECT firstName, lastName FROM Users WHERE UserRole = "artisan"';
        $result = array();
		$result = $this->db->query($query)->fetch_all();
		return $result;
	}
    

}