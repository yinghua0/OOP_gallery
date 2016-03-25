<?php

require_once("new_config.php");

class Database{

	public $connection;

	function __construct(){

		$this->open_db_connection();
	}

	public function open_db_connection()
	{
		//$this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

		//if (mysqli_connect_errno()){
		//	die("Database connection failed badly" . mysqli_error());
		//}
		if ($this->connection->connect_errno){
			die("Database connection failed badly: " . $this->connection->connect_error);
		}

	}

	public function query($sql)
	{
		//$result =mysqli_query($this->connection, $sql);
		$result = $this->connection->query($sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result)
	{
		if(!$result){
			//die("Query Failed" . mysqli_error($this->connection));
			die("Query Failed: " . $this->connection->error);	
		}

	}

	public function escape_string($string)
	{
		//$escaped_string = mysqli_real_escape_string($this->connection, $string);
		$escaped_string = $this->connection->real_escape_string($string);
		return $escaped_string;
	/*
	Object oriented style
		string mysqli::escape_string ( string $escapestr )
		string mysqli::real_escape_string ( string $escapestr )
	Procedural style
		string mysqli_real_escape_string ( mysqli $link , string $escapestr )
	This function is used to create a legal SQL string that you can use in an SQL statement. The given string is encoded to an escaped SQL string, taking into account the current character set of the connection.

	*/


	}

	public function the_insert_id()
	{
		//return mysqli_insert_id($this->connection);
		 
		// return $this->connection->insert_id;
		// Lec77 comment the last out and add the next line
		return mysqli_insert_id($this->connection);
	}
}

$database = new Database();






?>