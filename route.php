<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include ('classes/Auth.php');
include ('classes/FileScan.php');
include ('classes/FileAction.php');

$action = null;

if(isset($_POST['auth'])){
	$auth = new Auth();
	if($_POST['auth'] == "login"){
		if($auth->checkValidData($_POST["username"] , $_POST["password"])){
			$auth->login();
		}else{
			$_SESSION["login_err"] = "Invalid username or password.";
			header("location: login.php");
		}
	}else if($_POST['auth'] == "logout"){
		$auth->logout();
	}
}else if(isset($_POST['file_scan'])){
	if($_POST['file_scan'] == "openfile"){
		unset_session_data();
		$file = new FileScan();
		
		if($file->checkFile($_POST["file_path"])){
			$file->openFile();
			if($file->getLinesCount() > 0){
				$_SESSION["file_all_data"] = $file->getFile();
				$_SESSION["current_page"] = ConstantData::START_PAGE;  //$file->getCurrentPage();
				$_SESSION["file_pages"] = $file->getPagesNumber();
				$action = new FileAction($file->getFile());
				$_SESSION["data"] = $action->setNewPage(ConstantData::START_PAGE);
			}else{
				$_SESSION["no_data"] = "No data or lines in file";			}
		}else{
			$_SESSION["file_path_err"] = "Invalid file path";
		}

		header("location: index.php");
	}
}else if (isset($_POST['file_data'])) {
	$action = new FileAction($_SESSION["file_all_data"]);

	if($_POST['file_data'] == "next"){

		$data = $action->nextPage();
		if(!isset($data["error"]))
			$_SESSION["data"] = $data;
		echo json_encode($data);

	}else if($_POST['file_data'] == "previous"){

		$data = $action->previousPage();
		if(!isset($data["error"]))
			$_SESSION["data"] = $data;
		echo json_encode($data);

	}else if($_POST['file_data'] == "last"){

		$_SESSION["data"] = $action->lastPage();
		echo json_encode($_SESSION["data"]);
	
	}else if($_POST['file_data'] == "first"){
	
		$_SESSION["data"] = $action->firstPage();
		echo json_encode($_SESSION["data"]);
	}
	
}


function unset_session_data(){
	unset($_SESSION["file_all_data"]);
	unset($_SESSION["current_page"]);
	unset($_SESSION["file_pages"]);
	unset($_SESSION["data"]);
}