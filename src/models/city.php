<?php 

class City {
    
    //Properties 
    private $id;
    private $name;
    private $description;
    
    private $db;

    public function __construct($db) 
	{
		$this->db = $db;
	}

    public function get_cities()
	{
		$query  = 'SELECT Id, name FROM Cities';
        $result = array();

		$result = $this->db->query($query)->fetch_all();
		return $result;
	}
   


}

?>