<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Профил
                <small>Subheading</small>
            </h1>
            <?php
//            $user = new User();
//            $user->username = "ExampleUsername1";
//            $user->password = "ExamplePassword1";
//            $user->first_name = "ExampleFirstName1";
//            $user->last_name = "ExampleLastName1";

//            $user->create();

            $user = User::find_user_by_id(10);
//            $user->last_name = "Nikolovski223";
            $user->delete();
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