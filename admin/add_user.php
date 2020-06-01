<?php include("includes/header.php"); ?>
<?php 
if(!$session->is_signed_in()){
    return redirect("login.php");
}

if(isset($_POST["create"])) {
    $user = new User();
    
    $user->username = $_POST["username"];
    $user->password = $_POST["password"];
    $user->first_name = $_POST["first_name"];
    $user->last_name = $_POST["last_name"];
    
    $user->set_file($_FILES["user_image"]);

    $user->upload_photo();
    $session->message("User <strong>{$user->username}</strong> has been created!");
    $user->save();
    redirect("users.php");
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
                        <form action="" enctype="multipart/form-data" method="POST">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" placeholder="title" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="user_image">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="Password" name="password" placeholder="password" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" placeholder="first name" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" placeholder="last name" value="" class="form-control">
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="create">
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

  <?php include("includes/footer.php"); ?>