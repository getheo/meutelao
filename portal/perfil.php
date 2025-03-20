<?php
if (strtolower(basename($_SERVER['REQUEST_URI'])) == strtolower(basename(__FILE__))) {
    exit("<div style='background-color: red; padding: 10px;'><strong>Código do erro</strong>: #CCR546<br><strong>Mensagem</strong>: Você não pode acessar este arquivo diretamente.</div>");
}

if(!isset($_SESSION['nome'])){
    session_destroy();
    echo "<meta http-equiv='refresh' content='0; url=https://meutelao.com.br/index.php?pg=login'>";
    exit();
}
?>

<!DOCTYPE html>


<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Perfil</title>

    </head>

    <body>

    <div class="container-fluid page-content">
        <div class="card card-profile col-md-10 col-md-offset-1">
            <div class="card-profile-img bg-img" style="background-image: url(assets/img/misc/base_pages_profile_header_bg.jpg);">
            </div>
            <div class="card-block card-profile-block text-xs-center text-sm-left">
                <img class="img-avatar img-avatar-96" src="assets/img/avatars/user.png" alt="" />
                <div class="profile-info font-500"><?php echo $_SESSION['nome']; ?>
                    <div class="small text-muted m-t-xs"><?php echo $_SESSION['email']; ?></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card">
                    <h3 class="card-header h4 text-center">Atualize seus dados</h3>
                    <div class="card-block">
                        <form name="formAtualizarPerfil" id="formAtualizarPerfil" class="js-validation-bootstrap form-horizontal" action="" method="POST" return false>

                            <div class="form-group">
                                <input class="form-control" type="hidden" id="id" name="id" value="<?php echo $_SESSION['id']; ?>">
                                <div class="col-sm-6">
                                    <label class="control-label" for="cpf">CPF <span class="text-orange">*</span></label>
                                    <input class="form-control" type="text" id="cpf" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label" for="nome">Nome <span class="text-orange">*</span></label>
                                    <input class="form-control" type="text" id="nome" name="nome" value="<?php echo $_SESSION['nome']; ?>" placeholder="Nome">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="control-label" for="email">Email <span class="text-orange">*</span></label>
                                    <input class="form-control" type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" placeholder="Email">
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label" for="fone">Fone / Cel <span class="text-orange">*</span></label>
                                    <input class="form-control" type="text" id="fone" name="fone" value="<?php echo $_SESSION['fone']; ?>" placeholder="Fone">
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label" for="senha">Senha <span class="text-orange">*</span></label>
                                    <input class="form-control" type="senha" id="senha" name="senha" value="<?php echo $_SESSION['senha']; ?>" placeholder="Senha">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button id="atualizar" class="btn btn-app btn-block" type="submit">Atualizar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- .card-block -->
                </div>
            </div>
        </div>

    </div>

    <script src="controller/perfil.js"></script>

    </body>

</html>