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
    if(isset($_GET['change_to_private']))
    {
        $photo_to_make_private = $database->escape_string($_GET['change_to_private']);
        $query = "UPDATE photos SET photo_status = 'private' WHERE id = {$photo_to_make_private}";
        $database->query($query);
        $session->message("успех");
        redirect("photos.php");
    }
    elseif(isset($_GET['change_to_public']))
    {
        $photo_to_make_public = $database->escape_string($_GET['change_to_public']);
        $query = "UPDATE photos SET photo_status = 'public' WHERE id = {$photo_to_make_public}";
        $database->query($query);
        $session->message("успех");
        redirect("photos.php");
    }
}
else
{
    $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_SESSION['user_id']}");
    if(isset($_GET['change_to_private']))
    {
        $photo_to_make_private = $database->escape_string($_GET['change_to_private']);
        $query = "UPDATE photos SET photo_status = 'private' WHERE id = {$photo_to_make_private}";
        $database->query($query);
        $session->message("успех");
        redirect("photos.php");
    }
    elseif(isset($_GET['change_to_public']))
    {
        $photo_to_make_public = $database->escape_string($_GET['change_to_public']);
        $query = "UPDATE photos SET photo_status = 'public' WHERE id = {$photo_to_make_public}";
        $database->query($query);
        $session->message("успех");
        redirect("photos.php");
    }
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
                                    <th>Прикачено</th>
                                    <th>Коментари</th>
                                    <th>Видлива</th>
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
                                    <td><?php echo $photo->get_formated_size(); ?></td>
                                    <td><?php echo date('d/m/Y H:i',strtotime($photo->upload_date)); ?></td>
                                    <td>
                                        <a href="comment_photo.php?id=<?php echo $photo->id?>">
                                        <?php
                                        $comments = Comment::find_comments_by_photo_id($photo->id);
                                        echo count($comments);
                                        ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        $published = $photo->photo_status == 'public' ? true : false;
                                        if($published)
                                        {
                                            $published_class = "glyphicon glyphicon-ok";
                                            echo "<a href='photos.php?change_to_private=$photo->id'>";
                                        }
                                        else
                                        {
                                            $published_class = "glyphicon glyphicon-remove";
                                            echo "<a href='photos.php?change_to_public=$photo->id'>";
                                        }
                                        ?>

                                        <div class="<?php echo $published_class; ?>"></div>
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