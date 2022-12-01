<?php
// Initialize the session
session_start();

// Processing form data when form is submitted
//if($_SERVER["REQUEST_METHOD"] == "POST"){

	// Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if($username == "admin" && $password == "admin" ){

    // Store data in session variables
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;                            
    
    // Redirect user to welcome page
    header("location: index.php");
	}else{
		session_start();
		$_SESSION["login_err"] = "Invalid username or password.";
		header("location: login.php");
	}

//}