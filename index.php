    <?php include("includes/header.php"); ?>
    <?php
    $photos = Photo::find_all();
    ?>
    <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-8">
        <?php foreach($photos as $index => $photo): ?>
            <div class="col-xs-6 col-md-3">
                <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                    <h4><?php echo $photo->title; ?></h4>
                    <img class="home_page_photo img-responsive " src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <div class="col-md-4">
    <?php include("includes/sidebar.php"); ?>
    </div>
    <!-- /.row -->

    <?php include("includes/footer.php"); ?>
