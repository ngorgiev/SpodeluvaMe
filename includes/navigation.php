    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Почетна</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">За Нас</a>
                    </li>
                    <li>
                        <a href="#">Сервиси</a>
                    </li>
                    <li>
                        <a href="#">Контакт</a>
                    </li>
                    <li>
                        <?php
                        if(!$session->is_signed_in())
                        {
                            echo "<a href='admin/login.php'>Најава/Регистрација</a>";
                        }
                        else
                        {
                            echo "<a href='admin'>Кориснички Панел</a>";
                        }
                        ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>