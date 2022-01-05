<?php 

class Trade {
    
    //Properties 
    private $id;
    private $name;
    private $description;
    
    private $db;

    public function __construct($db) 
	{
		$this->db = $db;
	}

    public function get_trades()
	{
		$query  = 'SELECT name, imageurl, Id FROM Trades';
        $result = array();

		$result = $this->db->query($query)->fetch_all();
		return $result;
	}
}

?>