<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
//TODO ако е админ покажи опција за приказ на сите, или приказ на само мои
if(strpos(User::check_user_role(),'admin'))
{
    if(isset($_GET['by_user']))
    {
        $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_GET['by_user']}");
    }
    else
    {
        $photos = Photo::find_all();
    }

}
else
{
    $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_SESSION['user_id']}");
}

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
                        Менаџирање на Слики
                    </h1>

                    <a href="upload.php" class="btn btn-primary">Додади Нова Слика</a>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Слика</th>
                                    <th>Id</th>
                                    <th>Автор</th>
                                    <th>Име</th>
                                    <th>Нслов</th>
                                    <th>Големина</th>
                                    <th>Коментари</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($photos as $photo) : ?>
                                <tr>
                                    <td><img class="admin-photo-thumbnail" src="<?php echo $photo->picture_path(); ?>" alt="">
                                        <div class="action_links">
                                            <a class="delete_photo" href="delete_photo.php?id=<?php echo $photo->id; ?>">Избриши</a>
                                            <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Измени</a>
                                            <a href="../photo.php?id=<?php echo $photo->id; ?>">Прегледај</a>
                                        </div>
                                    </td>
                                    <td><?php echo $photo->id; ?></td>
                                    <td>
                                        <?php $photo_author = User::find_by_id($photo->user_id); ?>
                                        <a href="photos.php?by_user=<?php echo $photo->user_id; ?>">
                                            <?php echo $photo_author ? $photo_author->username : "Непознат"; ?>
                                        </a>





                                    </td>
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <td>
                                        <a href="comment_photo.php?id=<?php echo $photo->id?>">
                                        <?php
                                        $comments = Comment::find_comments_by_photo_id($photo->id);
                                        echo count($comments);
                                        ?>
                                        </a>
                                    </td>
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