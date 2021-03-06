<?php include("includes/header.php"); ?>
<?php
require_once("admin/includes/init.php");
$message = "";
if(empty($_GET['id']))
{
    redirect("index.php");
}

$photo = Photo::find_by_id($_GET['id']);

if($session->is_signed_in())
{
    $user = User::find_by_id($_SESSION['user_id']);
}

if(isset($_POST['submit']))
{
    if(!$session->is_signed_in())
    {
        $author = trim($_POST['author']);
    }
    else
    {
        $author = $user->username;
    }

    $body = trim($_POST['body']);

    $new_comment =Comment::create_comment($photo->id, $author, $body);
    if($new_comment && $new_comment->save())
    {
        redirect("photo.php?id={$photo->id}");
    }
    else
    {
        $message = "Се појави проблем при зачувувањето на коментарот!";
    }
}
else
{
    $author = "";
    $body = "";
}
$comments = Comment::find_comments_by_photo_id($photo->id);
?>

    <div class="row">
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $photo->title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    објавено од:
                    <a href="index.php?by_user=<?php echo $photo->user_id; ?>">
                        <?php
                        $photo_author = User::find_by_id($photo->user_id);
                        echo $photo_author ? $photo_author->username : "Непознат";
                        ?>
                    </a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $photo->upload_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="admin/<?php echo $photo->picture_path();?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $photo->caption; ?></p>
                <p><?php echo $photo->description; ?></p>
                <hr>

                <!-- Like Dislike -->
                <div class="ratings">
                    <p class="pull-right"></p>
                    <p>
                        <!-- Like Icon HTML -->
                        <span class="glyphicon glyphicon-thumbs-up" onClick="cwRating(<?php echo $photo->id;?>,1,'like_count<?php echo $photo->id; ?>')"></span>&nbsp;
                        <!-- Like Counter -->
                        <span class="counter" id="like_count<?php echo $photo->id; ?>"><?php echo $photo->likes; ?></span>&nbsp;&nbsp;&nbsp;

                        <!-- Dislike Icon HTML -->
                        <span class="glyphicon glyphicon-thumbs-down" onClick="cwRating(<?php echo $photo->id; ?>,0,'dislike_count<?php echo $photo->id; ?>')"></span>&nbsp;
                        <!-- Dislike Counter -->
                        <span class="counter" id="dislike_count<?php echo $photo->id; ?>"><?php echo $photo->dislikes; ?></span>
                    </p>
                </div>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Остави Коментар:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <?php
                            if(!empty($user))
                            {
                                echo "<div class='panel panel-default'>";
                                echo "<div class='panel-heading'>Автор:</div>";
                                echo "<div class='panel-body'>$user->username</div></div>";
                            }
                            else
                            {
                                echo "<label for='author'>Автор</label>";
                                echo "<input class='form-control' name='author' id='disabledInput' type='text' value=''>";
                            }
                            ?>
<!--                            <label for="author">Автор</label>-->
<!--                            <input type="text" name="author" class="form-control">-->
                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Испрати</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php foreach ($comments as $comment): ?>
                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <?php
                            $authorUsername = $comment->author;
                            $commentuser = User::find_by_query("SELECT * FROM users WHERE username = '$authorUsername'");
                            if(count($commentuser) > 0)
                            {
                                //echo "<h1>$user->image_path_and_placeholder</h1>";
                                $author_image = "admin" . DS . $commentuser[0]->image_path_and_placeholder();
                                echo "<img width='64' height='64' class='media-object' src='$author_image'>";
                            }
                            else
                            {
                                echo "<img class='media-object' src='http://placehold.it/64x64' alt=''>";
                            }

                            ?>
<!--                            <img class="media-object" src="http://placehold.it/64x64" alt="">-->
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment->author; ?>
                                <small><?php echo $comment->date_time; ?>M</small>
                            </h4>
                            <?php echo $comment->body; ?>
                        </div>
                    </div>


                <?php endforeach; ?>
                <!-- Comment -->
            </div>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

    <?php include("includes/sidebar.php"); ?>
</div>
<!-- /.row -->

<?php include("includes/footer.php"); ?>
</div>




<script type="text/javascript">
    /**
     * Function Name: cwRating()
     * Function Author: CodexWorld
     * Description: cwRating() function is used for implement the rating system. cwRating() function insert like or dislike data into the database and display the rating count at the target div.
     * id = Unique ID, like or dislike is based on this ID.
     * type = Use 1 for like and 0 for dislike.
     * target = Target div ID where the total number of likes or dislikes will display.
     **/
    function cwRating(id,type,target){
        $.ajax({
            type:'POST',
            url:'admin/includes/like_dislike_ajax_code.php',
            data:'id='+id+'&type='+type,
            success:function(msg){
                if(msg == 'err'){
                    alert('Some problem occured, please try again.');
                }else{
                    $('#'+target).html(msg);
                }
            }
        });
    }
</script>








