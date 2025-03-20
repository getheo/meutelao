<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Login</title>

        <meta name="description" content="Meu Telão Login" />
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
                                <h1 class="display-2">Realize o Login</h1>
                                <p class="text-muted">Após o acesso crie um novo evento e realize as postagens das fotos e videos.</p>
                            </div>
                            <!-- End Section Content -->
                        </div>
                    </div>
                    <!-- End Page header -->

                    <!-- Page content -->
                    <div class="page-content">
                        <div class="container">
                            <div class="row">
                                <!-- Login card -->
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="card">
                                        <h3 class="card-header h4">Login</h3>
                                        <div class="card-block">
                                            <form name="formlogin" id="formlogin" action="" method="POST">
                                                <div class="form-group">
                                                    <label class="sr-only" for="cpf">Email</label>
                                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" data-mask="000.000.000-00" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="senha">Password</label>
                                                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" />
                                                </div>
                                                <button type="submit" class="btn btn-app btn-block">Acessar</button>
                                            </form>
                                        </div>
										<div class="card-block" style="clear:both; min-height: 100px;">
											<div class="col-md-6 margin">
												<div class="alert alert-success"><strong><a href="?pg=cadastro"> Cadastrar</a></strong></div>												
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
                                <!-- End login -->

                            </div>
                            <!-- .row -->
                        </div>
                        <!-- .container -->
                    </div>
                    <!-- End page content -->


                </main>

            </div>

        </div>
        <script src="controller/login.js"></script>
    </body>

</html>