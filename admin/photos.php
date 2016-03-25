<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php
    
    $photos = Photo::find_all(); //initiation an array which filled data from database

?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<?php include("includes/top_nav.php"); ?>
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->    
<?php include("includes/side_nav.php"); ?>        

    
    <!-- /.navbar-collapse -->
</nav>




<div id="page-wrapper">

    <div class="container-fluid">
    <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <h1 class="page-header">
                Photos
                <small></small>
            </h1>
            <p class="bg-success"> <?php echo $message; ?> </p>
            </div>
            <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Id</th>
                    <th>File Name</th>
                    <th>Title</th>
                    <th>size</th>
                    <th>Comments</th>
                </tr>

                </thead>
                <tbody>

                <?php foreach ($photos as $photo) : ?>
                <tr>
                    <td><img class="admin-photo-thumnail" src="<?php echo $photo->picture_path(); ?>">
                    <div class="action_links">
                        <!--<a href="delete_photo.php/?id=<?php echo $photo->id; ?>">Delete</a>-->
                        <a class="delete_confirm" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
                        <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                        <a href="../photo.php?id=<?php echo $photo->id; ?>">View & Comment</a>
                    </div>
                    </td>
                    <td><?php echo $photo->id; ?></td>
                    <td><?php echo $photo->filename; ?></td>
                    <td><?php echo $photo->title; ?></td>
                    <td><?php echo $photo->size; ?></td>
                    <td>
                    <?php 
                    $comments = Comment::find_the_comment($photo->id);
                    $total = count($comments);
                    ?>
                    <a href="comment_photo.php?id=<?php echo $photo->id; ?>"><?php echo $total ?></a>
                    </td>



                </tr>
                <?php endforeach; ?>

                </tbody>

            </table>
            </div><!-- <div class="col-md-12"> -->
        </div>
    <!-- /.row -->
    </div>

    
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>