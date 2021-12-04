<?php

class User {
    
    //Properties 
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phoneNumber;
    private $address;
    private $role;
    private $username;
    private $password;

    private $db;
    private $is_logged = false;
    private $msg = array();
    private $error = array();


    public function __construct($db) {

		session_start();

		$this->db = $db;

		$this->update_messages();

		if (isset($_GET['login'])) {

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
			$this->password = sha1($this->db->real_escape_string($_POST['password']));

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
				header('Location: ' . $_SERVER['REQUEST_URI']);
				exit();

			} 
            else $this->error[] = 'Username or password incorrect.';

	}


	// Check if username and password match

	private function authenticate_user() {

		$query  = 'SELECT * FROM users '
				. 'WHERE user = "' . $this->username . '" '
				. 'AND password = "' . $this->password . '"';

		return ($this->db->query($query)->fetch_object());

	}


    public function register() {

        if ($_POST['password'] == $_POST['confirm']) {

            $username = $this->db->real_escape_string($_POST['username']);
            $password = sha1($this->db->real_escape_string($_POST['password']));
            $firstName = $this->db->real_escape_string($_POST['firstName']);
            $lastName = $this->db->real_escape_string($_POST['lastName']);
            $email = $this->db->real_escape_string($_POST['email']);
            $phoneNumber = $this->db->real_escape_string($_POST['phoneNumber']);
            $address = $this->db->real_escape_string($_POST['address']);
            $role = "tradesman";

            $query  = "INSERT INTO users (username, password, firstName, lastName, email, phoneNumber, address, role) '
                    . 'VALUES ('$username', '$password', '$firstName', '$lastName', '$email', '$phoneNumber', '$address', '$role')";

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


}