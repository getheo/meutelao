<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Eventos</title>

        <meta name="description" content="Evento" />
        <meta name="robots" content="noindex, nofollow" />

    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <main class="app-layout-content">

                    <!-- Page header -->
                    <figure class="banner bg-img bg-app bg-inverse" data-height="300" style="background-image: url(assets/img/misc/frontend_header_bg.png)">
                        <figcaption class="banner-caption text-center">
                            <div class="container">
                                <div class="row vcenter-xs">
                                    <div class="col-md-8 col-md-offset-2">
                                        <h1 class="display-2 m-b">Confira os principais eventos já cadastrados</h1>
                                    </div>
                                </div>
                            </div>
                            <!-- .container -->
                        </figcaption>
                    </figure>
                    <!-- End page header -->

                    <?php
                        if(!empty($_GET['id'])){
                    ?>
                    <div class="section p-y-md">
                        <div class="container text-center">

                            <div id="eventos" class="row">
                                
								<?php
									//Mostra Fotos do Evento Clicado
									$eventoFotos = DB::select('SELECT e.titulo AS evento, a.titulo AS titulo, e.cod AS cod FROM arquivos a LEFT JOIN evento e ON a.idevento = e.id WHERE a.idevento = ? ORDER BY a.id ASC', [$_GET['id']]);
									if($eventoFotos){
								?>
									<div class="col-md-12 margin">
										<h3><?php echo $eventoFotos[0]['evento']; ?></h3>
										<p><?php echo $eventoFotos[0]['descricao']; ?></p>
									</div>
									<div class="col-md-12 margin">
										<p>
											<a href="https://meutelao.com.br/telao/index.php?cod=<?php echo $eventoFotos[0]['cod']; ?>" target="_blank"><i class="ion-easel fa-2x left"></i> Acessar o Telão</a><br>
											<small>https://meutelao.com.br/telao/index.php?cod=<?php echo $eventoFotos[0]['cod']; ?></small>
										</p>
										
									</div>
								<?php   
										foreach ($eventoFotos as $eventoFoto){
								?>
								<div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">									
    										<img class="img-responsive" src="telao/fotos/<?php echo $eventoFoto['cod']; ?>/<?php echo $eventoFoto['titulo']; ?>" alt="" width="100%" style="max-height: 300px; max-width: 300px; overflow: hidden;" />
                                        </div>
                                    </div>
								</div>
								<?php
										}
									}
								?>                                
                            </div>
                        </div>
						
						<div class="container text-center">
                            
							<div class="row">
								<h3><a href="?pg=eventos">Outros Eventos</a></h3>
								<?php
									//Mostra o Eventos
									$eventos = DB::select("SELECT * FROM evento e WHERE e.id <> ? AND e.status = 'S' ORDER BY e.datacadastro DESC LIMIT 12", [$_GET['id']]);
									if($eventos){
										foreach ($eventos as $evento){
								?>
									<div class="col-lg-4">
										<div class="card">
											<div class="card-header">
												<h4><?php echo $evento['titulo']; ?></h4>
												<ul class="card-actions">
													<li>
														<span class="label label-app"><?php echo count($eventos); ?></span>
													</li>
												</ul>
											</div>
											<div class="js-slider slick-padding-dots" data-slider-dots="true" style="width: 360px; max-height: 200px">
											<?php
												//Mostra o Eventos
												$eventoFotos = DB::select('SELECT * FROM arquivos a WHERE a.idevento = ? ORDER BY RAND() LIMIT 1', [$evento['id']]);
												if($eventoFotos){
													foreach ($eventoFotos as $eventoFoto){
											?>
												<div style="width: 100%; display: flex;">
													<a href="?pg=eventos&id=<?php echo $evento['id']; ?>">
													<img class="img-responsive" src="telao/fotos/<?php echo $evento['cod']; ?>/<?php echo $eventoFoto['titulo']; ?>" alt="" style="max-height: 100px;" />
													</a>
												</div>
											<?php
													}
												}
											?>
											</div>
										</div>
									</div>
								<?php
										}
									}
								?>

                            </div>
                        </div>
                    </div>
                    <?php
                        } else {
                    ?>
                    <div class="section p-y-md">
                        <div class="container text-center">

                            <div class="row">
                            <?php
                                //Mostra o Eventos
                                $eventos = DB::select("SELECT * FROM evento e WHERE e.status = 'S' ORDER BY e.datacadastro DESC LIMIT 12");
                                if($eventos){
                                    foreach ($eventos as $evento){
                            ?>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><?php echo $evento['titulo']; ?></h4>
                                            <ul class="card-actions">
                                                <li>
                                                    <span class="label label-app"><?php echo count($eventos); ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="js-slider slick-padding-dots" data-slider-dots="true" style="width: 360px; max-height: 200px">
                                        <?php
                                            //Mostra o Eventos
                                            $eventoFotos = DB::select('SELECT * FROM arquivos a WHERE a.idevento = ? ORDER BY a.id DESC LIMIT 1', [$evento['id']]);
                                            if($eventoFotos){
                                                foreach ($eventoFotos as $eventoFoto){
                                        ?>
                                            <div style="width: 100%; display: flex;">
												<a href="?pg=eventos&id=<?php echo $evento['id']; ?>">
                                                <img class="img-responsive" src="telao/fotos/<?php echo $evento['cod']; ?>/<?php echo $eventoFoto['titulo']; ?>" alt="" />
												</a>
                                            </div>
                                        <?php
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                    }
                                }
                            ?>

                            </div>
                            <!-- .row -->
                        </div>
                        <!-- .container -->
                    </div>
                    <?php
                        }
                    ?>


                </main>

            </div>

        </div>




    </body>

</html>