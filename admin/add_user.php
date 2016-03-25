<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php

    $user = new User();
    // $user = user::find_by_id($_GET['id']);
    if(isset($_POST['create'])){
        echo "<h1>hello</h1>";
       if ($user) {
        // $user->user_image = $_FILES['user_image'];
        echo $user->username    = $_POST['username'];
        $user->password= $_POST['password'];
        $user->first_name= $_POST['first_name'];
        $user->last_name= $_POST['last_name'];

        $user->set_file($_FILES['user_image']);//this is required b4 calling save_user_and_image().
        // $user->save_user_and_image(); this has been changed and does not exist.
        $user->upload_photo();
        $user->save();
        $session->message("The user with username {$user->username} is added.");
        redirect("users.php");
       }
    }



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
                User
            </h1>
            </div> <!--end class="col-lg-12"-->

            <form action="" method="post" enctype="multipart/form-data">
            
            <!--main section-->
            <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <label for="user_image">User image</label>
                <input type="file" name="user_image">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            
            <div class="form-group">
                <label for ="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for ="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control">
            </div>
            <div class="form-group">
                <label for ="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" name="create" class="btn btn-primary pull-right">
            </div>

            </div> <!--end class="col-lg-8"-->

            </form><!-- /<form action="edit_user.php" method="post"> -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

</div><!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>