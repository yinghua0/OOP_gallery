<?php 
require("init.php");
$user = new User();
if (isset($_POST['img_filename'])) {

	$user->ajax_save_user_image($_POST['img_filename'], $_POST['user_id']);
}

if (isset($_POST['photo_id'])) {
	//echo $_POST['photo_id'] . "It works";
	echo Photo::side_bar_data($_POST['photo_id']);
}


?>