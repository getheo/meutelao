<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Contato</title>

        <meta name="description" content="AppUI - Frontend Template & UI Framework" />
        <meta name="robots" content="noindex, nofollow" />

        
    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <main class="app-layout-content">

                    <!-- Page header -->
                    <div class="page-header bg-app bg-inverse">
                        <div class="container">
                            <div class="p-y-xs text-center">
                                <h1 class="display-2">Contato</h1>
                                <p class="text-muted">Precisa de outras informações sobre a plataforma, planos ou outras dúvidas, entre em contato.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End page header -->

                    <div class="page-content bg-white">
                        <div class="container">
                            <!-- Section Content -->
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <form class="form-horizontal" action="" method="post">
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <label for="frontend-contact-firstname">Seu nome</label>
                                                <input class="form-control" type="text" id="contatoNome" name="contatoNome" />
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="frontend-contact-lastname">Fone/Cel</label>
                                                <input class="form-control" type="text" id="contatoFone" name="contatoFone" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="frontend-contact-email">Email</label>
                                                <input class="form-control" type="email" id="contatoEmail" name="contatoEmail" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="frontend-contact-subject">Sobre o que?</label>
                                                <select class="form-control" id="contatoAssunto" name="contatoAssunto" size="1">
                                                    <option value="1">Suporte</option>
                                                    <option value="2">Planos</option>
                                                    <option value="3">Gerenciamento</option>
                                                    <option value="4">Outras</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="frontend-contact-msg">Mensagem</label>
                                                <textarea class="form-control" id="contatoMsg" name="contatoMsg" rows="7"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <button class="btn btn-app btn-block" type="submit">Enviar mensagem</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- .row -->
                            <!-- End Section Content -->
                        </div>
                        <!-- .container -->
                    </div>
                    <!-- .section -->

                </main>

            </div>
            <!-- .app-layout-container -->
        </div>
        <!-- .app-layout-canvas -->

        <!-- Page JS Code -->
        <script src="assets/js/pages/contato.js"></script>

    </body>

</html>