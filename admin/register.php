<?php include("includes/header.php"); ?>
<?php if($session->is_signed_in()) {redirect("index.php");} ?>

<?php

if(isset($_POST['submit']))
{

    $new_username = $database->escape_string($_POST['username']);
    $new_password= $database->escape_string($_POST['password']);

    if(!empty($new_username) && !empty($new_username))
    {
        $users_with_username = User::find_by_query("SELECT * FROM users WHERE username='$new_username'");

        if(count($users_with_username) > 0)
        {
            $session->message("Корисник со корисничко име {$new_username} веќе постои");
            redirect("register.php");
        }
        else
        {
            $new_user = new User();
            $new_user->username = $new_username;
            $new_user->password = $new_password;

            $new_user->first_name = $database->escape_string($_POST['first_name']);
            $new_user->last_name = $database->escape_string($_POST['last_name']);
            $new_user->role = 'regular';
            $new_user->create();
            redirect("login.php");
        }
    }

}
?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-md-12 col-md-offset-3">
                    <h1 class="page-header">
                        Регистрациј на нов Корисник
                    </h1>
                    <p class="bg-success">
                        <?php echo $message; ?>
                    </p>
                    <form action="register.php" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for=username">Корисничко Име</label>
                                <input type="text" name="username" class="form-control" value="">
                            </div>

                            <div class="form-group">
                                <label for="first_name">Име</label>
                                <input type="text" name="first_name" class="form-control" value="">
                            </div>

                            <div class="form-group">
                                <label for="last_name">Презиме</label>
                                <input type="text" name="last_name" class="form-control" value="">
                            </div>

                            <div class="form-group">
                                <label for="password">Лозинка</label>
                                <input type="password" name="password" class="form-control" value="">
                            </div>

                            <div class="info-box-update pull-left">
                                <a href="login.php" class="btn btn-danger"> Логирај се </a>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Регистрирај">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->