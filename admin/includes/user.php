<?php

//require_once("new_config.php");

class User extends Db_object {

	protected static $db_table = "users";
	protected static $db_table_fields = array('username','password','first_name','last_name','user_image'); 
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	public $upload_directory = "images";
	public $image_placeholder = "http://placehold.it/400X400&text=image";

public function image_path_and_placeholder()
{
	return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;
}


public function delete_user_image(){
	if (!empty($this->user_image)) {
		$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory.DS.$this->user_image;
		return unlink($target_path) ? true : false;
	}
}


public function upload_photo()
{
	// if($this->id) {
	// 	$this->update();
	// } else {
		if (!empty($this->errors)) {
			return false;
		}
		if (empty($this->user_image) || empty($this->tmp_path)) {
			$this->errors[] = "the file is not available.";
			return false;	
		}
		$target_path = SITE_ROOT. DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;		
		if (file_exists($target_path)) {
			$this->errors[] = "This file {$this->user_image} already exists";
			return false;
		}

		if (move_uploaded_file($this->tmp_path, $target_path)){
			// if ($this->create()) {// comment out because save() is called 
			// right after upload_photo() is called.
				unset($this->tmp_path);
				return true;
			//}
		} else {
			$this->errors[] ="the file directory probably does not have permission";
			return false;
		}
	// }	
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
		$the_result_array = self::find_by_query("$sql");

		return !empty($the_result_array) ?  array_shift($the_result_array) : false; //ternary operation

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

/** This function content is not good for ajax.... because the purpose of ajax is
not to reload and go thru the whole page... but $this->save() does. So we redesign it.
public function ajax_save_user_image($user_image, $user_id)
{
	$this->user_image = $user_image;
	$this->id = $user_id;
	$this->save();
}**/
	

public function ajax_save_user_image($user_image, $user_id)
{
	global $database;
	$user_image = $database->escape_string($user_image);
	$user_id = $database->escape_string($user_id);
	$this->user_image = $user_image;
	$this->id = $user_id;
	$sql = "UPDATE " . self::$db_table . " SET ";
	$sql .= "user_image = '{$this->user_image}' ";
	$sql .= "WHERE id = {$this->id}"; // or id = '{$this->id}' ?
	$update_image = $database->query($sql);	

	echo $this->image_path_and_placeholder();

}





}//end of User


?>