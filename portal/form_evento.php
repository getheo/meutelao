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
        <title>Meu Telão - Evento Cadastrar</title>

        <meta name="description" content="Meu Telão Evento" />
        <meta name="robots" content="noindex, nofollow" />
    </head>

    <body class="app-ui">
        <div class="container-fluid page-content">

            <div class="card card-profile col-md-10 col-md-offset-1">
                <?php
                    if(empty($_GET['cod'])):
                ?>
                    <h3 class="card-header h4 text-center">Registre um novo Evento</h3>
                    <div class="card-block">
                        <form name="formEvento" id="formEvento" class="js-validation-bootstrap form-horizontal" action="" method="POST">
                            <div class="form-group">
                                <input class="form-control" type="hidden" id="idusuario" name="idusuario" value="<?php echo $_SESSION['id']; ?>" />
                                <input class="form-control" type="hidden" id="cod" name="cod" value="<?php echo gerar_senha(8, true, false, true, false); ?>" />
                                <div class="col-sm-12">
                                    <label class="control-label" for="titulo">Título <span class="text-orange">*</span></label>
                                    <input class="form-control" type="text" id="titulo" name="titulo" value="" placeholder="Insira um título" />

                                </div>
                                <div class="col-sm-12">
                                    <label class="control-label" for="descricao">Nome <span class="text-orange">*</span></label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="6" placeholder="Escreva uma breve descrição"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button id="registrarEvento" class="btn btn-app btn-block" type="submit"><i class="fa fa-plus"></i> Clique para cadastrar Fotos e Videos</button>
                                </div>

                            </div>

                        </form>
                    </div>
                <?php
                    else:
                        
                        //echo "disabled"; 
                        $eventoCod = DB::select("SELECT e.id AS id, e.idusuario AS idusuario, e.titulo AS titulo, e.descricao AS descricao, e.cod AS cod, e.datacadastro AS datacadastro, e.status AS status, e.idordem AS idordem, o.valor AS valor FROM evento e LEFT JOIN ordem o ON e.idordem = o.id WHERE e.cod = ?", [$_GET['cod']]);
                        
                        //Verifica se o COD e o ID são válidos
                        //$eventoCod = DB::select("SELECT e.id AS id, o.valor AS valor FROM evento e LEFT JOIN ordem o ON e.idordem = o.id WHERE e.cod = ?", [$_GET['cod']]);

                        //Mostra o Evento conforme o cod
						//var_dump($eventoCod);
                        if($eventoCod){
							
							//Verifica as fotos e videos cadastrados para este Evento
							$eventoArquivos = DB::select("SELECT e.titulo AS eventoTitulo, e.id AS idevento, e.cod AS cod, e.status AS status, e.idordem AS idordem, a.id AS id, a.titulo AS titulo, a.destaque AS destaque FROM arquivos a LEFT JOIN evento e ON a.idevento = e.id LEFT JOIN ordem o ON e.idordem = o.id WHERE a.idevento = ? ORDER BY ".$eventoCod[0]['valor'], [$eventoCod[0]['id']]);
							//var_dump($eventoArquivos);
							
							if($eventoArquivos) { $contArquivos = count($eventoArquivos); } else { $contArquivos = 0;} 

                ?>
                    <h3 class="card-header h4 text-center">Cadastre JPG, PNG ou GIFs para o Evento</h3>
                    <div class="card-block">
						<h3 class="text-info"><i class="fa fa-calendar"></i> <?php echo $eventoCod[0]['titulo']; ?></h3>						
						<p><?php echo date("d/m/Y H:i:s", strtotime($eventoCod[0]['datacadastro'])); ?></p>
						<div class="col-md-12 text-center">
							<small><u><a href="https://meutelao.com.br/telao/index.php?cod=<?php echo $eventoCod[0]['cod']; ?>" target="_blank">https://meutelao.com.br/telao/index.php?cod=<?php echo $eventoCod[0]['cod']; ?></a></u></small>
						</div>
						
                    </div>
					
					<div class="card-block">						

						<div class="col-md-6">
							<p><a href="https://meutelao.com.br/telao/index.php?cod=<?php echo $eventoCod[0]['cod']; ?>" target="_blank"><i class="ion-easel fa-2x left"></i> Acessar o Telão</a></p>
						</div>

						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">Cód.: </button>
								</span>
								<input class="form-control" type="text" id="cod" name="cod" value="<?php echo $eventoCod[0]['cod']; ?>" readonly>
							</div>
						</div>
                    </div>

                    <div class="card-block" style="z-index: 99999;">
                        <form name="formEventoArquivos" id="formEventoArquivos" class="js-validation-bootstrap form-horizontal" action="" method="POST" enctype="multipart/form-data" onsubmit="return submitForm()">							
                            <div class="form-group">
                                <input type="hidden" name="MAX_FILE_SIZE" value="5120000" />
                                <input class="form-control" type="hidden" id="idusuario" name="idusuario" value="<?php echo $_SESSION['id']; ?>" />
                                <input class="form-control" type="hidden" id="idevento" name="idevento" value="<?php echo $eventoCod[0]['id']; ?>" />
                                <input class="form-control" type="hidden" id="cod" name="cod" value="<?php echo $_GET['cod']; ?>" />
                                <input class="form-control" type="hidden" id="codArquivo" name="codArquivo" value="<?php echo gerar_senha(10, true, false, true, false); ?>" />
                                <div class="col-sm-12">
                                    <label class="control-label" for="arquivo">JPG, PNG ou GIF<span class="text-orange">*</span></label>


                                    <button type="button" name="arquivo" id="arquivo" onclick="selectFiles()" accept="video/*,image/*">Selecione imagens</button>
                                </div>

                            </div>

                            <div id="root" class="form-group">
                                <div class="col-md-12">
                                    <div id="selected-images"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
								<?php
									// Mostrar até cont = 100
									//if($contArquivos<100){
								?>
									<button class="btn btn-success btn-block" type="submit"><i class="fa fa-plus"></i> Cadastrar Imagens</button>
								<?php
									//} else { echo ""; }
								?>                                    
                                </div>
                            </div>
                        </form>

                        <script type='text/javascript'>

                            const MAX_WIDTH = 980;
                            const MAX_HEIGHT = 1280;
                            const MIME_TYPE = "image/*";
                            const QUALITY = 0.7;

                            const input = document.getElementById("arquivo");
                            input.onchange = function (ev) {
                                const file = ev.target.files[0]; // get the file
                                const blobURL = URL.createObjectURL(file);
                                const img = new Image();
                                img.src = blobURL;
                                img.onerror = function () {
                                    URL.revokeObjectURL(this.src);
                                    // Handle the failure properly
                                    console.log("Cannot load image");
                                };
                                img.onload = function () {
                                    URL.revokeObjectURL(this.src);
                                    const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                                    const canvas = document.createElement("canvas");
                                    canvas.width = newWidth;
                                    canvas.height = newHeight;
                                    const ctx = canvas.getContext("2d");
                                    ctx.drawImage(img, 0, 0, newWidth, newHeight);
                                    canvas.toBlob(
                                        (blob) => {
                                            // Handle the compressed image. es. upload or save in local state
                                            displayInfo('Original file', file);
                                            displayInfo('Compressed file', blob);
                                        },
                                        MIME_TYPE,
                                        QUALITY
                                    );
                                    document.getElementById("root").append(canvas);
                                };
                            };

                            function calculateSize(img, maxWidth, maxHeight) {
                                let width = img.width;
                                let height = img.height;

                                // calculate the width and height, constraining the proportions
                                if (width > height) {
                                    if (width > maxWidth) {
                                        height = Math.round((height * maxWidth) / width);
                                        width = maxWidth;
                                    }
                                } else {
                                    if (height > maxHeight) {
                                        width = Math.round((width * maxHeight) / height);
                                        height = maxHeight;
                                    }
                                }
                                return [width, height];
                            }

                            // Utility functions for demo purpose

                            function displayInfo(label, file) {
                                const p = document.createElement('p');
                                p.innerText = `${label} - ${readableBytes(file.size)}`;
                                document.getElementById('root').append(p);
                            }

                            function readableBytes(bytes) {
                                const i = Math.floor(Math.log(bytes) / Math.log(1024)),
                                    sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                                return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
                            }


                            var selectedImages = [];
                            function selectFiles() {
                                $.FileDialog({
                                    "accept": "image/*"
                                }).on("files.bs.filedialog", function (event) {
                                    var html = "";
                                    for (var a = 0; a < event.files.length; a++){
                                        selectedImages.push(event.files[a]);
                                        html += "<img src='" + event.files[a].content +"' style='width: 100px; margin: 10px;' />";
                                    }
                                    document.getElementById("selected-images").innerHTML = html;
                                });
                            }
                            function submitForm() {
                                var formEventoArquivos = document.getElementById("formEventoArquivos");
                                var formData = new FormData(formEventoArquivos);

                                for(var a = 0; a < selectedImages.length; a++){
                                    formData.append("arquivo[]", selectedImages[a]);
                                }
                                var loaderajax = document.getElementById("loaderajax");
                                $("#loaderajax").css("display","block");

                                var ajax = new XMLHttpRequest();
                                ajax.open("POST","./model/arquivo.php", true);
                                ajax.send(formData);

                                ajax.onreadystatechange = function () {
                                    if(this.readyState == 4 && this.status == 201){
                                        //console.log(this.responseText);
                                        $("#loaderajax").css("display","none");
                                        //alert("Arquivos publicados com sucesso!");
                                        Swal.fire('Pronto!', 'Arquivos publicados', 'success')
                                        .then((res) => {
                                            if(res.isConfirmed){
                                                window.location.reload(true)
                                            }
                                        })
                                    }

                                };

                                return false;
                            }
                        </script>
                    </div>

                    <div class="card-block">						
                    <?php
                    // Mostra arquivos do Evento
					if($eventoArquivos){
                        ?>
						<div class="col-md-12">
						<form name="formAplicacao" id="formAplicacao" action="" method="POST">						
							<div class="form-group">
								<label class="control-label" for="titulo">Título <span class="text-orange">*</span></label>
								<input class="form-control" type="text" id="titulo" name="titulo" value="<?php echo $eventoCod[0]['titulo']; ?>" />
							</div>							
							
							<div class="form-group">
								<label class="control-label" for="descricao">Nome <span class="text-orange">*</span></label>
								<textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo $eventoCod[0]['descricao']; ?></textarea>
							</div>
							
							<input class="form-control" type="hidden" id="idusuario" name="idusuario" value="<?php echo $_SESSION['id']; ?>" />
                            <input class="form-control" type="hidden" id="idevento" name="idevento" value="<?php echo $eventoCod[0]['id']; ?>" />
                            <input class="form-control" type="hidden" id="cod" name="cod" value="<?php echo $_GET['cod']; ?>" />
							<div class="form-group" style="margin-top:20px;">
								<div class="col-md-3">
									<h3 class="text-info"><i class="fa fa-picture-o"></i> <?php echo $contArquivos; ?> Arquivos</h3>
								</div>
								 
								<div class="col-md-3">
									<div class="form-group">
										<select class="form-control" aria-label="status" name="status" id="status" style="<?php if($_SESSION['idnivel']<>1){ echo "display:none;"; } ?>" >
											<option value="S" <?php if($eventoCod[0]['status']=="S"){ echo "selected"; } ?> >Mostrar</option>
											<option value="N" <?php if($eventoCod[0]['status']=="N"){ echo "selected"; } ?>>Ocultar</option>                                    
										</select>
									</div>
								</div>
															
								<div class="col-md-4">
									<div class="form-group">
										<select class="form-control" aria-label="idordem" name="idordem" id="idordem">
											<option value="1" <?php if($eventoCod[0]['idordem']==1){ echo "selected"; } ?> >Aleatório</option>
											<option value="2" <?php if($eventoCod[0]['idordem']==2){ echo "selected"; } ?> >Crescente</option>
											<option value="3" <?php if($eventoCod[0]['idordem']==3){ echo "selected"; } ?> >Decrescente</option>
										</select>
									</div>
								</div>
								<div class="col-md-2 pull-right">							
									<button class="btn btn-success btn-block" type="submit"><i class="fa fa-plus"></i> Aplicar</button>														
								</div>
							</div>
						</form>
                        </div>						
						<div style="clear: both;"> </div>
						<div class="form-group">
						<?php
							foreach ($eventoArquivos as $eventoArquivo){

                                //$qrCod = strripos($eventoArquivo['cod'], $eventoArquivo['titulo']);
                                //if ($qrCod === false) { $qrCodValor = ""; } else { $qrCodValor = "disabled"; }                                
                                //if (strpos($eventoArquivo['titulo'], $eventoArquivo['cod']) !== false) { $qrCodValor = "disabled"; } else { $qrCodValor = ""; }
						?>
							<div class="col-md-12 col-sm-6 col-lg-3">
								<div class="card" style="border: 1px solid #ccc;">
									<div class="card-header no-border">
										
											<span class="text-left">
												<small style="font-size: 0.6em;">Destaque</small>
												<input type="checkbox" class="arquivoDestaque" id="arquivoDestaque" name="arquivoDestaque[]" data-idevento="<?php echo $eventoArquivo['idevento']; ?>" data-id="<?php echo $eventoArquivo['id']; ?>" data-idusuario="<?php echo $_SESSION['id']; ?>" data-destaque="<?php if($eventoArquivo['destaque']>0) { echo 0; } else { echo 1; } ?>" <?php if($eventoArquivo['destaque']>0) { echo "checked"; } ?> />
											</span>										                                    
											<span class="text-right">
                                            <?php
                                                if (strpos($eventoArquivo['titulo'], $eventoArquivo['cod']) === false) {
                                            ?>
												<small style="font-size: 0.6em;">Apagar</small>
												<button type="button" class="arquivoApagar" id="arquivoApagar" name="arquivoApagar[]" data-idevento="<?php echo $eventoArquivo['idevento']; ?>" data-id="<?php echo $eventoArquivo['id']; ?>" data-idusuario="<?php echo $_SESSION['id']; ?>"><i class="fa fa-trash-o"></i></button>
                                            <?php 
                                                }
                                            ?>
											</span>
											
										
									</div>

									<div class="card-block text-center bg-img" style="background-image: url('telao/fotos/<?php echo $eventoArquivo['cod']; ?>/<?php echo $eventoArquivo['titulo']; ?>');">
										<img class="img-avatar img-avatar-96 img-avatar-thumb" src="assets/img/avatars/user.png" alt="">
									</div>
									<small style="font-size: 0.6em; align-content: center;"><?php echo $eventoArquivo['titulo']; ?></small>
								</div>
							</div>
						<?php
							}
						?>
                        <?php
                    } else {
                        ?>
                        <h3 class="text-info"><i class="fa fa-close"></i> Sem registros de fotos e/ou videos</h3>
                        <?php
                    }
                    ?>
						</div>
                    </div>
                <?php
                        } else { echo "<meta http-equiv='refresh' content='0; url=index.php?pg=evento'>"; }
                ?>
                <?php
                    endif;
                ?>
                    <div style="clear: both;">&emsp;</div>
                </div>

        </div>

        <script src="controller/evento.js"></script>

    </body>

</html>