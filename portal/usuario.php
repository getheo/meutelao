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
    <title>Usuários</title>

</head>

<body>

<div class="container-fluid page-content">
    <div class="card col-md-10 col-md-offset-1">
        <ul class="nav nav-tabs" data-toggle="tabs">
            <li class="active">
                <a href="?pg=usuario">Usuários</a>
            </li>
            <li class="pull-right">
                <button onclick="window.location.href='index.php?pg=usuario';" class="btn btn-app" type="button"><i class="fa fa-users"></i> Usuários</button>
                <button onclick="window.location.href='index.php?pg=form_usuario';" class="btn btn-app" type="button"><i class="fa fa-plus-circle"></i> Cadastrar</button>
            </li>

        </ul>
        <div class="card-block tab-content">

            <div class="tab-pane fade fade-in active in" id="usuarios">
                <?php
                //Mostra o Evento conforme o cod
				if(!empty($_GET['idusuario'])){
					$usuarios = DB::select('SELECT * FROM usuario u WHERE u.id = ?', [$_GET['idusuario']]);					
				} else {
					$usuarios = DB::select('SELECT * FROM usuario u ORDER BY u.datacadastro DESC');
				}
                if(count($usuarios)>1){
                ?>
                <div class="b-b m-b-md">
                    <h2><strong><?php echo count($usuarios); ?></strong> <small class="h5 text-muted">registro(s)</small></h2>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;"></th>
                            <th class="hidden-xs w-30">Nome</th>
                            <th class="text-center">Email</th>
							<th class="text-center">CPF</th>
                            <th class="text-center">Fone</th>
							<th class="text-center">Data</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($usuarios as $usuario){
                        ?>
                        <tr>
                            <td class="text-center"><img class="img-avatar img-avatar-48" src="assets/img/avatars/avatar1.jpg" alt=""></td>
                            <td><strong><?php echo $usuario['nome']; ?></strong></td>
                            <td class="font-500"><?php echo $usuario['cpf']; ?></td>
							<td class="text-center"><?php echo $usuario['email']; ?></td>
                            <td class="text-center"><?php echo $usuario['fone']; ?></td>
                            <td class="text-center"><small class="label label-primary"><?php echo date("d/m/Y H:i", strtotime($usuario['datacadastro'])); ?></small></td>
							<td class="text-center"><small class="label label-success"><?php echo $usuario['status']; ?></small></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <!--<button class="btn btn-xs btn-block btn-warning" type="button" data-toggle="tooltip" title="" data-original-title="Editar" onclick="window.location.href='index.php?pg=usuario&idusuario=<?php echo $usuario['id']; ?>"><i class="ion-edit"></i> Editar</button>
                                    <button class="btn btn-xs btn-block btn-danger" type="button"><i class="ion-close" data-toggle="tooltip" title="" data-original-title="Excluir"></i> Excluir</button>-->
									<a href="?pg=usuario&idusuario=<?php echo $usuario['id']; ?>" class="btn btn-xs btn-block btn-warning" data-toggle="tooltip" title="" data-original-title="Editar"><i class="ion-edit"></i> Editar</a>
                                </div>

                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="b-t">
                    <ul class="pagination m-b-0">
                        <li class="disabled"><a href="javascript:void(0)">Prev</a></li>
                        <li class="active"><a href="javascript:void(0)">1</a></li>
                        <li><a href="javascript:void(0)">2</a></li>
                        <li><span>...</span></li>
                        <li><a href="javascript:void(0)">10</a></li>
                        <li><a href="javascript:void(0)">Next</a></li>
                    </ul>
                </div>
                <?php
                } elseif(count($usuarios)==0) {
                ?>
                    <div class="alert alert-danger">
                        <p><strong>Erro!</strong> Sem registros de Usuários.</p>
                    </div>

                <?php
                } else {
                ?>

                <div class="card">                    
                    <div class="card-block">
                    <?php 
                        foreach ($usuarios as $usuario){
                    ?>
                        <form action="" method="post" onsubmit="return false;">                            
                            <div class="form-group">
                                <input name="id" type="hidden" value="<?php echo $usuario['id']; ?>" requerid>
                                <label>Atualizar os dados</label>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input name="nome" class="form-control" type="text" placeholder="" value="<?php echo $usuario['nome']; ?>" requerid>
                                    </div>
                                    <div class="col-xs-6">
                                        <input name="cpf" class="form-control" type="text" placeholder="" value="<?php echo $usuario['cpf']; ?>" requerid>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <input name="email" class="form-control" type="text" placeholder="" value="<?php echo $usuario['email']; ?>" requerid>
                                    </div>
                                    <div class="col-xs-4">
                                        <input name="fone" class="form-control" type="text" placeholder="" value="<?php echo $usuario['fone']; ?>" requerid>
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="status">Status</label>
                                        <input name="status" id="status" class="form-control" type="checkbox" <?php if($usuario['status']=="S"){ echo "checked"; } ?> >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <small>Data cadastro: <?php echo $usuario['datacadastro']; ?></small>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="form-group m-b-0">
                                <button class="btn btn-app" type="submit" name="atualizar" id="atualizar">Atualizar</button>
                            </div>
                        </form>
                    <?php 
                        }
                    ?>
                    </div>
                    <!-- .card-block -->
                </div>

                <?php 
                }
                ?>

            </div>

        </div>
    </div>
</div>

<script src="controller/usuario.js"></script>

</body>

</html>