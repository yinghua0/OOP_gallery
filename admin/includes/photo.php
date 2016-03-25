<?php

class Photo extends Db_object {
	protected static $db_table = "photos";
	protected static $db_table_fields = array('id','title','caption','description','filename','alternate_text','type','size'); 
	public $id;
	public $title;
	public $caption;
	public $description;
	public $filename;
	public $alternate_text;
	public $type;
	public $size;
	public $tmp_path;
	public $upload_directory = "images";
	// the below: (copy from the htdocs/basic_files/upload.php, Section: 8 - Uploading Files)
	// the keys of $upload_errors_array() are possible values that   
	// $_FILES['error'] may have.
	// the above $errors is the new array we make in this method to have its values
	// as 1. the values of $upload_errors_array() and others message.
	

//This is passing $_FILES['uploaded_file'] as an argument
// public function set_file($_FILES['uploaded_file'] )


public function picture_path()
{
	return $this->upload_directory . DS . $this->filename;
}

public function save()
{
	if($this->id) {
		$this->update();
	} else {
		if (!empty($this->errors)) {
			return false;
		}
		if (empty($this->filename) || empty($this->tmp_path)) {
			$this->errors[] = "the file is not available.";
			return false;	
		}
		$target_path = SITE_ROOT. DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;		
		if (file_exists($target_path)) {
			$this->errors[] = "This file {$this->filename} already exists";
			return false;
		}

		if (move_uploaded_file($this->tmp_path, $target_path)){
			if ($this->create()) {
				unset($this->tmp_path);
				return true;
			}
		} else {
			$this->errors[] ="the file directory probably does not have permission";
			return false;
		}
	}	
}


public function delete_photo()
{
	if($this->delete()){
		//$target_path = SITE_ROOT. DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;
		$target_path = SITE_ROOT. DS . 'admin' . DS . $this->picture_path();
		return unlink($target_path) ? true : false;
	} else {
		return false;
	}
}


public static function side_bar_data($photo_id)
{
	$photo = Photo::find_by_id($photo_id);

	$output =  $photo->filename . "<br>"; //just try various ways.
	$output .= "{$photo->type}<br>";
	$output .= "{$photo->size}<br>";
	echo $output;
}


}

?>