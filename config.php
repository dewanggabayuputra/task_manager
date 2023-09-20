<?php
class database { 
	var $host = "localhost";
	var $uname = "root";
	var $pass = "";
	var $db = "task_manager";
	public $con;
	
	function __construct(){
		try {
			$this->con = new PDO('mysql:host=localhost;dbname=task_manager', 'root', '');
		} catch (PDOException $e) {
			die("Database Connection Failed: " . $e->getMessage());
		}
	}
}

?>