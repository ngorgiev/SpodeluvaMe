<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
if(empty($_GET['id']))
{
    redirect("comments.php");
}
$comment = Comment::find_by_id($_GET['id']);
if($comment)
{
    if(strpos(User::check_user_role(),'admin'))
    {
        $comment->delete();
        $session->message("Коментарот беше успешно избришан.");
    }
    //redirect("comments.php");
}
else
{
    redirect("comments.php");
}
?>