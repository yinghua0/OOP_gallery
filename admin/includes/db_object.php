<?php


class Db_object {
//protected static $db_table = "users";
public $errors    = array(); 
public $upload_errors_array =array(
		UPLOAD_ERR_OK  => "There is no error in uploading to temporary file path.",
		UPLOAD_ERR_INI_SIZE  => "The uploaded_file exceeds the upload_max_filesize directive.",
		UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the MAX_FILE_SIZE.",
		UPLOAD_ERR_PARTIAL  => "The uploaded file was only partially loaded.",
		UPLOAD_ERR_NO_FILE  => "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR  => "Missing a temporary folder.",
		UPLOAD_ERR_CANT_WRITE  => "Failed to write file to disk.",
		UPLOAD_ERR_EXTENSION  => "A PHP extension stopped the file upload."
);


// $_FILES['filename'] has many attributes;
// set_file() is to give value of these attribute to the object's 
// correspondent attribute like $this->tmp_path, which will be 
// used in save_user_and_image();
public function set_file($file)
{
	if (empty($file) || !$file || !is_array($file)) {
		$this->errors[] = "There was no file uploaded here";
		return false;
	} elseif ($file['error']!=0){
		$this->errors[] =$this->upload_errors_array[$file['error']];
		return false;
	} else {
		$this->user_image = basename($file['name']);
		$this->filename = basename($file['name']); 
		//returns the last level of a filepath
		$this->tmp_path = $file['tmp_name'];
		$this->type     = $file['type'];
		$this->size     = $file['size'];
	}	
}


public static function find_all()
{
	return static::find_by_query("SELECT * FROM " . static::$db_table);
}

public static function find_by_id($id)
{
	global $database;
	$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id=$id");

	return !empty($the_result_array) ?  array_shift($the_result_array) : false;
					
}

public static function find_by_query($sql)
{
	global $database;
	$result_set = $database->query($sql);
	$the_object_array = array();
		
	while ($row = mysqli_fetch_array($result_set)) {
		$the_object_array[] = static::instantiation($row);
	}

	return $the_object_array;
}

public static function instantiation($the_record)
{
	//$user = new User(); wrong
	$calling_class = get_called_class();
   	$the_object = new $calling_class; //self means User class itself;

	foreach ($the_record as $the_attribute => $value) {
		if ($the_object->has_the_attribute($the_attribute)) {
			$the_object->$the_attribute = $value;
		}
	}

    return $the_object;
}

private function has_the_attribute($the_attribute)
{
	$object_properties = get_object_vars($this);
	return array_key_exists($the_attribute, $object_properties);
		
}

protected function pre_properties()
{
	//return get_object_vars($this);
	//global $database;
	$a = array();
	foreach (static::$db_table_fields as $db_field) {
		if (property_exists($this, $db_field)){
			//$clean_value = $database->escape_string($this->$db_field);
			//$a[$db_field] = $this->$db_field;
			$a[$db_field] = $this->$db_field;
		}
	}
	return $a;
}

protected function properties()
{
	global $database;
	$properties = array();
	foreach ($this->pre_properties() as $key => $value) {
		$properties[$key] = $database->escape_string($value);
	}
	return $properties;
}



public function save() 
{
		return isset($this->id) ? $this->update() : $this->create();
}

public function create(){
	global $database;

	$properties = $this->properties(); //$properties is an associated array whose keys are the attributes of the class of this object.

	$sql =  "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ") ";
	$sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

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
		//$value2 = $database->escape_string($value);
		$properties_pairs[] = "{$key}='{$value}'";
	}

	$sql = "UPDATE " . static::$db_table . " SET ";
	$sql .= implode(", ", $properties_pairs);
	$sql .= " WHERE id= " . $database->escape_string($this->id);

		
	$database->query($sql);
	return 	(mysqli_affected_rows($database->connection) ==1) ? true : false;
}

public function delete()
{
	global $database;
	$sql = "DELETE FROM " . static::$db_table . " WHERE ";
	$sql .= "id= " . $database->escape_string($this->id);
	$sql .= " LIMIT 1";
		
	$database->query($sql);
	return 	(mysqli_affected_rows($database->connection) ==1) ? true : false;	
}


public static function count_all()
{
	global $database;
	$sql = "SELECT COUNT(*) FROM " . static::$db_table;
	$result_set = $database->query($sql);
	$row = mysqli_fetch_array($result_set);
	return array_shift($row);
}



}//class Db_object

?>