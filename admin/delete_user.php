<?php require_once("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) { return redirect("login.php"); } ?>
<?php 
if(empty($_GET["user_id"])) {
    $session->message("Id does not exist!");
    return redirect("users.php");
} else {
    $user = User::find_by_id($database->escape_string($_GET["user_id"]));

    if($user) {
        if($user->delete()) {
            unlink($user->upload_directory. DS . $user->user_image);
        }

        $session->message("User <strong>{$user->username}</strong> has been deleted!");
        return redirect("users.php");
    } else {
        $session->message("User wasn't found!");
        return redirect("users.php");
    }
}



?>

