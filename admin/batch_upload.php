<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

<?php
//we are at http://localhost/OOP_gallery/admin/upload.php
$the_message = "";
//if(isset($_POST['submit'])){ //this is for single file upload without using dropzone
if(isset($_FILES['file'])){
    $photo = new Photo();
    $photo->title = $_POST['title'];
    echo "The title entered: {$_POST['title']}<br>";
    //echo "The file name is: {$_FILES['file_upload']}<br>";
    $photo->set_file($_FILES['file']); 

    // echo $photo->user_image."<br>"; //= basename($file['name']); 
    //     //returns the last level of a filepath
    // echo $photo->tmp_path."<br>"; //= $file['tmp_name'];
    // echo $photo->type."<br>";     //= $file['type'];
    // echo $photo->size."<br>";     //= $file['size'];

    if ($photo->save()) {
        $the_message = "Photo uploaded successfully.";
        echo "debug pt001A";
    } else {
        $the_message = join("<br>",$photo->errors);
        echo "debug pt001B";
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
                "Drag and Drop" Upload 
                <small>without a title entered to each photo</small>
            </h1>

            <div class="col-md-6">
                <?php echo $the_message; ?>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" class="form-control">   
                    </div>

                    <div class="form-group">
                        <input type="file" name="file_upload">    
                    </div>

                    <div class="form">
                        <input type="submit" name="submit">
                    </div>

                </form>


            
            <div class="row">
                <div class="col-lg-12">
                    <form action="upload.php" class="dropzone">
                        

                    </form>
                </div>   
            </div>
        </div>
    </div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>