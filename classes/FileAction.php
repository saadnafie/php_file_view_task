<?php

class FileAction {

	private $file_data;

	public function __construct($data){
		$this->file_data = $data;
	}

	public function nextPage(){
		if($_SESSION["current_page"] == $_SESSION["file_pages"]){
			$data['error'] = "This already lastPage";
			return $data;
		}else{
			$_SESSION["current_page"] = $_SESSION["current_page"] + 1;
			return $this->setNewPage($_SESSION["current_page"]); 
		}
	}

	public function previousPage(){
		if($_SESSION["current_page"] == 1){
			$data['error'] = "This already firstPage";
			return $data;
		}else{
			$_SESSION["current_page"] = $_SESSION["current_page"] - 1;
			return $this->setNewPage($_SESSION["current_page"]); 
		}
	}

	public function lastPage(){
		$_SESSION["current_page"] = $_SESSION["file_pages"];
		return $this->setNewPage($_SESSION["current_page"]); 
	}

	public function firstPage(){
		$_SESSION["current_page"] = 1;
		return $this->setNewPage($_SESSION["current_page"]); 
	}

	public function setNewPage($page_number){
		$current_page = $page_number-1;
		$data_line = [];
		$data = [];
		$lines = ($page_number == $_SESSION["file_pages"])?count($this->file_data):($current_page+1)*ConstantData::page_lines_number;
		for($i = $current_page*ConstantData::page_lines_number; $i < $lines; $i++){
			array_push($data, $this->file_data[$i]);
			array_push($data_line, $i+1);
		}
		$result['data'] = $data;
		$result['lines'] = $data_line;
		return $result;
	}
	
}