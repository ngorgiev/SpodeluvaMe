<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
if(empty($_GET['id']))
{
    redirect("users.php");
}

$user = User::find_by_id($_SESSION['user_id']);

if($user->role != 'superadmin')
{
    redirect("index.php");
}

$user = User::find_by_id($_GET['id']);
if($user)
{
    if($user->role != 'superadmin')
    {
        if(User::check_user_role() != 'regular')
        {
            if($user->delete_photo())
            {
                $session->message("Корисникот {$user->username} беше успешно избришан");
            }
            else
            {
                $session->message("Корисникот {$user->username} НЕ беше успешно избришан");
            }

        }
        redirect("users.php");
    }
    else
    {
        $session->message("Немате доволно привилигии, за да го избришете корисникот {$user->username} !!");
        redirect("users.php");
    }

}
else
{
    redirect("users.php");
}
?>