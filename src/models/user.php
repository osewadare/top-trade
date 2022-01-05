<?php

class User {
    
    //Properties 
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phoneNumber;
    private $address;
    private $userRole;
    private $username;
    private $userPassword;

    private $db;
    private $is_logged = false;
    private $msg = array();
    private $error = array();


    public function __construct($db) 
	{
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		$this->db = $db;
	}

	public function register() 
	{
		try
		{
			if ($_POST['password'] == $_POST['confirm']) 
			{
				$username = $this->db->real_escape_string($_POST['email']);
				$userPassword = sha1($this->db->real_escape_string($_POST['password']));
				$firstName = $this->db->real_escape_string($_POST['firstName']);
				$lastName = $this->db->real_escape_string($_POST['lastName']);
				$email = $this->db->real_escape_string($_POST['email']);
				$phoneNumber = $this->db->real_escape_string($_POST['phoneNumber']);
				$address = $this->db->real_escape_string($_POST['address']);
				$userRole = "artisan";
				$ratingPin = rand(1000,1999);

				$query  = "INSERT INTO Users (username, userPassword, firstName, lastName, email, phoneNumber, address, userRole, ratingPin)
						VALUES ('$username', '$userPassword', '$firstName', '$lastName', '$email', '$phoneNumber', '$address', '$userRole', '$ratingPin')";
					
				if ($this->db->query($query)) 
				{
					$result['response'] = true;
					$result['message'] = 'Signup successful';
					return $result;
				}
				else{
					$result['response'] = false;
					$result['message'] = $query;
					return $result;
				}
	
			} 
			else $this->error[] = 'Passwords don\'t match.';
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
  
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
		$profile["email"] = $row->Email;
		$profile["phoneNumber"] = $row->PhoneNumber;
		$profile["address"] = $row->Address;
		$profile["hourlyRate"] = $row->HourlyRate;
		$profile["isAvailable"] = $row->isAvailable;
		$profile["cityId"] = $row->City;
		$profile["ratingPin"] = $row->RatingPin;
		$_SESSION['isAvailable'] = $row->isAvailable;
		return $profile;
	}

	public function get_username(){
		return $this->username;
	}

	public function update_profile()
	{

		$firstName = $this->db->real_escape_string($_POST['firstName']);
		$lastName = $this->db->real_escape_string($_POST['lastName']);
		$email = $this->db->real_escape_string($_POST['email']);
		$phoneNumber = $this->db->real_escape_string($_POST['phoneNumber']);
		$address = $this->db->real_escape_string($_POST['address']);
		$hourlyRate = $this->db->real_escape_string($_POST['hourlyRate']);
		$cityId = $this->db->real_escape_string($_POST['cityId']);

		$username = $_SESSION['username'];

		$query = "UPDATE Users SET firstName='$firstName', lastName='$lastName', 
				  email='$email', phoneNumber='$phoneNumber', address='$address', hourlyRate='$hourlyRate', city='$cityId'
				   WHERE username ='" . "$username " . "'";

		if($this->db->query($query))
		{
			$result['response'] = true;
			$result['message'] = 'Profile update successful';
			return $result;
		}
		else{
			$result['response'] = false;
			$result['message'] = 'Profile update failed';
			return $result;
		}
	}

	public function update_password()
	{

		$currentPassword = $this->db->real_escape_string($_POST['currentPassword']);
		$newPassword = $this->db->real_escape_string($_POST['newPassword']);
		$confirmPassword = $this->db->real_escape_string($_POST['confirmPassword']);

		if(empty($newPassword) || empty($confirmPassword)){
			$result['response'] = false;
			$result['message'] = 'All fields not filled';
			return $result;

		}

		if($newPassword != $confirmPassword){
			$result['response'] = false;
			$result['message'] = 'Passwords not matching';
			return $result;
		}

		$username = $_SESSION['username'];

		$query  = 'SELECT * FROM Users WHERE username = "' . $username .'"';
		$row = $this->db->query($query)->fetch_object();

		if($row->UserPassword != sha1($currentPassword)){
			$result['response'] = false;
			$result['message'] = 'Current Password incorrect';
		}
        
		$newPassword = sha1($newPassword);

		$query = "UPDATE Users SET userpassword='$newPassword'
				   WHERE username ='" . "$username " . "'";

		if($this->db->query($query))
		{
			$result['response'] = true;
			$result['message'] = 'Password change successful';
			return $result;
		}
		else{
			$result['response'] = false;
			$result['message'] = 'Password change failed';
			return $result;
		}
	}

    public function logout() {

		session_unset();
		session_destroy();
		$this->is_logged = false;
		setcookie('username', '', time()-3600);
		header('Location: index.php');
		exit();
	}

	public function is_logged() { return $this->is_logged; }

	private function authenticate_user() {

		$query  = 'SELECT * FROM Users '
				. 'WHERE username = "' . $this->username . '" '
				. 'AND userPassword = "' . $this->userPassword . '"'
				. 'AND userRole = "artisan"';

		return ($this->db->query($query)->fetch_object());

	}


}