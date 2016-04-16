<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
if(empty($_GET['id']))
{
    redirect("photos.php");
}
$comments_for_user = array();
$all_user_photo_ids = array();
if(strpos(User::check_user_role(),'admin'))
{
    $user_photos = Photo::find_all();
}
else
{
    $user_photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_SESSION['user_id']}");
}
foreach($user_photos as $user_photo)
{
    $all_user_photo_ids[] = $user_photo->id;
}

foreach($all_user_photo_ids as $photo_id)
{
    if($photo_id == $_GET['id'])
    {
        $comments = Comment::find_comments_by_photo_id($_GET['id']);
    }
}

if(!$comments)
{
    redirect("photos.php");
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
                        Менаџирање на Коментари
                    </h1>

                    <p class="bg-success">
                        <?php echo $message; ?>
                    </p>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Автор</th>
                                <th>Коментар</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo $comment->id; ?></td>
                                    <td><?php echo $comment->author; ?>
                                        <?php
                                        if(strpos(User::check_user_role(),'admin')) {
                                            $delete_link = "<div class='action_links'>";
                                            $delete_link .= "<a class='delete_comment' href='delete_comment_photo.php?id={$comment->id}'>Избриши</a></div>";

                                            echo $delete_link;
                                        }

                                    ?>
                                    </td>
                                    <td><?php echo $comment->body; ?></td>
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