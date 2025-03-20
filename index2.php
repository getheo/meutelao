<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Home</title>

        <meta name="description" content="Meu Telão - Publique seus eventos e compartilhe em SmartTVs, PCs e nas Redes Sociais" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="assets/img/favicons/apple-touch-icon.png" />
        <link rel="icon" href="assets/img/favicons/favicon.ico" />

        <!-- Google fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

        <!-- AppUI CSS stylesheets -->
        <link rel="stylesheet" id="css-font-awesome" href="assets/css/font-awesome.css" />
        <link rel="stylesheet" id="css-ionicons" href="assets/css/ionicons.css" />
        <link rel="stylesheet" id="css-bootstrap" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" id="css-app" href="assets/css/app.css" />
        <link rel="stylesheet" id="css-app-custom" href="assets/css/app-custom.css" />
        <!-- End Stylesheets -->

        <!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7648703795235196" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="engine/plugins/sweetalert2/sweetalert2.css" />
    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <!-- Header -->
                <header class="app-layout-header">
                    <nav class="navbar navbar-default p-y">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- Header logo -->
                                <a class="navbar-brand" href="index.php">
                                    <img class="img-responsive" src="assets/img/logo/logo-frontend.png" title="Meu Telão" alt="Meu Telão" />
                                </a>
                            </div>

                            <div class="collapse navbar-collapse" id="header-navbar-collapse">

                                <!-- Header navigation menu -->
                                <ul id="main-menu" class="nav navbar-nav navbar-right">

                                    <li class="active">
                                        <a href="index.php">Home</a>
                                    </li>

                                    <li>
                                        <a href="?pg=servico">Como funciona</a>
                                    </li>

                                    <li>
                                        <a href="?pg=plano">Planos</a>
                                    </li>
                                    <li>
                                        <a href="?pg=cadastro">Cadastro</a>
                                    </li>
                                    <li>
                                        <a href="?pg=login">Login</a>
                                    </li>

                                    <li>
                                        <a href="?pg=contato">Contato</a>
                                    </li>

                                </ul>
                                <!-- End header navigation menu -->
                            </div>
                        </div>
                        <!-- .container -->
                    </nav>
                    <!-- .navbar -->
                </header>
                <!-- End header -->

                <?php

                if(empty($_GET['pg'])){
                    $pg = $_GET['pg'];
                } else{
                    $pg = 'content';
                }
                $file_include = $pg . '.php';
                if (file_exists($file_include)) {
                    include_once $file_include;
                } else {
                    include_once 'content.php';
                }
                ?>

                <footer class="app-layout-footer">
                    <div class="container p-y-md">
                        <div class="pull-right hidden-sm hidden-xs">
                        </div>
                        <div class="pull-left text-center text-md-left">
                            Meu Telão &copy; <span class="js-year-copy"></span>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- .app-layout-container -->
        </div>
        <!-- .app-layout-canvas -->

        <!-- Apps Modal -->
        <!-- Opens from the button in the header -->
        <div id="apps-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-sm modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <!-- Apps card -->
                    <div class="card m-b-0">
                        <div class="card-header bg-app bg-inverse">
                            <h4>Apps</h4>
                            <ul class="card-actions">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-block">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <a class="card card-block m-b-0 bg-app-secondary bg-inverse" href="index.html">
                                        <i class="ion-speedometer fa-4x"></i>
                                        <p>Admin</p>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="card card-block m-b-0 bg-app-tertiary bg-inverse" href="frontend_home.html">
                                        <i class="ion-laptop fa-4x"></i>
                                        <p>Frontend</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- .card-block -->
                    </div>
                    <!-- End Apps card -->
                </div>
            </div>
        </div>
        <!-- End Apps Modal -->

        <!-- AppUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock and App.js -->
        <script src="assets/js/core/jquery.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="assets/js/core/jquery.placeholder.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/app-custom.js"></script>

        <script src="engine/plugins/sweetalert2/sweetalert2.all.js"></script>

    </body>

</html>