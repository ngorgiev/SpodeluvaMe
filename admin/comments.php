<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
$comments_for_user = array();
if(!strpos(User::check_user_role(),'admin'))
{
    $all_user_photo_ids = array();
    $user_photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_SESSION['user_id']}");
    foreach($user_photos as $user_photo)
    {
        $all_user_photo_ids[] = $user_photo->id;
    }

    foreach($all_user_photo_ids as $photo_id)
    {
        $comments_for_user = array_merge($comments_for_user,Comment::find_by_query("SELECT * FROM comments WHERE photo_id = {$photo_id}"));
    }
   $comments = $comments_for_user;

}
else
{
    $comments = Comment::find_all();
}
//$comments = Comment::find_all();
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
                                <th>Објавено</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo $comment->id; ?></td>
                                    <td><?php echo $comment->author; ?>
                                        <?php
                                        if(strpos(User::check_user_role(),'admin'))
                                        {
                                            echo " <div class=action_links>";
                                            echo "<a class=delete_comment href=delete_comment.php?id={$comment->id}>Избриши</a>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $comment->body; ?></td>
                                    <td><?php echo $comment->date_time; ?></td>
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