<?php
echo "<meta http-equiv='refresh' content='0; url=https://meutelao.com.br/index.php?pg=login'>";
?>
<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Sistema Administrativo</title>

        <meta name="description" content="Meu Telão - Sistema de Administração" />
        <meta name="author" content="rustheme" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="assets/img/favicons/apple-touch-icon.png" />
        <link rel="icon" href="../assets/img/favicons/favicon.ico" />

        <!-- Google fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

        <!-- AppUI CSS stylesheets -->
        <link rel="stylesheet" id="css-font-awesome" href="../assets/css/font-awesome.css" />
        <link rel="stylesheet" id="css-ionicons" href="../assets/css/ionicons.css" />
        <link rel="stylesheet" id="css-bootstrap" href="../assets/css/bootstrap.css" />
        <link rel="stylesheet" id="css-app" href="../assets/css/app.css" />
        <link rel="stylesheet" id="css-app-custom" href="../assets/css/app-custom.css" />
        <!-- End Stylesheets -->

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7648703795235196" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../engine/plugins/sweetalert2/sweetalert2.css" />
        <script src="../assets/js/core/jquery.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../engine/plugins/sweetalert2/sweetalert2.all.js"></script>


        <link href="../assets/js/bootstrap.fd.scss" rel="stylesheet">
        <script src="../assets/js/bootstrap.fd.js"></script>

    </head>

    <body class="app-ui layout-has-drawer layout-has-fixed-header">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <!-- Drawer -->
                <aside class="app-layout-drawer">

                    <!-- Drawer scroll area -->
                    <div class="app-layout-drawer-scroll">
                        <!-- Drawer logo -->
                        <div id="logo" class="drawer-header">
                            <a href="index.php"><img class="img-responsive" src="../assets/img/logo/logo-backend.png" title="Meu Telão" alt="Meu Telão" /></a>
                        </div>

                        <!-- Drawer navigation -->
                        <nav class="drawer-main">
                            <ul class="nav nav-drawer">

                                <li class="nav-item <?php if( !empty($_GET['pg']) && $_GET['pg']=="perfil"){ echo "active";} ?> ">
                                    <a href="index.php?pg=perfil"><i class="fa fa-user-secret fa-2x"></i> Perfil</a>
                                </li>

                                <?php
                                    if($_SESSION['idnivel']==1):
                                ?>
                                <li class="nav-item <?php if( !empty($_GET['pg']) && $_GET['pg']=="usuario"){ echo "active";} ?>">
                                    <a href="index.php?pg=usuario"><i class="fa fa-users fa-2x"></i> Usuários</a>
                                </li>
                                <?php
                                    endif;
                                ?>

                                <li class="nav-item <?php if( !empty($_GET['pg']) && $_GET['pg']=="evento"){ echo "active";} ?>">
                                    <a href="index.php?pg=evento"><i class="fa fa-calendar fa-2x"></i> Eventos</a>
                                </li>


                            </ul>
                        </nav>
                        <!-- End drawer navigation -->

                        <div class="drawer-footer">
                            <p class="copyright">Copyright &copy; 2022. Todos os direitos reservados.<a target="_blank" href="https://getheo.com.br">GETHEO</a></p>
                        </div>
                    </div>
                    <!-- End drawer scroll area -->
                </aside>
                <!-- End drawer -->

                <!-- Header -->
                <header class="app-layout-header">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">

                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar-collapse" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>

                                <button class="pull-left hidden-lg hidden-md navbar-toggle" type="button" data-toggle="layout" data-action="sidebar_toggle">
                                    <span class="sr-only">Toggle drawer</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>

                                <a id="logoTopo" href="index.php" class="col-md-4 text-center" style="display: none;"><img src="../assets/img/logo/logo-backend.png" title="Meu Telão" alt="Meu Telão" style="max-height: 50px;" /></a>

                            </div>

                            <div class="collapse navbar-collapse" id="header-navbar-collapse">

                                <ul class="nav navbar-nav navbar-right navbar-toolbar hidden-sm hidden-xs">

                                    <li class="dropdown dropdown-profile">
                                        <a href="javascript:void(0)" data-toggle="dropdown">
                                            <span class="m-r-sm"><?php echo $_SESSION['nome']; ?><span class="caret"></span></span>
                                            <img class="img-avatar img-avatar-48" src="../assets/img/avatars/user.png" alt="" />
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-header">
                                                Pages
                                            </li>
                                            <li>
                                                <a href="index.php?pg=perfil">Perfil</a>
                                            </li>
                                            <li>
                                                <a href="index.php?pg=evento"><span class="badge badge-success pull-right">3</span> Eventos</a>
                                            </li>
                                            <li>
                                                <a href="index.php?pg=sair">Sair</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- .navbar-right -->
                            </div>
                        </div>
                        <!-- .container-fluid -->
                    </nav>
                    <!-- .navbar-default -->
                </header>
                <!-- End header -->

                <main class="app-layout-content">

                    <!-- Page Content -->
                    <div class="container-fluid p-y-md">
                        <?php

                        if(!empty($_GET['pg'])){ $pg = $_GET['pg']; } else{ $pg = 'dashboard'; }

                        $file_include = $pg . '.php';
                        if (file_exists($file_include)) {
                            include_once $file_include;
                        } else {
                            include_once '../erro.php';
                        }
                        ?>
                    </div>
                    <!-- End Page Content -->

                </main>

            </div>
            <!-- .app-layout-container -->
        </div>
        <!-- .app-layout-canvas -->

        <!-- AppUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock and App.js -->
        <script src="../assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="../assets/js/core/jquery.placeholder.min.js"></script>
        <script src="../assets/js/app.js"></script>
        <script src="../assets/js/app-custom.js"></script>

    </body>

</html>