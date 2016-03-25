<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php
    
    $comments = Comment::find_all(); //initiation an array which filled data from database

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
            All Comments
        </h1>
        <small>Comments are entered in "view" page from Photos.</small>
        <p class="bg-success"> <?php echo $message; ?> </p>
        <!-- a href="add_comment.php" class="btn btn-primary">Add comment</a -->
        </div>
        

        <div class="col-md-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Body</th>
            </tr>

            </thead>
        <tbody>

        <?php foreach ($comments as $comment) : ?>
        <tr>
            <td><?php echo $comment->id; ?></td>            
            <td><?php echo $comment->author; ?>
                <div class="action_links">
                <!--<a href="delete_user.php/?id=<?php echo $comment->id; ?>">Delete</a>-->
                <a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a>
                
            </div>

            </td>
            <td><?php echo $comment->body; ?></td>
        </tr>
        <?php endforeach; ?>

        </tbody>

        </table>
        </div><!-- <div class="col-md-12"> -->
        </div><!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>