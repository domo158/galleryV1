<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) { return redirect("login.php"); } ?>
<?php 
if(empty($_GET["photo_id"])) {
    return redirect("photos.php");
}

$comments = Comment::find_the_comments($_GET["photo_id"]);
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
                            Comments for Photo ID:<?php echo $_GET["photo_id"]; ?>
                        </h1>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                        <div class="alert alert-danger"><?php echo $message; ?></div>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Author</th>
                                        <th>Body</th>
                                    </tr>
                                    <tbody>
                                        <?php 
                                            foreach($comments as $comment) {
                                                // printr($user);
                                        ?>
                                        <tr>
                                            <td><?php echo $comment->id; ?></td>
                                            <td>
                                                <?php $photo = Photo::find_by_id($comment->photo_id); ?> 
                                                <a href="../photo.php?photo_id=<?php echo $comment->photo_id; ?>">
                                                    <img class="user-image" src="<?php echo $photo->picture_path(); ?>" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $comment->author; ?>
                                                <div class="action_links">
                                                    <a href="delete_comment.php?delete_one=<?php echo $comment->id; ?>">Delete</a>
                                                </div>
                                            </td>
                                            <td><?php echo $comment->body; ?></td>
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