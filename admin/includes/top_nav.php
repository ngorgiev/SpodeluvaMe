<?php $logged_user = User::find_by_id($_SESSION['user_id']); ?>

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
        $comments_for_user = array_merge($comments_for_user,Comment::find_by_query("SELECT * FROM comments WHERE photo_id = {$photo_id} ORDER BY date_time DESC LIMIT 5"));
    }
    $comments = $comments_for_user;

}
else
{
    $comments = Comment::find_all();
}
//$comments = Comment::find_all();
?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="../index.php">Оди на Почетна</a>
</div>
<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-edit"></i> <b class="caret"></b></a>
        <ul class="dropdown-menu message-dropdown">

            <?php foreach($comments as $comment) {
                echo "<li class='message-preview'>";
                echo "<a href='comments.php'>";
                echo "<div class='media'>";
                echo "<div class='media-body'>";
                echo "<h5 class='media-heading'>";
                echo "<strong>$comment->author</strong></h5>";
                echo "<p class='small text-muted'><i class='fa fa-clock-o'></i> $comment->date_time</p>";
                $short_body = substr($comment->body, 0, 25);
                echo "<p> $short_body</p></div></div></a></li>";
            }
            ?>
            <li class="message-footer">
                <a href="comments.php">Видете ги сите коментари...</a>
            </li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user"></i>
            <?php
                echo $logged_user->username;
                ?>

            <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="edit_user.php?id=<?php echo $logged_user->id; ?>"><i class="fa fa-fw fa-user"></i> Профил</a>
            </li>
            <li>
                <a href="comments.php"><i class="fa fa-fw fa-edit"></i> Коментари</a>
            </li>
            <li>
                <a href="photos.php"><i class="glyphicon glyphicon-picture"></i> Слики</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Одјави Се</a>
            </li>
        </ul>
    </li>
</ul>