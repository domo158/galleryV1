<?php require_once("init.php"); ?>
<?php 
$photos = Photo::find_all();

?>

<div class="modal fade" id="photo-library">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">Close</button>
                        <h4 class="modal-title">Gallery System Library</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-9">
                            <div class="thumbnails row">
                                <!-- PHP LOOP HERE CODE HERE -->
                                <?php foreach($photos as $photo) : ?>
                                
                                <div class="col-xs-2">
                                    <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#" class="thumbnail">
                                        <img alt="" class="modal-thumbnails img-responsive" src="<?php echo $photo->picture_path(); ?>" data="<?php echo $photo->id; ?>">
                                    </a>
                                    <div class="photo-id hidden"></div>
                                </div>
                                
                                <!-- PHP LOOP HERE CODE HERE -->
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="modal_sidebar"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <button type="button" id="set_user_image" class="btn btn-primary" disabled>Apply Selection</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>