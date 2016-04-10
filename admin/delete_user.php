<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
if(empty($_GET['id']))
{
    redirect("users.php");
}
$user = User::find_by_id($_GET['id']);
if($user)
{
    if($user->role != 'superadmin')
    {
        if(User::check_user_role() != 'regular')
        {
            $user->delete();
        }
        redirect("users.php");
    }
    else
    {
        echo "Корисникот {$user->username} неможе да се избрише!";
        echo "<a href='users.php'> Врати се назад.</a>";
    }

}
else
{
    redirect("users.php");
}
?>