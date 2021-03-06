<?php require_once("includes/header.php") ?>

<?php
if($session->is_signed_in())
{
    redirect("index.php");
}

if(isset($_POST['submit']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //TODO: check db user
    $user_found = User::verify_user($username, $password);

    if($user_found)
    {
        $session->login($user_found);
        redirect("index.php");
    }
    else
    {
        $the_message = "Внесовте погрешно корисничко име или лозинка!";
    }
}
else
{
    $the_message = "";
    $username = "";
    $password = "";
}


?>

<div class="col-md-4 col-md-offset-3">

    <h4 class="bg-danger"><?php echo $the_message; ?></h4>

    <form id="login-id" action="" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?php htmlentities($username) ?>" >

        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="<?php htmlentities($password) ?>">

        </div>


        <div class="info-box-delete pull-left">
            <input type="submit" name="submit" value="Најава" class="btn btn-primary">
        </div>

        <div class="info-box-update pull-right">
            <a href="register.php" class="btn btn-danger"> Регистрирај се </a>
        </div>


    </form>


</div>
