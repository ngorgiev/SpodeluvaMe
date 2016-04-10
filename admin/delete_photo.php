<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
if(empty($_GET['id']))
{
    redirect("photos.php");
}
$photo = Photo::find_by_id($_GET['id']);
$user = User::find_by_id($_SESSION['user_id']);

if($photo)
{
    if($user->id == $photo->user_id || strpos(User::check_user_role(),'admin'))
    {
        $photo->delete_photo();
    }
    redirect("photos.php");
}
else
{
    redirect("photos.php");
}
?>