<?php

include ('ConstantData.php');

class FileScan {
	
	private $file;
	private $file_path;
	private $lines_count;
	private int $current_page;
	private int $pages_number;

	public function checkFile($path){
		if(file_exists($path)){
			$this->file_path = $path;
			return true;
		}else
			return false;
	}

	public function openFile(){
			$this->file = file($this->file_path);	
			$this->setLinesCount();
			$this->setPageNumber();
	}

	public function setLinesCount(){
		$this->lines_count = count($this->file);
	}

	public function getLinesCount(){
		return $this->lines_count;
	}

	public function getCurrentPage(){
		return $this->current_page;
	}

	function setPageNumber(){
		$this->pages_number = round(($this->lines_count /ConstantData::page_lines_number),0,PHP_ROUND_HALF_UP);
	}

	public function getPagesNumber(){
		return $this->pages_number;
	}

	public function getFile(){
		return $this->file;
	}

	public function changePage($page_number){
		$this->current_page = $page_number-1;
		$result = [];
		for($i = $this->current_page*ConstantData::page_lines_number; $i < ($this->current_page+1)*ConstantData::page_lines_number; $i++){
			array_push($result, $this->file[$i]);
		}
		return $result;
	}
}