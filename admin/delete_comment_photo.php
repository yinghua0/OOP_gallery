<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php 

if(empty($_GET['id'])) {
  redirect("comment_photo.php?id={$comment->photo_id}");  
}

$comment = Comment::find_by_id($_GET['id']);

if ($comment) {
	//$comment->delete_comment_image(); //the unlinking image file action;
    $comment->delete(); 
    $session->message("The comment with id= {$comment->id} has been deleted.");
    redirect("comment_photo.php?id={$comment->photo_id}"); 
} else {
	$session->message("The comment with id= {$comment->id} has been deleted.");
    redirect("comment_photo.php?id={$comment->photo_id}");   
}

?>