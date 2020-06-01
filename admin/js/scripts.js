$(document).ready(function(){
    var user_href;
    var user_href_splitted;
    var user_id;
    var image_src;
    var image_src_splitted;
    var image_name;
    var photoId;




    $(".modal-thumbnails").click(function(){
        $("#set_user_image").prop("disabled", false);
        // Get user id from delete btn link
        // get link
        user_href = $("#user-id").prop("href");
        // split the link by the " = ", then you got an array ["http://localhost/phpoop/gallery/admin/delete_user.php?user_id", "21"]
        user_href_splitted = user_href.split("=");
        // asign the array to the user-id variable, use the length of the array as the position -1
        user_id = user_href_splitted[user_href_splitted.length -1]; // user-id = 21
        
        image_src = $(this).prop("src");
        // console.log(image_src + "\n");
        image_src_splitted = image_src.split("/");
        // console.log(image_src_splitted + "\n");
        image_name = image_src_splitted[image_src_splitted.length - 1];
        // console.log(image_name);
        // alert(image_id);

        photoId = $(this).attr("data");

        $.ajax({
            url: "includes/ajax_code.php",
            data: {photo_id: photoId},
            type: "POST",
            success: function(data) {
                if(!data.error) {
                    $(".modal_sidebar").html(data);
                    // console.log(data);
                }
            }
        });

    });

    $("#set_user_image").click(function(){ 
        $.ajax({
            url: "includes/ajax_code.php",
            data: {image_name: image_name, user_id:user_id},
            type: "POST",
            success: function(data) {
                if(!data.error) {
                    // console.log(data);
                    location.reload(true); // wipes the input fields! not good

                    // $(".user_image_box a img").prop("src", data);
                }
            }
        });
    });

    // ******************* EDIT PHOTO SIDEBAR *******************
    $(".info-box-header").click(function(){
        $(".inside").slideToggle("fast");
        // $("#toggle").toggleClass("glyphicon glyphicon-menu-down, glyphicon glyphicon-menu-up");
        $("#toggle").toggleClass("glyphicon-menu-down");
        $("#toggle").toggleClass("glyphicon-menu-up");
    });

    
    // ********************** DELETE FUNCTION ***************
    $(".delete_link").click(function(){
        return confirm("Are you sure you want to delete this photo?");
    });











    tinymce.init({
        selector: '#mytextarea'
    });
});


