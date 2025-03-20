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
    <title>Eventos</title>

</head>

<body>

<div class="container-fluid page-content">
    <div class="card col-md-10 col-md-offset-1">
        <ul class="nav nav-tabs" data-toggle="tabs">
            <li class="active">
                <a href="#eventos">Eventos</a>
            </li>
            <li class="pull-right">
                <button onclick="window.location.href='index.php?pg=form_evento';" class="btn btn-app btn-block" type="button"><i class="fa fa-plus-circle"></i> Cadastrar</button>
            </li>

        </ul>
        <div class="card-block tab-content">

            <div class="tab-pane fade fade-in active in" id="eventos">
                <?php
                //Mostra o Evento conforme o cod
                $eventos = DB::select('SELECT * FROM evento e WHERE e.idusuario= ? ORDER BY e.datacadastro DESC', [$_SESSION['id']]);
                if($eventos){
                ?>
                <div class="b-b m-b-md">
                    <h2><strong><?php echo count($eventos); ?></strong> <small class="h5 text-muted">registro(s)</small></h2>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;"></th>
                            <th>Titulo</th>
                            <th class="hidden-xs w-30">Link</th>
                            <th class="text-center">Arquivos</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($eventos as $evento){
                        ?>
                        <tr>
                            <td class="text-center">
                                <img class="img-avatar img-avatar-48" src="assets/img/avatars/avatar1.jpg" alt="">
                            </td>
                            <td><strong><?php echo $evento['titulo']; ?></strong><br><span style="font-size: 0.8em;"><?php echo $evento['descricao']; ?></span><br><small class="label label-primary"><?php echo date("d/m/Y H:i", strtotime($evento['datacadastro'])); ?></small></td>
                            <td class="font-500"><a href="https://meutelao.com.br/telao/index.php?cod=<?php echo $evento['cod']; ?>" target="_blank"><span>https://meutelao.com.br/telao/index.php?cod=</span><?php echo $evento['cod']; ?></a></td>
                            <td class="text-center">
                            <?php
                                $arquivos = DB::select('SELECT count(id) AS CONT FROM arquivos a WHERE a.idevento = ?', [$evento['id']]);
                                echo "<small class='label label-green'>".$arquivos[0]['CONT']."</small>";
                            ?>


                            </td>
                            <td class="text-center">
                                <span class="label label-success"><?php echo $evento['status']; ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-xs btn-block btn-warning" type="button" data-toggle="tooltip" title="" data-original-title="Editar" onclick="window.location.href='index.php?pg=form_evento&id=<?php echo $evento['id']; ?>&cod=<?php echo $evento['cod']; ?>';"><i class="ion-edit"></i> Editar</button>
                                    <button class="btn btn-xs btn-block btn-danger" type="button"><i class="ion-close" data-toggle="tooltip" title="" data-original-title="Excluir"></i> Excluir</button>
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
                } else {
                ?>
                    <div class="alert alert-danger">
                        <p><strong>Erro!</strong> Sem registros de Eventos.</p>
                    </div>

                <?php
                }
                ?>

            </div>

        </div>
    </div>
</div>

<script src="controller/evento.js"></script>

</body>

</html>