    <?php include("includes/header.php"); ?>
    <?php
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page =  10;


    if(isset($_GET['by_user']))
    {
        $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_GET['by_user']} AND photo_status='public'");
        $items_total_count = count($photos);
        $paginate = new Paginate($page, $items_per_page, $items_total_count);
        $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_GET['by_user']} AND photo_status='public' LIMIT {$items_per_page} OFFSET {$paginate->offset()}");

        $photo_author = User::find_by_id($_GET['by_user']);
    }
    else
    {
        $photos = Photo::find_by_query("SELECT * FROM photos WHERE photo_status='public'");
        $items_total_count = count($photos);
        $paginate = new Paginate($page, $items_per_page, $items_total_count);


        $sql = "SELECT * FROM photos WHERE photo_status='public'";


        $sql .= " LIMIT {$items_per_page} ";
        $sql .= " OFFSET {$paginate->offset()}";

        $photos = Photo::find_by_query($sql);
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
        <div class="row">
            <div class="col-md-8">
                <ul class="pagination">
                    <?php
                    if($paginate->page_total() > 1)
                    {
                        if($paginate->has_previous())
                        {
                            echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Претходна</a></li>";
                        }
                        for($i=1; $i<=$paginate->page_total(); $i++)
                        {
                            if($i == $paginate->current_page)
                            {
                                echo "<li class='active'><a href='index.php?page={$i}'>$i</a></li>";
                            }
                            else
                            {
                                echo "<li><a href='index.php?page={$i}'>$i</a></li>";
                            }
                        }
                        if($paginate->has_next())
                        {
                            echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Следна</a></li>";
                        }

                    }
                    ?>

                </ul>
            </div>
        </div>

    <!-- /.row -->

    <?php include("includes/footer.php"); ?>
