<?php include_once("../engine/DB.php"); ?>
<!doctype html>
<htmlv class="app-ui">
<head>
<meta charset="utf-8">
<title>Meu Telão</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta http-equiv="refresh" content="30">

<body>
	<!--<button onclick="abrirTelao()">MEU TELÃO</button>
	<div id="perfil">This is a DIV element.</div>-->
	<script>
	function abrirTelao() {
		var element = document.getElementById("perfil");
		element.classList.toggle("perfil_div");
	}
	</script>

	<div class="row text-center">
        <div class="col-sm-4 col-sm-offset-4 text-center">
                <button class="btn btn-xs btn-app-outline" data-toggle="modal" data-target="#modal-large" type="button"><img class="img-responsive" src="../assets/img/logo/meutelao_logo.svg" title="Meu Telão" alt="Meu Telão" width="100" style="background-color: #FFF;"></button>            
        </div>
    </div>

    <!-- Large Modal -->
    <div class="modal" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header bg-green bg-inverse">
                    <h4><?php echo $titulo; ?></h4>
                    <ul class="card-actions">
                        <li><button data-dismiss="modal" type="button"><i class="ion-close"></i></button></li>
                    </ul>
                </div>
                <div class="card-block">
                    <p><?php echo $descricao; ?></p>
                </div>
                <div class="modal-footer">
                	<p style="font-size: 0.8em;">Desenvolvolvido por <a href="https://meutelao.com.br"><img class="img" src="../assets/img/logo/meutelao_logo.svg" title="Meu Telão" alt="Meu Telão" width="80"></a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Large Modal -->

	<div class="mosaicflow" data-item-height-calculation="attribute">	
		
	<?php
    //1º verifica o COD para mostrar as fotos de cada evento
    if(isset($_GET['cod']) && $_GET['cod']<>""){	
        

        if($evento){
			
			$valor = $evento[0]['valor'];
			// Lista os Arquivos do Evento
			$eventoArquivos = DB::select("SELECT * FROM arquivos a WHERE a.idevento = ? ORDER BY ".$valor." LIMIT 20", [$evento[0]['id']]);
			
			//var_dump($eventoArquivos);
			
            foreach ($eventoArquivos as $eventoArquivo){
                $rand = rand(0,9);
				
				if($eventoArquivo['destaque']==0){ $tamanho = "500"; $carrega = 1; }else{ $tamanho = "1000"; $carrega = 3; }
        ?>
                <div class="mosaicflow__item">
                <?php
				/*
                //Lista POST quando $rand(impar)
                if($rand==3 && $repete==0){
                    ?>
                    <img width="278" src="post/post1.jpg" alt="" class="carrega1">
                    <?php
                    $repete=1;
                }
				*/
                ?>
                <?php
				/*
                //Lista QRCOD quando $rand(par)
                if($rand==2 && $repete==1){
                    ?>
                    <img width="300" src="post/qrcod.png" alt="" class="carrega1">
                    <?php
                    $repete=0;
                }
				*/
                ?>
                <?php
					//Verifica tipo arquivo
					$extensao = strtolower(pathinfo($eventoArquivo['titulo'],PATHINFO_EXTENSION));
					//$novo_nome = md5($_FILES["arquivo"]["name"][$a].time()).".". $extensao; //define o nome do arquivo
					if($extensao <> "mp4"){
				?>
                        <img width="<?php echo $tamanho; ?>" src="fotos/<?php echo $evento[0]['cod']; ?>/<?php echo $eventoArquivo['titulo']; ?>" alt="<?php echo $eventoArquivo['destaque']; ?>" class="carrega<?php echo $carrega; ?>">
				<?php
					}
				?>
                </div>
                <!--<video width="100%" controls><source src="" type="video/mp4"></video>-->
        <?php

            }
        } else {
            echo "<meta http-equiv='refresh' content='0; URL=../index.php?pg=telao&msg=Erro' />";
        }
    } else {
        //echo "<script>alert('Sem registro')</script>";
        echo "<meta http-equiv='refresh' content='0; URL=../index.php?pg=telao&msg=Erro' />";

    }

    ?>
	</div>
	
</body>
</html>
