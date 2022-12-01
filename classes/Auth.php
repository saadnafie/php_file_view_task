<?php

class Auth{

	const USERNAME = "admin";
	const PASSWORD = "admin";

	private $username;
	private $password;
	
	public function __construct(){
		session_start();
	}

	public function checkValidData($username,$password){
		$this->username = trim($username);
		$this->password = trim($password);
		if($this->username == self::USERNAME && $this->password == self::PASSWORD)
			return true;
		else 
			return false;
			
	}

	public function login(){
		// Store data in session variables
	    $_SESSION["loggedin"] = true;
	    $_SESSION["username"] = $username;                            
	    
	    // Redirect user to welcome page
	    header("location: index.php");
	}

	public function logout(){
		// Unset all of the session variables
		$_SESSION = array();
		 
		// Destroy the session.
		session_destroy();
		 
		// Redirect to login page
		header("location: login.php");
		exit;
	}
}