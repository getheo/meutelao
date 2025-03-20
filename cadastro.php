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
        <title>Meu Telão - Cadastro</title>

        <meta name="description" content="Meu Telão Cadastro" />
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
                                <h1 class="display-2">Cadastre-se</h1>
                                <p class="text-muted">Aproveite esta oportunidade para testar a plataforma durante 1 mês gratis.</p>
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
                                        <h3 class="card-header h4 text-center">Cadastro</h3>
                                        <div class="card-block">
                                            <form name="formcadastro" id="formcadastro" class="js-validation-bootstrap form-horizontal" action="" method="POST">

                                                <div class="form-group">
                                                    <input class="form-control" type="hidden" id="senha" name="senha" value="<?php echo gerar_senha(6, true, false, true, false); ?>" />
                                                    <div class="col-sm-6">
                                                        <label class="control-label" for="cpf">CPF <span class="text-orange">*</span></label>
                                                        <input class="form-control" type="text" id="cpf" name="cpf" value="" placeholder="CPF" data-mask="000.000.000-00" />

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="control-label" for="nome">Nome <span class="text-orange">*</span></label>
                                                        <input class="form-control" type="text" id="nome" name="nome" value="" placeholder="Nome" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-6">
                                                        <label class="control-label" for="email">Email <span class="text-orange">*</span></label>
                                                        <input class="form-control" type="email" id="email" name="email" value="" placeholder="Email" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="control-label" for="fone">Fone / Cel <span class="text-orange">*</span></label>
                                                        <input class="form-control" type="text" id="fone" name="fone" value="" placeholder="Fone" data-mask="(00) 0 0000-0000" />
                                                    </div>
                                                </div>

                                                <button id="registrar" class="btn btn-app btn-block" type="submit">Registrar</button>
                                            </form>											
                                        </div>
										
										<div class="card-block" style="clear:both; min-height: 100px;">
											<div class="col-md-6 margin">
												<div class="alert alert-success"><strong><a href="?pg=login"> Acessar o portal</a></strong></div>												
											</div>
											<div class="col-md-6 margin">
												<div class="alert alert-warning"><p><strong><a href="?pg=esqueci">Esqueceu a senha?</a></strong></p></div>
												
											</div>
										</div>										
                                        <!-- .card-block -->
										
                                    </div>
                                    <!-- .card -->
                                </div>
                                <!-- .col-md-6 -->
                                <!-- End sign up -->

                            </div>
                            <!-- .row -->
                        </div>
                        <!-- .container -->
                    </div>
                    <!-- End page content -->


                </main>

            </div>

        </div>

        <script src="controller/cadastro.js"></script>

    </body>

</html>