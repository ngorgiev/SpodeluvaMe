<?php
require("init.php");

if($_POST['id'])
{
    $photo = Photo::find_by_id($_POST['id']);
    $photo_likes = $photo->likes;
    $photo_dislikes = $photo->dislikes;


    //calculates the numbers of like or dislike
    if($_POST['type'] == 1)
    {
        if(!isset($_SESSION['voted_photo'][$_POST['id']]))
        {
            if($session->is_signed_in())
            {
                $photo->like($photo->id);
                $_SESSION['voted_photo'][$_POST['id']] = true;
            }

        }

        echo  $photo->likes;
    }
    else
    {
        if(!isset($_SESSION['voted_photo'][$_POST['id']]))
        {
            if($session->is_signed_in())
            {
                $photo->dislike($photo->id);
                $_SESSION['voted_photo'][$_POST['id']] = true;
            }
        }

        echo  $photo->dislikes;
    }
}
?>