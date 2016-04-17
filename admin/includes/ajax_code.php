<?php
require("init.php");

$user = new User();
if(isset($_POST['image_name']))
{
    $user->ajax_save_user_image($_POST['image_name'], $_POST['user_id']);
}

if(isset($_POST['photo_id']))
{
    Photo::display_sidebar_data($_POST['photo_id']);
}


if($_POST['id'])
{
    $photo = Photo::find_by_id($_POST['id']);
    $photo_likes = $photo->likes;
    $photo_dislikes = $photo->dislikes;


    //calculates the numbers of like or dislike
    if($_POST['type'] == 1)
    {
        $photo->like($photo->id);
        echo  $photo->likes;
    }
    else
    {
        $photo->dislike($photo->id);
        echo  $photo->dislikes;
    }

}
?>