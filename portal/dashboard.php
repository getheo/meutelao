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

<html>

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Dashboard</title>

    </head>

    <body class="app-ui">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">

                        <?php
                        if($_SESSION['cpf']=="91649692153"){
                            ?>
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <a class="card bg-green bg-inverse" href="?pg=usuario">
                                        <div class="card-block clearfix">
                                            <div class="pull-right">
                                                <p class="h6 text-muted m-t-0 m-b-xs">Usuários</p>
                                                <?php
                                                    $usuarios = DB::select("SELECT * FROM usuario u");
                                                ?>
                                                <p class="h3 m-t-sm m-b-0"><?= count($usuarios) ?? 0; ?></p>
                                            </div>
                                            <div class="pull-left m-r">
                                                <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-people fa-1-5x"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- .col-sm-6 -->

                                <div class="col-sm-6 col-lg-3">
                                    <a class="card" href="?pg=eventos">
                                        <div class="card-block clearfix">
                                            <div class="pull-right">
                                                <p class="h6 text-muted m-t-0 m-b-xs">Eventos</p>
                                                <?php
                                                    $eventos = DB::select("SELECT * FROM evento e");
                                                ?>
                                                <p class="h3 text-blue m-t-sm m-b-0"><?= count($eventos) ?? 0; ?></p>
                                            </div>
                                            <div class="pull-left m-r">
                                                <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- .col-sm-6 -->

                                <div class="col-sm-6 col-lg-3">
                                    <a class="card bg-blue bg-inverse" href="?pg=arquivos">
                                        <div class="card-block clearfix">
                                            <div class="pull-right">
                                                <p class="h6 text-muted m-t-0 m-b-xs">Arquivos</p>
                                                <?php
                                                    $arquivos = DB::select("SELECT * FROM arquivos a");
                                                ?>
                                                <p class="h3 m-t-sm m-b-0"><?= count($arquivos) ?? 0; ?></p>
                                            </div>
                                            <div class="pull-left m-r">
                                                <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-speedometer fa-1-5x"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- .col-sm-6 -->

                                <div class="col-sm-6 col-lg-3">
                                    <a class="card bg-purple bg-inverse" href="javascript:void(0)">
                                        <div class="card-block clearfix">
                                            <div class="pull-right">
                                                <p class="h6 text-muted m-t-0 m-b-xs">Mensagens</p>
                                                <p class="h3 m-t-sm m-b-0">3</p>
                                            </div>
                                            <div class="pull-left m-r">
                                                <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-email fa-1-5x"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- .col-sm-6 -->
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="row">
                        <div class="card">
                            <div id="timeline-1" class="">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-10 pull-right">
                                        <a class="btn btn-sm btn-success btn-block" href="?pg=form_evento"> <i class="fa fa-plus"></i> Adicionar</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">

                                        <div class="timeline-container">

                                        <?php
                                            if($_SESSION['idnivel']<>1){ 
                                                $eventos = DB::select('SELECT * FROM evento e WHERE e.idusuario = ? ORDER BY e.id DESC', [$_SESSION['id']]);
                                                
                                            } else {
                                                //Lista os Eventos Cadastrados pelo Usuario
                                                $eventos = DB::select('SELECT * FROM evento e ORDER BY e.id DESC');
                                                //var_dump($eventos);                    
                                            }
                                            
                                            if(!$eventos){
                                        ?>
                                                <div class="timeline-items">
                                                    <div class="timeline-item clearfix">
                                                        <div class="timeline-info">
                                                            <i class="timeline-indicator ace-icon fa fa-times btn btn-primary no-hover red"></i>
                                                        </div>

                                                        <div class="widget-box transparent">
                                                            <div class="widget-header widget-header-small">
                                                                <h5 class="widget-title smaller">Sem registros de Eventos</h5>
                                                            </div>

                                                            <div class="widget-body">
                                                                <div class="widget-main">
                                                                    <button class="btn btn-app-purple btn-block" onclick="window.location.href='index.php?pg=form_evento';" type="button">Criar meu 1º evento</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                        <?php
                                            } else {
                                                foreach ($eventos as $evento){
                                        ?>
                                            <div class="timeline-items">
                                                <div class="timeline-item clearfix">
                                                    <div class="timeline-info">
                                                        <i class="timeline-indicator ace-icon fa fa-calendar-check-o btn btn-app-green no-hover green"></i>
                                                    </div>

                                                    <div class="widget-box transparent">
                                                        <div class="widget-header widget-header-small">
                                                            <h5 class="widget-title smaller"><?php echo $evento['titulo']; ?></h5>
                                                            <span style="font-size: 0.8em;"><i class="ace-icon fa fa-clock-o bigger-110"></i> <?php echo date("d/m/Y H:i", strtotime($evento['datacadastro'])); ?></span>

                                                            <span class="widget-toolbar no-border">
                                                                <a href="https://meutelao.com.br/telao/index.php?cod=<?php echo $evento['cod']; ?>" target="_blank"><i class="ion-easel fa-2x"></i> https://meutelao.com.br/telao/index.php?cod=<strong><?php echo $evento['cod']; ?></strong></a>

                                                            </span>
                                                        </div>

                                                        <div class="widget-body">
                                                            <div class="widget-main">
                                                                <p><?php echo $evento['descricao']; ?></p>
                                                                <p>
                                                            <?php
                                                                //Verifica Arquivos de cada Evento
                                                                $arquivos = DB::select("SELECT * FROM arquivos a WHERE a.idevento = ? ORDER BY a.id DESC LIMIT 8", [$evento['id']]);
                                                                if($arquivos):
                                                                    foreach ($arquivos as $arquivo):
                                                            ?>

                                                                    <img class="img-responsive img-rounded" src="telao/fotos/<?php echo $evento['cod']; ?>/<?php echo $arquivo['titulo']; ?>" alt="" style="position: relative; float: left; max-width: 60px; margin: 1px;">


                                                            <?php
                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="widget-body">
                                                            <span class="widget-toolbar no-border">
                                                                <a class="btn btn-app-green btn-block" href="?pg=form_evento&id=<?php echo $evento['id']; ?>&cod=<?php echo $evento['cod']; ?>"> <i class="fa fa-pencil-square-o"></i> Editar </a>

                                                            </span>

                                                        </div>

                                                        <div style="clear: both;">&emsp;</div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            } }
                                         ?>
                                            <div class="timeline-item clearfix">
                                                <div class="timeline-info">
                                                    <i class="timeline-indicator ace-icon fa fa-clock-o btn btn-primary no-hover"></i>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </body>

</html>