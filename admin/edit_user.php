<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php

if (empty($_GET['id'])) {
   redirect("users.php");
} else {
    $user = User::find_by_id($_GET['id']);
    if(isset($_POST['update'])){
       if ($user) {
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->first_name= $_POST['first_name'];
        $user->last_name= $_POST['last_name'];

        if (empty($_FILES['user_image'])){
            $user->save();
            $session->message("The user has been upadted.");
            redirect("users.php");

        } else {
            // $user->delete_user_image(); we'd better to keep old 
            // pictures for user to choose later on. 
            $user->set_file($_FILES['user_image']);
            $user->upload_photo();
            $user->save();
            // redirect("edit_user.php?id={$user->id}");
            $session->message("The user has been upadted. The photo included");
            redirect("users.php");
            
        }

       }
    }
    // if(isset($_POST['delete'])){
    //     echo "<h1>  HHHHH  </h1>";
    //     if ($user) {
    //         unlink($user->image_path_and_placeholder());
    //         $user->delete();
    //         redirect("users.php");
    //     }
    // }    

}

    // $user = user::find_by_id($_GET['id']);
    // if(isset($_POST['create'])){
    //     if ($user) {
    //     // $user->user_image = $_FILES['user_image'];
    //     echo $user->username    = $_POST['username'];
    //     $user->password= $_POST['password'];
    //     $user->first_name= $_POST['first_name'];
    //     $user->last_name= $_POST['last_name'];

    //     $user->set_file($_FILES['user_image']);//this is required b4 calling save_user_and_image().
    //     $user->save_user_and_image();
    //    }
    // }

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

            <div class="col-md-6 user_image_box">
                <a href="#" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $user->image_path_and_placeholder(); ?>"  alt=""></a>

            </div>

            <form action="" method="post" enctype="multipart/form-data">
            
            <!--main section-->
            <div class="col-md-6">
            <div class="form-group">
                <label for="user_image">User image</label>
                <input type="file" name="user_image">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
            </div>
            
            <div class="form-group">
                <label for ="password">Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
            </div>
            <div class="form-group">
                <label for ="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
            </div>
            <div class="form-group">
                <label for ="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
            </div>

            <div class="form-group">
                <a id="user-id" href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger pull-left delete_confirm">Delete</a>
                <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
            </div>

            </div> <!--end class="col-lg-6"-->

            </form><!-- /<form action="edit_user.php" method="post"> -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

</div><!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>