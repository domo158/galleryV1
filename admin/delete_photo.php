<?php require_once("includes/init.php"); ?>

<?php  

if(!$session->is_signed_in()){
    return redirect("../login.php");
}

if(empty($_GET["photo_id"])) {
    $session->message("No photo selected!");
    return redirect("photos.php");
}

$photo = Photo::find_by_id($_GET["photo_id"]);

if($photo) {
    $photo->delete_photo();
    $session->message("The Photo has been deleted!");
    redirect("photos.php");
} else {
    $session->message("Photo wasn't found!");
    redirect("photos.php");
}



?>
