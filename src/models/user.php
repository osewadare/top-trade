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


    public function __construct($db) {


		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		$this->db = $db;

		$this->update_messages();

		if (isset($_POST['login'])) {

			$this->login();
		}     
        elseif (isset($_POST['register'])) {

			$this->register();
		}
        elseif (isset($_POST['logout'])) {

			$this->logout();
		} 
		return $this;
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
				$_SESSION['username'] = $this->username;
				$_SESSION['email'] = $row->email;
				$_SESSION['is_logged'] = true;
				$this->is_logged = true;

				// Set a cookie that expires in one week
				if (isset($_POST['remember']))
					setcookie('username', $this->username, time() + 604800);

				// To avoid resending the form on refreshing
				header('Location: index.php');
				exit();

			} 
            else $this->error[] = 'Username or password incorrect.';

	}

	// Check if username and password match
	private function authenticate_user() {

		$query  = 'SELECT * FROM users '
				. 'WHERE username = "' . $this->username . '" '
				. 'AND userPassword = "' . $this->userPassword . '"';

		return ($this->db->query($query)->fetch_object());

	}

    public function register() {

		try{
			if ($_POST['password'] == $_POST['confirm']) {

				$username = $this->db->real_escape_string($_POST['email']);
				$userPassword = sha1($this->db->real_escape_string($_POST['password']));
				$firstName = $this->db->real_escape_string($_POST['firstName']);
				$lastName = $this->db->real_escape_string($_POST['lastName']);
				$email = $this->db->real_escape_string($_POST['email']);
				$phoneNumber = $this->db->real_escape_string($_POST['phoneNumber']);
				$address = $this->db->real_escape_string($_POST['address']);
				$userRole = "tradesman";
	
				$query  = "INSERT INTO users (username, userPassword, firstName, lastName, email, phoneNumber, address, userRole)
						VALUES ('$username', '$userPassword', '$firstName', '$lastName', '$email', '$phoneNumber', '$address', '$userRole')";
	
				echo $query;

				if ($this->db->query($query)) 
				{
					$this->msg[] = 'User signup successful.';
					$_SESSION['msg'] = $this->msg;
				}
				// To avoid resending the form on refreshing
				header('Location: ' . $_SERVER['REQUEST_URI']);
				exit();
	
			} 
			else $this->error[] = 'Passwords don\'t match.';
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
  
	}

    // Copy error & info messages from $_SESSION to the user object
	private function update_messages() {
		if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
			$this->msg = array_merge($this->msg, $_SESSION['msg']);
			$_SESSION['msg'] = '';
		}
		if (isset($_SESSION['error']) && $_SESSION['error'] != '') {
			$this->error = array_merge($this->error, $_SESSION['error']);
			$_SESSION['error'] = '';
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

	public function display_errors() {
		foreach ($this->error as $error) {
			echo '<p class="text-danger">' . $error . '</p>';
		}
	}

	public function display_info() {
		foreach ($this->msg as $msg) {
			echo '<p class="msg">' . $msg . '</p>';
		}
	}



}