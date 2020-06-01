<?php include("includes/header.php"); ?>
<?php  if(!$session->is_signed_in()){ redirect("login.php"); } ?>

<?php 
if(isset($_FILES["file"])) {

    $photo = new Photo();
    $photo->title = $_POST["title"];
    $photo->description = $_POST["description"];
    $photo->set_file($_FILES["file"]);

    if($photo->save()){
        $message = "Photo uploaded successfully";
    } else {
        $message = join("<br>", $photo->errors);
    }
}

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
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
                            Upload
                            <small></small>
                        </h1>
                        <?php if(isset($message)) { echo $message; } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <form action="upload.php" enctype="multipart/form-data" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="title" class="form-control" placeholder="title">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="file">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="description" class="form-control" placeholder="description">
                                    </div>
                                    
                                    <input type="submit" name="submit" class="btn btn-primary">
                                </form>
                            </div>
                        </div> <!-- END OF ROW -->
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