<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Профил
                <small>Subheading</small>
            </h1>
            <?php

            //TEST CREATE USER
//            $user = new User();
//            $user->username = "ExampleUsernameNikola";
//            $user->password = "ExamplePasswordNikola";
//            $user->first_name = "ExampleFirstNameNikola";
//            $user->last_name = "ExampleLastNameNikola";
//
//            $user->create();

            //TEST UPDATE USER
//            $user = User::find_by_id(12);
//            $user->delete();

            //TEST FIND PHOTO
            $photo = Photo::find_by_id(2);
            $photo->delete();


            ?>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->