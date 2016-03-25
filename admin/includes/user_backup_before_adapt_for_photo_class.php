<?php

//require_once("new_config.php");

class User {

	protected static $db_table = "users";
	protected static $db_table_fields = array('username','password','first_name','last_name'); 
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;


	public static function find_all_users()
	{
		return self::find_this_query("SELECT * FROM " . self::$db_table);
		//global $database;
		//$result_set = $database->query("SELECT * FROM users");
		//return $result_set;
	}

	public static function find_user_by_id($user_id)
	{
		//global $database;
		//$result = $database->query("SELECT * FROM users WHERE id=$user_id");
		//  $result = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id=$user_id");
		//  $found_user = mysqli_fetch_array($result);
		//  return $found_user;
		$the_result_array = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id=$user_id");

		return !empty($the_result_array) ?  array_shift($the_result_array) : false;
			//array_pop() take out from the end.  array_shift() take out from the beginning. 
		
	}

	/*public static function find_this_query($sql)
	{
		global $database;
		$result_set = $database->query($sql);
		return $result_set;
	}*/

	public static function find_this_query($sql)
	{
		global $database;
		$result_set = $database->query($sql);
		$the_object_array = array();
		//$row is a single record from the lump sum $result_set returned from sql
		//the following change sql data to objects $row by $row
		while ($row = mysqli_fetch_array($result_set)) {
			$the_object_array[] = self::instantiation($row);
		}

		return $the_object_array;
	}

	public static function verify_user($username, $password)
	{
		global $database;
		//sanitizing/clean data
		$username = $database->escape_string($username);
		$password = $database->escape_string($password);
		$sql = "SELECT * FROM " . self::$db_table . " WHERE ";
		$sql .= "username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		//NOW WE WANT TO RETURN THE DATA WE NEED BUT IT SEEMS 
		//NO WAY TO DIRECTLY USE find_user_by_id(), so 
		//let's copy paste from its inside.
		$the_result_array = self::find_this_query("$sql");

		return !empty($the_result_array) ?  array_shift($the_result_array) : false; //ternary operation

	}


	public static function instantiation($the_record)
	{
		//$user = new User(); wrong
		$the_object = new self; //self means User class itself;
		// $the_object->id       = $found_user['id'];
  //       $the_object->username = $found_user['username'];
  //       $the_object->password = $found_user['password'];
  //       $the_object->first_name=$found_user['first_name'];
  //       $the_object->last_name= $found_user['last_name'];
		foreach ($the_record as $the_attribute => $value) {
			if ($the_object->has_the_attribute($the_attribute)) {
				$the_object->$the_attribute = $value; 
				// now we are borrowing the name of the keys in $the_record
				// so $the_object->$the_attribute is correct ... It stands for 
				// $the_object->id, $the_object->username, ....
			}
		}

        return $the_object;
	}

	private function has_the_attribute($the_attribute)
	{
		$object_properties = get_object_vars($this);
		return array_key_exists($the_attribute, $object_properties);
		//if the_attribute (a key in the_record) exists in $object_properties
		// the function will return true.
	}

	protected function properties()
	{
		//return get_object_vars($this);
		global $database;
		$a = array();
		foreach (self::$db_table_fields as $db_field) {
			if (property_exists($this, $db_field)){
				$clean_value = $database->escape_string($this->$db_field);
				//$a[$db_field] = $this->$db_field;
				$a[$db_field] = $clean_value;
			}
		}
		return $a;
	}



	public function save() 
	{
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create(){
		global $database;

		$properties = $this->properties(); //$properties is an associated array whose keys are the attributes of the class of this object.

		$sql =  "INSERT INTO " . self::$db_table . " (" . implode(",", array_keys($properties)) . ") ";
		$sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

		// $sql =  "INSERT INTO " . self::$db_table . " (username, password, first_name, last_name) ";
		// $sql .= "VALUES ('";
		// $sql .= $database->escape_string($this->username) . "', '";
		// $sql .= $database->escape_string($this->password) . "', '";
		// $sql .= $database->escape_string($this->first_name) . "', '";
		// $sql .= $database->escape_string($this->last_name) . "')";

		if ($database->query($sql)) {

			$this->id = $database->the_insert_id();
			return true;
		} else {
			return false;
		}
	}//end of Create method

	public function update()
	{
		global $database;

		$properties = $this->properties();
		$properties_pairs =array();
		foreach ($properties as $key => $value) {
			$value2 = $database->escape_string($value);
			$properties_pairs[] = "{$key}='{$value2}'";
		}


		$sql = "UPDATE " . self::$db_table . " SET ";
		$sql .= implode(", ", $properties_pairs);
		$sql .= " WHERE id= " . $database->escape_string($this->id);
		# code...
		// $sql = "UPDATE " . self::$db_table . " SET ";
		// $sql .= "username= '" . $database->escape_string($this->username) . "', ";
		// $sql .= "password= '" . $database->escape_string($this->password) . "', ";
		// $sql .= "first_name= '" . $database->escape_string($this->first_name) . "', ";
		// $sql .= "last_name= '" . $database->escape_string($this->last_name) . "' ";
		// $sql .= " WHERE id= " . $database->escape_string($this->id);
		
		$database->query($sql);
		return 	(mysqli_affected_rows($database->connection) ==1) ? true : false;
	}

	public function delete()
	{
		global $database;
		$sql = "DELETE FROM " . self::$db_table . " WHERE ";
		// $sql .= "username= '" . $database->escape_string($this->username) . "' AND ";
		// $sql .= "password= '" . $database->escape_string($this->password) . "' AND ";
		// $sql .= "first_name= '" . $database->escape_string($this->first_name) . "' AND ";
		// $sql .= "last_name= '" . $database->escape_string($this->last_name) . "' AND ";
		$sql .= "id= " . $database->escape_string($this->id);
		$sql .= " LIMIT 1";
		
		$database->query($sql);
		return 	(mysqli_affected_rows($database->connection) ==1) ? true : false;	
	}



}//end of User


?>