<?php include("includes/header.php"); ?>
<?php 
if(!$session->is_signed_in()){
    return redirect("login.php");
}

if(empty($_GET["user_id"])){
    return redirect("users.php");
} else {
    $user = User::find_by_id($database->escape_string($_GET["user_id"]));
    if(!$user) {
        return redirect("users.php");
    }
}
if(isset($_POST["update"])) {
    if($user) {
        $user->username = $_POST["username"];
        $user->password = $_POST["password"];
        $user->first_name = $_POST["first_name"];
        $user->last_name = $_POST["last_name"];
       

        if(empty($_FILES["user_image"]["name"])){
            $user->save();
            $session->message("The user has beenn updated!");
            return redirect("users.php");
        } else {
           
            if(file_exists($user->upload_directory . DS . $user->user_image)){
                unlink($user->upload_directory . DS . $user->user_image);
            }
            $user->set_file($_FILES["user_image"]);
                $user->upload_photo();
                $user->save();
                $session->message("User and user image updated!");
                return redirect("users.php"); 

        }
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
                            Photos
                            <!-- <small>Subheading</small> -->
                        </h1>
                        <div class="col-md-6">
                            <a href="#" data-toggle="modal" data-target="#photo-library">
                                <img class="img-responsive" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="">
                            </a>
                        </div>
                        <form action="" enctype="multipart/form-data" method="POST">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" placeholder="title" value="<?php echo $user->username; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="user_image">
                                        <img class="user-image" src="<?php // echo $user->upload_directory . DS . $user->user_image; ?>" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="Password" name="password" placeholder="password" value="<?php echo $user->password; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" placeholder="first name" value="<?php echo $user->first_name; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" placeholder="last name" value="<?php echo $user->last_name; ?>" class="form-control">
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="update" value="Update">
                                    <a id="user-id" class="btn btn-danger pull-right" href="delete_user.php?user_id=<?php echo $user->id; ?>">Delete</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <!-- PHOTO LIBRARY MODAL -->
        <?php include("includes/photo_library_modal.php"); ?>

  <?php include("includes/footer.php"); ?>