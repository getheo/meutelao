<?php
    //if(!isset($_SESSION['id'])){ header("Location: index.php?pg=dashborad"); }
?>
<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Informe o COD</title>

        <meta name="description" content="Meu Telão - COD" />
        <meta name="robots" content="noindex, nofollow" />
    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <main class="app-layout-content">

                    <!-- Page header -->
                    <div class="page-header bg-green bg-inverse">
                        <div class="container">
                            <!-- Section Content -->
                            <div class="p-y-xs text-center">
                                <h1 class="display-2">Informe o COD</h1>
                                <p class="text-muted">Após o registro de um novo evento será gerado um código. Insira este código no campo abaixo para vizualizar as imagens no telão, pc ou smartvs.</p>
                            </div>
                            <!-- End Section Content -->
                        </div>
                    </div>
                    <!-- End Page header -->

                    <!-- Page content -->
                    <div class="page-content">
                        <div class="container">
                            <div class="row">

                                <!-- Sign up -->
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="card">
                                        <h3 class="card-header h4 text-center">Informe o Código</h3>
                                        <div class="card-block">
                                            <div class="col-md-12">
                                                <?php
                                                    if(isset($_GET['msg']) && $_GET['msg']=="Erro"){
                                                ?>
                                                        <div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                            <p><strong>Erro!</strong> Não foi encontrado telão com o código informado.</p>
                                                        </div>
                                                <?php
                                                    }
                                                ?>

                                            </div>

                                            <form name="formtelao" id="formtelao" class="js-validation-bootstrap form-horizontal" action="telao/index.php" method="GET">

                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Cód.: </button>
                                                        </span>
                                                        <input class="form-control" type="text" id="cod" name="cod" placeholder="Ex: 86VZ102K">
                                                    </div>
                                                </div>

                                                <div style="clear: both;">&emsp;</div>

                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <button id="pesquisar" class="btn btn-app btn-block" type="submit">Pesquisar</button>
                                                    </div>
                                                </div>

                                            </form>

                                            <div style="clear: both;">&emsp;</div>
                                        </div>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                </main>

            </div>

        </div>

        <script src="controller/cadastro.js"></script>

    </body>

</html>