<?php include("includes/header.php"); ?>
<?php 
require_once("admin/includes/init.php");


if(empty($_GET["photo_id"])) {
    return redirect("index.php");
}

$photo = Photo::find_by_id($_GET["photo_id"]);


if(isset($_POST["submit"])){
    $author = trim($_POST["author"]);
    $body = trim($_POST["body"]);
    
    $new_comment = Comment::create_comment($photo->id, $author, $body);
    
    if($new_comment && $new_comment->save()) {
        
        // die("photo.php?photo_id={$photo->id}");
        
        redirect("photo.php?photo_id={$photo->id}");
    } else {
        $message = "There were some problmes saving.";
    }
}

$comments = Comment::find_the_comments($photo->id);

?>
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-12">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $photo->title; ?></h1>
                <?php 
                    if(isset($message)){
                        echo $message;
                    }
                ?>
                <!-- Author -->
                <p class="lead">
                    by <a href="#">Start Bootstrap</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="admin/<?php echo $photo->picture_path(); ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $photo->caption; ?></p>
                <p><?php echo $photo->description; ?></p>
                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="photo.php?photo_id=<?php echo $photo->id; ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="author" placeholder="author">
                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php foreach($comments as $comment): ?>
                <div class="media">

                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment->author; ?>
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        <?php echo $comment->body; ?>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4"> -->

                <!-- Blog Search Well -->
                <!-- <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div> -->
                    <!-- /.input-group -->
                <!-- </div> -->

                <!-- Blog Categories Well -->
                <!-- <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                    <!-- /.row -->
                <!-- </div> -->

                <!-- Side Widget Well -->
                <!-- <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div> -->

        </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>