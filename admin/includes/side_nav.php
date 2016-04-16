<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <?php

        $dashboardLink = "<li><a href='index.php'><i class='fa fa-fw fa-dashboard'></i> Кориснички Панел</a></li>";
        $usersManagementLink =  "<li><a href='users.php'><i class='fa fa-fw fa-bar-chart-o'></i> Корисници</a></li>";
        $uploadPhotoLink = "<li><a href='upload.php'><i class='fa fa-fw fa-table'></i> Прикачи</a></li>";
        $photosManagementLink = "<li><a href='photos.php'><i class='fa fa-fw fa-table'></i> Слики</a></li>";
        $commentsManagementLink = "<li><a href='comments.php'><i class='fa fa-fw fa-edit'></i> Коментари</a></li>";

        if(strpos(User::check_user_role(),'admin'))
        {
            echo $dashboardLink;
            echo $usersManagementLink;
            echo $uploadPhotoLink;
            echo $photosManagementLink;
            echo $commentsManagementLink;
        }
        else
        {
            echo $dashboardLink;
            echo $uploadPhotoLink;
            echo $photosManagementLink;
            echo $commentsManagementLink;
        }
        ?>

    </ul>
</div>