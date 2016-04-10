    <?php include("includes/header.php"); ?>
    <?php
//    $photos = Photo::find_all();

    if(isset($_GET['by_user']))
    {
        $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_GET['by_user']}");
        $photo_author = User::find_by_id($_GET['by_user']);
    }
    else
    {
        $photos = Photo::find_all();
    }
    ?>
    <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-8">
        <?php if(count($photos) > 0) {
            foreach($photos as $index => $photo): ?>
                <div class="col-xs-6 col-md-3 thumbnail">
                    <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                        <h4><?php echo $photo->title; ?></h4>
                        <img class="home_page_photo img-responsive " src="admin/<?php echo $photo->picture_path(); ?>"
                             alt="">
                        <a href="index.php?by_user=<?php echo $photo->user_id; ?>">од:
                            <?php
                            $photo_author = User::find_by_id($photo->user_id);
                            $photo_author ? $photo_author = $photo_author->username : $photo_author = "Непознат";
                            echo $photo_author;
                            ?>
                        </a>
                    </a>
                </div>
            <?php endforeach;
        }
        else
        {
            echo "<h1> Корисникот <b>{$photo_author->username}</b> нема објавено слики</h1>";
        }
        ?>
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <div class="col-md-4">
    <?php include("includes/sidebar.php"); ?>
    </div>
    <!-- /.row -->

    <?php include("includes/footer.php"); ?>
