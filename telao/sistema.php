<?php
	include_once("includes/conexao.php");
	//Upload Documentos
	$upload_image = basename($_FILES["upload_image"]["name"]);

	if(isset($_POST["form_submit"])) {
		
		if($upload_image<>""){
			
			$extensao = strtolower(pathinfo($_FILES["upload_image"]["name"],PATHINFO_EXTENSION));	
			//$extensao = strtolower(substr($_FILES["file_edital_arquivo"]["name"], -4)); //pega a extensao do arquivo
			$novo_nome = md5(time()).".". $extensao; //define o nome do arquivo
			//$diretorio = "noticia/$pasta/"; //define o diretorio para onde enviaremos o arquivo
			//move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome); //efetua o upload

			//Grava o nome da foto no perfil
			$sqlFotoGrava = "INSERT INTO foto (foto_nome, foto_evento_id) VALUES ('$novo_nome', 1)";
			$exeFotoGrava = mysqli_query($conexao,$sqlFotoGrava);

			$target_dir = "fotos/";
			$target_file = $target_dir . $novo_nome;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["form_submit"])) {
				$check = getimagesize($_FILES["upload_image"]["tmp_name"]);
				if($check !== false) {
					$msg = "<div class='w3-panel w3-green'><h3>Ok!</h3><p>Arquivo é uma imagem - " . $check["mime"] . ".</p></div>";
					$uploadOk = 1;
				} else {
					$msg = "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo não é uma imagem</p></div>";
					$uploadOk = 0;
				}
}

			// Check if file already exists
			if (file_exists($target_file)) {
				$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo não existente</p></div>";
				$uploadOk = 0;
			}
			
			// Check file size
			if ($_FILES["upload_image"]["size"] > 2000000) {
				$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo muito grande</p></div>";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" 
			&& $imageFileType != "bmp" ) {
				$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>Somente JPG, PNG, GIF, BMP são aceitos.</p></div>";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>Arquivo não enviado</p></div>";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["upload_image"]["tmp_name"], $target_file)) {
					
					$msg .= "<div class='alert alert-success' role='alert'>Foto publicada: $novo_nome</div>";
				}
			}
		} //Verifica Anexo
		
	}

	if(isset($_POST["apagar_foto"])) {
		
		$sqlFotoApagar = "DELETE FROM foto WHERE foto.foto_id = '".$_POST["apagar_foto"]."'";
		$exeFotoApagar = mysqli_query($conexao,$sqlFotoApagar);
		//$verFotos = mysqli_fetch_array($exeFotoApagar,MYSQLI_ASSOC));
		
		if($exeFotoApagar){			
			$msg .= "<div class='alert alert-success' role='alert'>Foto apagda com sucesso:</div>";			
		} else {
			$msg .= "<div class='alert alert-danger' role='alert'>Erro ao apagar a foto</div>";
		}
	}

	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Afonso 1 Ano</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">	
	
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<style type="text/css">
		.timeline {
    position: relative;
    padding: 21px 0px 10px;
    margin-top: 4px;
    margin-bottom: 30px;
}

.timeline .line {
    position: absolute;
    width: 4px;
    display: block;
    background: currentColor;
    top: 0px;
    bottom: 0px;
    margin-left: 30px;
}

.timeline .separator {
    border-top: 1px solid currentColor;
    padding: 5px;
    padding-left: 40px;
    font-style: italic;
    font-size: .9em;
    margin-left: 30px;
}

.timeline .line::before { top: -4px; }
.timeline .line::after { bottom: -4px; }
.timeline .line::before,
.timeline .line::after {
    content: '';
    position: absolute;
    left: -4px;
    width: 12px;
    height: 12px;
    display: block;
    border-radius: 50%;
    background: currentColor;
}

.timeline .panel {
    position: relative;
    margin: 10px 0px 21px 70px;
    clear: both;
}

.timeline .panel::before {
    position: absolute;
    display: block;
    top: 8px;
    left: -24px;
    content: '';
    width: 0px;
    height: 0px;
    border: inherit;
    border-width: 12px;
    border-top-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
}

.timeline .panel .panel-heading.icon * { font-size: 20px; vertical-align: middle; line-height: 40px; }
.timeline .panel .panel-heading.icon {
    position: absolute;
    left: -59px;
    display: block;
    width: 40px;
    height: 40px;
    padding: 0px;
    border-radius: 50%;
    text-align: center;
    float: left;
}

.timeline .panel-outline {
    border-color: transparent;
    background: transparent;
    box-shadow: none;
}

.timeline .panel-outline .panel-body {
    padding: 10px 0px;
}

.timeline .panel-outline .panel-heading:not(.icon),
.timeline .panel-outline .panel-footer {
    display: none;
}

	</style>
	
</head>

<body>
	<div class="container">	
		<div class="row">
			<div class="col-md-12" style="text-align: center;"><a href="sistema.php"><img src="img/afonso.jpg" width="100%" style="max-width: 780px;" /></div>
		<div class="col-md-12" style="text-align: center;">
			<?php echo $msg; ?>
			<form action="" method="post" enctype="multipart/form-data" style="text-align: center;">
				<div class="form-group">
					<lable class="">Publique as imagens</lable>
					<input type="file" name="upload_image" required />
				</div>
				<input type="submit" name="form_submit" class="btn btn-primary" value="Publicar" />
			</form>
		</div>
	</div>
		
	</div>
	
	<div class="container">
	<div class="timeline">
    
        <!-- Line component -->
        <div class="line text-muted"></div>

    <?php
		$sqlFotos = "SELECT * FROM foto WHERE foto.foto_evento_id=1 ORDER BY foto_id DESC";
		$exeFotos = mysqli_query($conexao,$sqlFotos);
		while($verFotos = mysqli_fetch_array($exeFotos,MYSQLI_ASSOC)){
	?>
		<article class="panel panel-default panel-outline">
    
            <!-- Icon -->
            <div class="panel-heading icon">
                <i class="glyphicon glyphicon-picture"></i>
            </div>
            <!-- /Icon -->
    
            <!-- Body -->
            <div class="panel-body">
                <img class="img-responsive img-rounded" src="fotos/<?php echo $verFotos['foto_nome']; ?>" style="max-width: 300px;" />
            </div>
            <!-- /Body -->
			
			
    
        </article>
	<?php
		}
	?>
    </div>
	</div>
	
</body>
</html>