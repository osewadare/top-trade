<?php

class Admin extends User {

    private $db;

    function __construct($db)
    {
        parent::__construct($db);
        $this->db = $db;
    }

    public function login() 
    {
			$this->username = $this->db->real_escape_string($_POST['username']);
			$this->userPassword = sha1($this->db->real_escape_string($_POST['password']));

			if(empty($this->username) ||  empty($this->userPassword)){
				return;
			}

			if ($row = $this->authenticate_user()) 
            {
				session_regenerate_id(true);
				$_SESSION['id'] = session_id();
				$_SESSION['is_logged'] = true;
				$_SESSION['username'] = $row->Username;
				$_SESSION['userId'] = $row->Id;

				$this->firstName = $row->FirstName;
				$this->lastName = $row->LastName;
				$this->email = $row->Email;
				$this->phoneNumber = $row->PhoneNumber;
				$this->address = $row->Address;

				// Set a cookie that expires in one week
				if (isset($_POST['remember']))
					setcookie('username', $this->username, time() + 604800);

				$result['response'] = true;
				$result['message'] = 'login successful';
				return $result;
		
			}
			else{
				$result['response'] = false;
				$result['message'] = 'Username or password incorrect.';
				return $result;
			}
       

	}

    public function get_profile()
	{
		$username = $_SESSION['username'];
		$query  = 'SELECT * FROM Users WHERE username = "' . $username .'"';
		$row = $this->db->query($query)->fetch_object();
		$profile["firstName"] = $row->FirstName;
		$profile["lastName"] = $row->LastName;
		return $profile;
	}

    public function get_users()
	{
		$query  = 'SELECT Id, firstName, lastName, email, phoneNumber FROM Users WHERE UserRole = "artisan"';
        $result = array();
		$result = $this->db->query($query)->fetch_all();
		return $result;
	}

    public function delete_user()
	{
        $userId = $_GET['userId'];
		$query  = 'DELETE FROM Users WHERE Id = "' . $userId  . '"';
        $this->db->query($query);
        return true;
	}

	private function authenticate_user() 
    {
		$query  = 'SELECT * FROM Users '
				. 'WHERE username = "' . $this->username . '" '
				. 'AND userPassword = "' . $this->userPassword . '"'
                . 'AND userRole = "admin"';

		return ($this->db->query($query)->fetch_object());
	}


}