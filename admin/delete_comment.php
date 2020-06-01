<?php require_once("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) { return redirect("login.php"); } ?>
<?php 
if(!empty($_GET["comment_id"])) {
    $comment = Comment::find_by_id($database->escape_string($_GET["comment_id"]));

    if($comment) {
        if($comment->delete()) {
            $session->message("The comment has been deleted!");
            return redirect("comments.php");
        }
    } else {
        $session->message("Comment wasn't found!");
        return redirect("comments.php");
    }
} else if(!empty($_GET["delete_one"])) { 
    $comment = Comment::find_by_id($database->escape_string($_GET["delete_one"]));
    if($comment) {
        if($comment->delete()){
            $session->message("The comment has been deleted!");
            return redirect("comment_photo.php?photo_id={$comment->photo_id}");
        } else {
            $session->message("Comment wasn't found");
            return redirect("comment_photo.php?photo_id={$comment->photo_id}");
        }
    }
} else {
    $session->message("Comment wasn't found");
    return redirect("comments.php");
    
}

?>

