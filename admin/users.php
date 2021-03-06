<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
$user = User::find_by_id($_SESSION['user_id']);
if($user->role != 'superadmin')
{
    redirect("index.php");
}

$users = User::find_all();
?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <?php include("includes/top_nav.php") ?>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <?php include("includes/side_nav.php")?>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Менаџирање на Корисници
                    </h1>
                    <p class="bg-success">
                        <?php echo $message; ?>
                    </p>

                    <a href="add_user.php" class="btn btn-primary">Додади Нов Корисник</a>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Слика</th>
                                <th>Корисничко Име</th>
                                <th>Име</th>
                                <th>Презиме</th>
                                <th>Улога</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user->id; ?></td>
                                    <td><img class="admin-user-thumbnail user_image" src="<?php echo $user->image_path_and_placeholder(); ?>" alt=""></td>
                                    <td><?php echo $user->username; ?>
                                        <div class="action_links">
                                            <a class="delete_user" href="delete_user.php?id=<?php echo $user->id; ?>">Избриши</a>
                                            <a href="edit_user.php?id=<?php echo $user->id; ?>">Измени</a>
                                        </div>
                                    </td>
                                    <td><?php echo $user->first_name; ?></td>
                                    <td><?php echo $user->last_name; ?></td>
                                    <td><?php echo $user->role; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>