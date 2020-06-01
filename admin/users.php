<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) { return redirect("login.php"); } ?>
<?php 
$users = User::find_all();
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
                            Users
                            <small></small>
                        </h1>
                        <p class="alert alert-success"><?php echo $message; ?></p>
                        <p class="alert alert-danger"><?php echo $message; ?></p>
                        <a href="add_user.php" class="btn btn-primary btn-lg">Add User</a>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                    </tr>
                                    <tbody>
                                        <?php 
                                            foreach($users as $user) {
                                                // printr($user);
                                        ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td>
                                                <img class="user-image" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="">
                                            </td>
                                            <td>
                                                <?php echo $user->username; ?>
                                                <div class="action_links">
                                                    <a href="edit_user.php?user_id=<?php echo $user->id; ?>">Edit</a>
                                                    <a href="delete_user.php?user_id=<?php echo $user->id; ?>">Delete</a>
                                                </div>
                                            </td>
                                            <td><?php echo $user->first_name; ?></td>
                                            <td><?php echo $user->last_name; ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </thead>
                            </table> <!-- END OF TABLE --> 
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>