<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php 

if(empty($_GET['id'])) {
  redirect("users.php");  
}

$user = User::find_by_id($_GET['id']);

if ($user) {
	$user->delete_user_image(); //the unlinking image file action;
    $user->delete(); 
    $session->message("The user {$user->username} has been deleted.");
    redirect("users.php"); 
} else {
	$session->message("The user {$user->username} was not found.");
    redirect("users.php");

}

?>