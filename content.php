<!DOCTYPE html>

<html class="app-ui">

<head>
    <!-- Meta -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <!-- Document title -->
    <title>Meu Telão - Content</title>

    <meta name="description" content="Meu Telão Login" />
    <meta name="robots" content="noindex, nofollow" />
</head>

<body>

    <main class="app-layout-content">

        <!-- Page header -->
        <figure class="banner bg-img bg-app bg-inverse" data-height="500" style="background-image: url(assets/img/misc/frontend_header_bg.png)">
            <figcaption class="banner-caption">
                <div class="container">
                    <div class="row vcenter-md">
                        <div class="col-md-5 col-md-push-7 text-center text-md-left">
                            <h1 class="display-2 m-y">Compartilhe seus eventos em telões e smartTVs</h1>
                            <p class="lead m-b-md">Publique fotos, gifs e videos na plataforma e o sistema cria um link para acesso da midia interativa.</p>
                            <a class="btn btn-default btn-lg" href="?pg=login">Cadastre-se GRÁTIS</a>
                        </div>
                        <div class="col-md-6 col-md-pull-5 hidden-sm hidden-xs">
                            <img class="img-responsive img-full" src="assets/img/misc/frontend_home1.png" alt="" />
                        </div>
                    </div>
                    <!-- .row -->
                </div>
                <!-- .container -->
            </figcaption>
        </figure>
        <!-- End page header -->

        <div class="section">
            <div class="container p-y-md b-b">
                <div class="row m-b-md">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <div class="section-tag">Confira</div>
                        <h2 class="h1 display-2 m-t">Ideal para festas, jogos, bares, restaurantes e outros.</h2>
                        <p>Após realizar o cadastro, você é direcionado para criar o seu 1º evento e publicar suas fotos e videos.</p>
                    </div>
                </div>
                <!-- .row -->

                <div class="row text-center">
                    <div class="col-md-4">
                        <i class="ion-images fa-4x"></i>
                        <h4 class="m-t-0">Seus eventos em suas mãos</h4>
                        <p class="text-muted">Ideal para mostrar eventos em tempo real com publicações de fotos e videos com QRCod para visualização e compartilhamento em redes sociais.</p>
                    </div>
                    <div class="col-md-4">                        
                        <i class="ion-easel fa-4x"></i>
                        <h4 class="m-t-0">Plataforma simples e interativa</h4>
                        <p class="text-muted">Seus eventos, serviços, cardápios com promoções e produtos podem ser expostos em smartTVs, PCs e no próprio site de forma prática e dinâmica.</p>
                    </div>
                    <div class="col-md-4">                                                
                        <i class="ion-ios-locked-outline fa-4x"></i>
                        <h4 class="m-t-0">Exclusividade de acesso</h4>
                        <p class="text-muted">Suas fotos e videos são publicados na plataforma com toda segurança e você tem o total controle do que é publicado.</p>
                    </div>
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </div>
        <!-- .section -->

        <div class="page-header bg-app bg-inverse">
            <section class="container">
                <h1 class="display-2 text-center">Confira algumas publicações!</h1>
                <!-- Section Content -->                
                <div class="row p-t-lg p-b-xl">
                <?php
                    //Mostra Fotos do Evento
                    $eventos = DB::select("SELECT * FROM evento e WHERE e.status = 'S' ORDER BY e.datacadastro DESC LIMIT 3");                    
                    if($eventos){                        
                        foreach ($eventos as $evento){
                            $eventoFotos = DB::select("SELECT * FROM arquivos a WHERE a.idevento = ? ORDER BY a.id ASC LIMIT 1,1",[$evento['id']]);
                            //var_dump($eventoFotos);
                            //exit;
                ?>                   

                    <div class="col-sm-4 col-lg-4">   
                        <a href="?pg=eventos&id=<?php echo $evento['id']; ?>#eventos">
                            <div class="card-block">
                                <div class="p-x-md text-center">
                                    <div class="p-x">                                        
                                        <img class="img-rounded" src="telao/fotos/<?php echo $evento['cod']; ?>/<?php echo $eventoFotos[0]['titulo']; ?>" alt="" style="max-width: 180px;" />
                                    </div>
                                    <h4><?php echo $evento['titulo']; ?></h4>
                                    <p><?php //echo $evento['descricao']; ?></p>
                                </div>                                
                            </div>                            
                        </a>
                    </div>
                <?php 
                    } }
                ?>
                    <div class="col-md-4">
                        <div class="p-x-md text-center"><a class="btn btn-default btn-lg" href="?pg=eventos"> Publicações</a></div>
                    </div>                   
                </div>
                <!-- End Section Content -->
            </section>
        </div>


        <div class="section p-y-md bg-white">
            <div class="container">
                <div class="row vcenter-md m-b-md">
                    <div class="col-md-4 col-md-push-7 text-center text-md-left">
                        <h2 class="h1 display-2 m-b">Cadastre-se GRÁTIS</h2>
                        <p class="lead m-b-lg">Aproveite esta oportunidade única utilizando a plataforma de forma gratuita por 1 mês.</p>
                        <p class="m-b-md"><a class="btn btn-app btn-lg" href="?pg=cadastro">Testar agora!<i class="ion-ios-arrow-right m-l-xs"></i></a></p>
                    </div>
                    <!-- .col-md-4 -->
                    <div class="col-md-4 col-md-pull-3">
                        <img class="img-responsive" src="assets/img/misc/frontend_home3.png" alt="" />
                    </div>
                    <!-- .col-md-4 -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </div>


        <!-- .section -->

        <div class="page-header bg-app bg-inverse">
            <section class="container">
                <!-- Section Content -->
                <div class="p-y-md text-center">
                    <h1 class="display-2">Adquira já!</h1>
                    <p class="text-muted">Confira os planos conforme a sua necessidade. Cadastre-se e aproveite esta ferramenta em seu negócio.</p>
                </div>
                <!-- End Section Content -->
            </section>
        </div>
        <!-- End Page header -->

        <!-- Pricing -->
        <div class="page-content bg-white">
            <section class="container">
                <div class="row m-y">
                    <div class="col-sm-4 col-lg-4">
                        <!-- Developer Plan -->
                        <a class="card hover-shadow-3 text-center" href="?pg=cadastro">
                            <div class="card-header">
                                <h3>Básico</h3>
                            </div>
                            <div class="card-block bg-green bg-inverse">
                                <div class="h1 m-y-sm">Gratuito</div>
                                <div class="h5 font-300 text-muted m-t-0">por 1 mês</div>
                            </div>
                            <div class="card-block">
                                <table class="table table-borderless table-condensed">
                                    <tbody>
                                    <tr>
                                        <td><strong>1</strong> Evento</td>
                                    </tr>
                                    <tr>
                                        <td><strong>100</strong> JPG/PNG/GIF</td>
                                    </tr>                                    
                                    <tr>
                                        <td><strong>Email</strong> Suporte</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-block bg-gray-lighter-o">
                                <span class="btn btn-app">Cadastrar</span>
                            </div>
                        </a>
                        <!-- End Developer Plan -->
                    </div>
                    <!-- .col-sm-6 -->

                    <div class="col-sm-4 col-lg-4">
                        <!-- Startup Plan -->
                        <a class="card hover-shadow-3 text-center" href="">
                            <div class="card-header">
                                <h3>Standard</h3>
                            </div>
                            <div class="card-block bg-gray-lighter-o">
                                <div class="h1 m-y-sm">R$ 4,99</div>
                                <div class="h5 font-300 text-muted m-t-0">por mês</div>
                            </div>
                            <div class="card-block">
                                <table class="table table-borderless table-condensed">
                                    <tbody>
                                    <tr>
                                        <td><strong>Até 10</strong> Eventos</td>
                                    </tr>
                                    <tr>
                                        <td><strong>1000</strong> JPG/PNG/GIF/Video</td>
                                    </tr>                                    
                                    <tr>
                                        <td><strong>Email, Whats</strong> Suporte</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-block bg-gray-lighter-o" style="text-align: center;">
                                <!-- INICIO FORMULARIO BOTAO PAGSEGURO: NAO EDITE OS COMANDOS DAS LINHAS ABAIXO 
                                <form action="https://pagseguro.uol.com.br/pre-approvals/request.html" method="post">
                                    <input type="hidden" name="code" value="FA46AB47EEEE9EF00425DF91F44D23A5" />
                                    <input type="hidden" name="iot" value="button" />
                                    <input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/assinaturas/209x48-assinar-cinza-assina.gif" name="submit" alt="Meu Telão - Plano Standard" width="209" height="48" />
                                </form>-->
                                <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

                                <a mp-mode="dftl" href="https://www.mercadopago.com.br/subscriptions/checkout?preapproval_plan_id=2c938084878de20d0187911d4a6a00eb" name="MP-payButton" class='blue-ar-l-rn-none'>Adquira já</a>
                                <script type="text/javascript">
                                   (function() {
                                      function $MPC_load() {
                                         window.$MPC_loaded !== true && (function() {
                                         var s = document.createElement("script");
                                         s.type = "text/javascript";
                                         s.async = true;
                                         s.src = document.location.protocol + "//secure.mlstatic.com/mptools/render.js";
                                         var x = document.getElementsByTagName('script')[0];
                                         x.parentNode.insertBefore(s, x);
                                         window.$MPC_loaded = true;
                                      })();
                                   }
                                   window.$MPC_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;
                                   })();
                                  /*
                                        // to receive event with message when closing modal from congrants back to site
                                        function $MPC_message(event) {
                                          // onclose modal ->CALLBACK FUNCTION
                                         // !!!!!!!!FUNCTION_CALLBACK HERE Received message: {event.data} preapproval_id !!!!!!!!
                                        }
                                        window.$MPC_loaded !== true ? (window.addEventListener("message", $MPC_message)) : null; 
                                        */
                                </script>



                            </div>
                        </a>
                        <!-- End Startup Plan -->
                    </div>
                    <!-- .col-sm-6 -->

                    <div class="col-sm-4 col-lg-4">
                        <!-- Business Plan -->
                        <a class="card hover-shadow-3 text-center" href="">
                            <div class="card-header">
                                <h3>Avançado</h3>
                            </div>
                            <div class="card-block bg-gray-lighter-o">
                                <div class="h1 m-y-sm">R$ 9,99</div>
                                <div class="h5 font-300 text-muted m-t-0">por mês</div>
                            </div>
                            <div class="card-block">
                                <table class="table table-borderless table-condensed">
                                    <tbody>
                                    <tr>
                                        <td><strong>Até 100</strong> Eventos</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Até 10000</strong> JPG/PNG/GIF/Video</td>
                                    </tr>                                    
                                    <tr>
                                        <td><strong>Email, Whats</strong> Suporte</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-block bg-gray-lighter-o" style="text-align: center;">
                                <!-- INICIO FORMULARIO BOTAO PAGSEGURO: NAO EDITE OS COMANDOS DAS LINHAS ABAIXO 
                                <form action="https://pagseguro.uol.com.br/pre-approvals/request.html" method="post">
                                    <input type="hidden" name="code" value="C839F194D8D8FD1FF43F3FB9557B949A" />
                                    <input type="hidden" name="iot" value="button" />
                                    <input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/assinaturas/209x48-assinar-cinza-assina.gif" name="submit" alt="Meu Telão - Plano Avançado" width="209" height="48" />
                                </form>-->
                                <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
                                <a mp-mode="dftl" href="https://www.mercadopago.com.br/subscriptions/checkout?preapproval_plan_id=2c938084878e56e901879123b79e0108" name="MP-payButton" class='blue-ar-l-rn-none'>Adquira já</a>
                                <script type="text/javascript">
                                   (function() {
                                      function $MPC_load() {
                                         window.$MPC_loaded !== true && (function() {
                                         var s = document.createElement("script");
                                         s.type = "text/javascript";
                                         s.async = true;
                                         s.src = document.location.protocol + "//secure.mlstatic.com/mptools/render.js";
                                         var x = document.getElementsByTagName('script')[0];
                                         x.parentNode.insertBefore(s, x);
                                         window.$MPC_loaded = true;
                                      })();
                                   }
                                   window.$MPC_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;
                                   })();
                                  /*
                                        // to receive event with message when closing modal from congrants back to site
                                        function $MPC_message(event) {
                                          // onclose modal ->CALLBACK FUNCTION
                                         // !!!!!!!!FUNCTION_CALLBACK HERE Received message: {event.data} preapproval_id !!!!!!!!
                                        }
                                        window.$MPC_loaded !== true ? (window.addEventListener("message", $MPC_message)) : null; 
                                        */
                                </script>

                            </div>
                        </a>
                        <!-- End Business Plan -->
                    </div>
                    <!-- .col-sm-6 -->
                </div>

                <!-- End Section Content -->
            </section>
        </div>
        <!-- End Pricing -->

        <div class="section p-y-xs bg-app bg-inverse">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h2 class="h1 display-2">Cadastre-se GRÁTIS</h2>
                        <p class="lead">Faça já o seu cadastro criando um novo evento e publicando seus fotos e videos.</p>
                    </div>
                </div>
                <!-- .row -->
                <div class="row p-t-md p-b-md">
                    <div class="col-md-10 col-md-offset-1">
                        <button onclick="window.location.href='index.php?pg=cadastro';" class="btn btn-app btn-block" type="button"><i class="fa fa-plus-circle"></i> Registre-se já!</button>
                    </div>
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </div>
        <!-- .section -->


    </main>


</body>

</html>