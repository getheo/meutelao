<?php
date_default_timezone_set('America/Cuiaba');

require_once 'engine/DB.php';
require_once 'helpers/helpers.php';

session_start();
if(isset($_SESSION['nome'])){
    $autorizacao = true;
    //echo "<meta http-equiv='refresh' content='0; url=http://localhost/getheo.com.br/meutelao/index.php?pg=login'>";
} else { $autorizacao = false; }
//var_dump($_SESSION);


?>
<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="google-adsense-account" content="ca-pub-7648703795235196">

        <!-- Document title -->
        <title>Meu Telão - Home</title>

        <!--start Facebook Open Graph Protocol-->
        <meta name="description" content="<?php echo $description; ?>">
        <title>Meu Telão - Home</title>
        <meta property="og:type" content="website">
        <meta property="og:locale" content="pt_BR">
        <meta property="og:site_name" content="Meu Telão"/>
        <meta property="og:title" content="Meu Telão - Compartilhe seus eventos em telões e smartTVs, PCs e nas Redes Sociais"/>
        <meta property="og:url" content="https://meutelao.com.br/"/>
        <meta property="og:image" content="https://meutelao.com.br/telao/post/post.jpg"/>
        <meta property="og:description" content="Ideal para festas, jogos, bares, restaurantes e outros."/>
        <!--end Facebook Open Graph Protocol-->

        <script type="text/javascript" src="assets/js/whatsapp-button.js"></script>

        <meta name="description" content="Meu Telão - Compartilhe seus eventos em telões e smartTVs, PCs e nas Redes Sociais." />
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

        <!--
		Page JS Plugins CSS
        <link rel="stylesheet" href="assets/js/plugins/slick/slick.min.css" />
        <link rel="stylesheet" href="assets/js/plugins/slick/slick-theme.min.css" />		

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7648703795235196" crossorigin="anonymous"></script>
		-->

        <link rel="stylesheet" href="engine/plugins/sweetalert2/sweetalert2.css" />
        <script src="assets/js/core/jquery.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="engine/plugins/sweetalert2/sweetalert2.all.js"></script>
		
		
        <link href="assets/js/bootstrap.fd.css" rel="stylesheet">
        <script src="assets/js/bootstrap.fd.js"></script>
		

        <script src="https://jsuites.net/v4/jsuites.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on("click", '.whatsapp', function() {
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {

                        var text = $(this).attr("data-text");
                        var url = $(this).attr("data-link");
                        var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
                        var whatsapp_url = "whatsapp://send?text=" + message;
                        window.location.href = whatsapp_url;
                    } else {
                        var text = $(this).attr("data-text");
                        var url = $(this).attr("data-link");
                        var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
                        var whatsapp_url = "https://api.whatsapp.com/send?text=" + message;
                        window.location.href = whatsapp_url;
                    }
                });

            });
        </script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-WJSCPM9E30"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-WJSCPM9E30');
        </script>
		
		<script src="//cdn.jsdelivr.net/npm/vivus@latest/dist/vivus.min.js"></script>
		

    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <!-- Header -->
                <header class="app-layout-header">
                    <nav class="navbar navbar-default p-y">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- Header logo -->
                                <a class="navbar-brand" href="index.php">
                                    <img class="img-responsive" src="assets/img/logo/meutelao_logo.svg" title="Meu Telão" alt="Meu Telão" />
                                </a>
                            </div>

                            <div class="collapse navbar-collapse" id="header-navbar-collapse">


                                <!-- Header navigation menu -->
                                <ul id="main-menu" class="nav navbar-nav navbar-right">

                                <?php
                                    if($autorizacao==true){
                                ?>
                                    <li>
                                        <a href="#" style="color: #0c6a0c;"><i class="fa fa-expeditedssl"></i> Admin</a>

                                    </li>
                                    <li>
                                        <a href="index.php?pg=dashboard" style="<?php if(!empty($_GET['pg']) && $_GET['pg']=="dashboard"){ echo "background-color: #32254f; color:#FFF;";} ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="index.php?pg=perfil" style="<?php if(!empty($_GET['pg']) && $_GET['pg']=="perfil"){ echo "background-color: #32254f; color:#FFF;";} ?>"><i class="fa fa-user-secret"></i> Perfil</a>
                                    </li>
                                    <li>
                                        <a href="index.php?pg=evento" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="evento" || $_GET['pg']=="form_evento") ){ echo "background-color: #32254f; color:#FFF;";} ?>"><i class="fa fa-calendar"></i> Evento</a>
                                    </li>
                                    <li>
                                        <a href="index.php?pg=sair"><i class="fa fa-sign-out"></i> Sair</a>
                                    </li>
                                <?php
                                    } else {
                                ?>
                                    <li>
                                        <a href="index.php" style="<?php if(empty($_GET['pg']) || $_GET['pg']==""){ echo "background-color: #32254f; color:#FFF;";} ?>">Home</a>
                                    </li>

                                    <li>
                                        <a href="?pg=servico" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="servico")){ echo "background-color: #32254f; color:#FFF;";} ?>">Como funciona</a>
                                    </li>

                                    <li>
                                        <a href="?pg=plano" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="plano")){ echo "background-color: #32254f; color:#FFF;";} ?>"">Planos</a>
                                    </li>
                                    <li>
                                        <a href="index.php?pg=eventos" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="evento" || $_GET['pg']=="form_evento") ){ echo "background-color: #32254f; color:#FFF;";} ?>"><i class="fa fa-calendar"></i> Eventos</a>
                                    </li>
                                    <li>
                                        <a href="?pg=cadastro" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="cadastro")){ echo "background-color: #32254f; color:#FFF;";} ?>"">Cadastro</a>
                                    </li>
                                    <li>
                                        <a href="?pg=telao" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="telao")){ echo "background-color: #32254f; color:#FFF;";} ?>"">Telão</a>
                                    </li>
                                    <li>
                                        <a href="?pg=login" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="login")){ echo "background-color: #32254f; color:#FFF;";} ?>"">Login</a>
                                    </li>

                                    <li>
                                        <a href="?pg=contato" style="<?php if(!empty($_GET['pg']) && ($_GET['pg']=="contato")){ echo "background-color: #32254f; color:#FFF;";} ?>"">Contato</a>
                                    </li>
                                <?php
                                    }
                                ?>

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
                if(!empty($_GET['pg'])){
                    if($_GET['pg']=="perfil" || $_GET['pg']=="evento" || $_GET['pg']=="form_evento" || $_GET['pg']=="dashboard" || $_GET['pg']=="usuario" || $_GET['pg']=="sair"){ $pg = "portal/".$_GET['pg']; }
                    else{ $pg = $_GET['pg']; }
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
                        <div class="pull-left text-center text-md-left">
                            Meu Telão &copy; <span class="js-year-copy"></span>
                        </div>
                        <div class="pull-right text-right text-green">
                            <a data-text="Meu Telão" data-link="https://meutelao.com.br/" class="whatsapp w3_whatsapp_btn w3_whatsapp_btn_large"><i class="fa fa-whatsapp"></i> Compartilhar</a>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- .app-layout-container -->
        </div>
        <!-- .app-layout-canvas -->

        <div id="loaderajax" class="loaderajax" style="display: none;">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
        </div>

        <style>
            .loaderajax {
                z-index: 10000;
                top: 0;
                left: 0;
                position: fixed;
                width: 100%;
                height: 100%;
                background-color: rgba(23, 23, 23, 0.7);
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
                color: #FFD700;
            }
        </style>

        <!-- AppUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock and App.js -->
        <script src="assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="assets/js/core/jquery.placeholder.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/app-custom.js"></script>

        <!-- Page JS Plugins -->
        <script src="assets/js/plugins/slick/slick.min.js"></script>

        <!-- Page JS Code -->
        <script>
            $(function()
            {
                // Init page helpers (Slick Slider + Easy Pie Chart plugins)
                App.initHelpers('slick');
            });
        </script>

    </body>

</html>