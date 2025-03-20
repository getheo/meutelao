<?php include_once("../engine/DB.php"); ?>
<!doctype html>
<htmlv class="app-ui">
<head>
<meta charset="utf-8">
<title>Meu Telão</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

<?php
	if(isset($_GET['cod']) && $_GET['cod']<>""){

		$carrega=1;		
		$evento = DB::select("SELECT e.id AS id, e.titulo AS titulo, e.descricao AS descricao, e.cod AS cod, o.ordem AS ordem, o.valor AS valor FROM evento e LEFT JOIN ordem o ON e.idordem = o.id WHERE e.cod = ?", [$_GET['cod']]);

		$eventoFoto = DB::select("SELECT a.titulo FROM arquivos a WHERE a.idevento = ? ORDER BY a.id LIMIT 1,1", [$evento[0]['id']]);

		$site_name = "Meu Telão";
		$titulo = $evento[0]['titulo'];
		$descricao = $evento[0]['descricao'];
		$id = $evento[0]['id'];
		$codUrl = "https://meutelao.com.br/telao/?cod=".$evento[0]['cod'];		
		$imgUrl = "https://meutelao.com.br/telao/fotos/".$evento[0]['cod']."/".$eventoFoto[0]['titulo'];

	} else {

		$site_name = "Meu Telão";
		$titulo = "Ideal para festas, jogos, bares, restaurantes e outros.";		
		$descricao = "Compartilhe seus eventos em telões e smartTVs, PCs e nas Redes Sociais";
		$id = "";
		$codUrl = "https://meutelao.com.br/";
		$imgUrl = "https://meutelao.com.br/telao/post/post.jpg";
	}
?>
<!--start Facebook Open Graph Protocol-->
<meta name="description" content="<?php echo $description; ?>">
<title>Meu Telão - Home</title>
<meta property="og:type" content="website">
<meta property="og:locale" content="pt_BR">
<meta property="og:site_name" content="Meu Telão"/>
<meta property="og:title" content="<?php echo $titulo; ?>"/>
<meta property="og:description" content="<?php echo $descricao; ?>"/>

<meta property="og:url" content="<?php echo $codUrl; ?>"/>
<meta property="og:image" content="<?php echo $imgUrl; ?>"/>

<!--end Facebook Open Graph Protocol-->

<!-- AppUI CSS stylesheets -->
<link rel="stylesheet" id="css-font-awesome" href="../assets/css/font-awesome.css" />
<link rel="stylesheet" id="css-ionicons" href="../assets/css/ionicons.css" />
<link rel="stylesheet" id="css-bootstrap" href="../assets/css/bootstrap.css" />
<link rel="stylesheet" id="css-app" href="../assets/css/app.css" />
<link rel="stylesheet" id="css-app-custom" href="../assets/css/app-custom.css" />
<!-- End Stylesheets -->


<script type="text/javascript" src="assets/js/whatsapp-button.js"></script>

<meta name="description" content="Meu Telão - <?php echo $descricao; ?>" />
<meta name="robots" content="noindex, nofollow" />

<style type="text/css">
* { margin:0; padding:0; box-sizing:border-box; }

body{ background:#000; }
.mosaicflow__column {
	float:left;
}

.mosaicflow__item {
	position:relative;
	margin:2px;
	}
	.mosaicflow__item img {
		display:block;
		width:100%;
		max-width:1200px;
		height:auto;
		opacity:0;
		}
	.mosaicflow__item video {
		display:block;
		width:100%;
		max-width:900px;
		height:320px;
		opacity:0;
		}
	.mosaicflow__item p {
		position:absolute;
		bottom:0;
		left:0;
		width:100%;
		margin:0;
		padding:5px;
		background:hsla(0,0%,0%,.5);
		color:#fff;
		font-size:14px;
		text-shadow:1px 1px 1px hsla(0,0%,0%,.75);
		opacity:0;
		-webkit-transition: all 0.4s cubic-bezier(0.23,1,0.32,1);
		   -moz-transition: all 0.4s cubic-bezier(0.23,1,0.32,1);
		     -o-transition: all 0.4s cubic-bezier(0.23,1,0.32,1);
		        transition: all 0.4s cubic-bezier(0.23,1,0.32,1);
		}
	.mosaicflow__item:hover p {
		opacity:1;
		}
	.perfil_div {
	  width: 100%;
	  padding: 10px;
	  background-color: coral;	  
	  font-size: 2em;
	  box-sizing: border-box;
	  
	  background-color: #04AA6D;
		color: white;
		font-family: 'Source Sans Pro', sans-serif;
		font-size: 18px;
		padding: 6px 25px;
		margin-top: 4px;
		border-radius: 5px;
		word-spacing: 10px;

	}
	</style>
</head>

<body>
	<div style="position: relative; float: left; width: 100%; height: 50px;">
	
		<div class="row text-center">
			<div class="col-sm-4 col-sm-offset-4 text-center">
					<button class="btn btn-xs btn-app-outline" data-toggle="modal" data-target="#modal-large" type="button"><img class="img-responsive" src="../assets/img/logo/meutelao_logo.svg" title="Meu Telão" alt="Meu Telão" width="100" style="background-color: #FFF;"></button>            
			</div>
		</div>
		
	</div>
	<div style="position: relative; float: left; width: 100%; height: 50px;">
		<iframe src="conteudo.php&cod=<?php echo $_GET['cod']; ?>" width="100%" style="min-height: 800px; height: 100%;"></iframe>
	</div>

<script src="js/jquery.min.js"></script>
	<script src="js/jquery.mosaicflow.js"></script>
	<script >
    $(document).ready(function(){

        	$('.mosaicflow__item .carrega1').animate({ opacity: 1.0 }, 1000 );
			$('.mosaicflow__item .carrega2').animate({ opacity: 1.0 }, 2000 );
			$('.mosaicflow__item .carrega3').animate({ opacity: 1.0 }, 3000 );

    });
</script>

	<div class="app-ui-mask-modal"></div>

	<!-- AppUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock and App.js -->
	<script src="../assets/js/core/jquery.min.js"></script>
	<script src="../assets/js/core/bootstrap.min.js"></script>
	<script src="../assets/js/core/jquery.slimscroll.min.js"></script>
	<script src="../assets/js/core/jquery.scrollLock.min.js"></script>
	<script src="../assets/js/core/jquery.placeholder.min.js"></script>
	<script src="../assets/js/app.js"></script>
	<script src="../assets/js/app-custom.js"></script>	
	
</body>
</html>
