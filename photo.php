<?php include("includes/header.php"); ?>

<?php

//require_once("admin/includes/init.php");
//echo "<h1>".$_GET['id']."</h1>";
if (empty($_GET['id'])) {
    redirect("index.php");
}


$photo = Photo::find_by_id($_GET['id']);
//echo $photo->title;

if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);
    $new_comment = Comment::create_comment($photo->id, $author, $body);
    if ($new_comment && $new_comment->save()) {

        redirect("photo.php?id={$photo->id}");
    } else { 

        $message = "There were some saving problems.";
    }

} else {
    //necessary?
    $author = "";
    $body = "";
}

$comments = Comment::find_the_comment($photo->id);
// echo "<h1>".$a->id."</h1>";
// echo "<h1>".$a->id."</h1>";
// echo "<h1>".$a->id."</h1>";


// echo "<h1>".$photo->id."</h1>";


// $comments = Comment::find_by_id($photo->id);

?>


<div class="row">         
    <div class="col-lg-8">

        <!-- Blog Post -->

        <!-- Title -->
        <h1><?php echo $photo->title; ?></h1>

        <!-- Author -->
        <p class="lead">
            by <a href="#">Chung, the coder</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> Posted on March 16, 2016 at 9:00 PM</p>

        <hr>
        
        <?php echo SITE_ROOT.DS.'admin'.DS.$photo->picture_path(); ?>
        <!-- Preview Image -->
        <!-- img class="img-responsive" src="http://placehold.it/900x300" alt="" -->
        <img class="img-responsive" src="<?php echo 'admin'.DS.$photo->picture_path(); ?>">
        <hr>

        <!-- Post Content -->
        <p class="lead"><?php echo $photo->caption; ?></p>
        <p><?php echo $photo->description; ?></p>
        <hr>

        <!-- Blog Comments -->

        <!-- Comments Form -->




        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="aurthor">Author</label>
                    <input type="text" name="author" class="form-control">
                </div>


                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <hr>




        <!-- Posted Comments -->

        <?php foreach ($comments as $comment): ?>
    
        
        <!-- Comment -->
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="http://placehold.it/64x64" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">
                <?php echo $comment->author; ?>
                    <small>August 25, 2014 at 9:30 PM</small>
                    <small><?php echo date("l"); ?></small>
                </h4>
                <?php echo $comment->body; ?>
            </div>
        </div>

       
        <?php endforeach; ?>
    </div>

<!-- Blog Sidebar Widgets Column -->
   <!--  <div class="col-md-4"> -->

        
        <?php //include("includes/sidebar.php"); ?>


    <!-- </div> -->
</div>      
    <!-- /.row -->

    <?php include("includes/footer.php"); ?>
            