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
        $tradeId = $_POST['tradeId'];
        $query = "INSERT INTO ArtisanTrades (artisanId, tradeId)
        VALUES ('$artisanId', '$tradeId')";

        if($this->db->query($query))
        {
            $result['response'] = true;
            $result['message'] = 'Skill successfully added';
            return $result;
        }
        else{
            $result['response'] = false;
            $result['message'] = 'Failed';
            return $result;
        }

    }


    public function get_professional_registration()
	{
		$artisanId = $_SESSION['userId'];
		$query  = 'SELECT profReg, tradeId, name FROM ArtisanProfRegistrations A LEFT JOIN Trades B ON A.tradeId = B.Id WHERE A.artisanId = ' . $artisanId;
        $result = array();
		$result = $this->db->query($query)->fetch_all();
		return $result;
	}



    public function update_professional_registrations()
    {
        $artisanId = $_SESSION['userId'];

        if(isset($_POST['profReg'])) 
        {
            $tradeId = $_POST['tradeId'];
            $profReg = $_POST['profReg'];
            $query = "INSERT INTO ArtisanProfRegistrations (artisanId, tradeId, profReg)
            VALUES ('$artisanId', '$tradeId', '$profReg')";

            if($this->db->query($query))
            {
                $result['response'] = true;
                $result['message'] = 'Professional Regisration successfully added';
                return $result;
            }
            else{
                $result['response'] = false;
                $result['message'] = 'Failed';
                return $result;
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


    public function switch_availability()
	{

		$username = $_SESSION['username'];
		$currentAvailability = $_SESSION['isAvailable'];  
        $availability = $currentAvailability == 0 ? 1 : 0;

		$query = "UPDATE users SET isAvailable='$availability'
				   WHERE username ='" . "$username " . "'";

		$this->db->query($query);
	}

    public function search_artisans()
	{
		$cityId = $_POST['cityId'];
        $tradeId = $_POST['tradeId'];

		$query  = "SELECT A.firstName, A.lastName, A.email, A.address, A.phoneNumber, A.hourlyRate, C.Name, C.imageUrl, D.Name FROM Users A LEFT JOIN ArtisanTrades B ON A.Id = B.artisanId LEFT JOIN Trades C ON B.tradeId = C.Id LEFT JOIN Cities D ON A.City = D.Id WHERE A.City = $cityId AND B.tradeId = $tradeId GROUP BY A.Id";
        $result = array();
        
		$result = $this->db->query($query)->fetch_all();
		return $result;
	}


    public function rate_artisan()
	{
		$ratingPin = $_POST['ratingPin'];
        $rating = $_POST['rating'];
        $name = $_POST['name'];

        $getArtisanQuery = "SELECT Id, firstName, lastName FROM Users WHERE ratingPin = $ratingPin";
        $artisan = $this->db->query($getArtisanQuery)->fetch_object();
        if(!empty($artisan))
        {
            $artisanId = $artisan->Id;
            $query = "INSERT INTO ArtisanRatings (artisanId, name, rating)
            VALUES ('$artisanId', '$name', '$rating')";
            $this->db->query($query);
            return $artisan; 
        }
        return null;	
	}
    

}