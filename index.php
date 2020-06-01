<?php include("includes/header.php"); ?>
<?php 

$page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;

$items_per_page = 2;

$items_total_count = Photo::count_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos LIMIT {$items_per_page} OFFSET {$paginate->offset()}";
$photos = Photo::find_this_query($sql);

?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thumbnails row">
                <?php foreach($photos as $photo) : ?>
                    <div class="col-xs-6 col-md-3">
                        <div class="thumbnail">
                            <a href="photo.php?photo_id=<?php echo $photo->id; ?>">
                                <img class="img-responsive home_page_photo" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                            </a>    
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                
                <div class="row">
                    <ul class="pager">
                        <?php
                        if($paginate->page_total() > 1) {
                            if($paginate->has_next()) { 
                                echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                            } else {
                                echo "<li style='opacity: 0; cursor: default;' class='next'><a>Next</a></li>";
                            }

                            for($i = 1; $i <= $paginate->page_total(); $i++) {
                                if($i == $paginate->current_page) {
                                    echo "<li class='active'><a href='index.php?page={$paginate->current_page}'>{$paginate->current_page}</a></li>";
                                    
                                } else {
                                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                                }
                                
                            }
                            
                            if($paginate->has_previous()) {
                                echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                            } else {
                                echo "<li style='opacity: 0; cursor: default;' class='previous'><a>Previous</a></li>";
                            }
                        }
                        ?>
                        
                    </ul>
                </div>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4"> -->

        </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>
