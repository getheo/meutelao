<?php

require_once '../engine/DB.php';
require_once '../helpers/helpers.php';
include_once '../assets/js/plugins/PHP-FFMpeg-master/src/FFMpeg/FFMpeg.php';

//Verifica se a requisição é diferente de POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(500);
    echo json_encode(['Somente requisições do tipo POST.']);
    exit();
}

header('Content-Type: application/json');

//Recebe os dados da requisição
//$data = json_decode(file_get_contents('php://input'), true);

$data = array('idusuario'=>$_POST['idusuario'],'idevento'=>$_POST['idevento'],'cod'=>$_POST['cod'],'codArquivo'=>$_POST['codArquivo']);

//$data[0]['idusuario'] = $_POST['idusuario'];
//$data[1]['idevento'] = $_POST['idevento'];
//$data[2]['cod'] = $_POST['cod'];
//$data[3]['codArquivo'] = $_POST['codArquivo'];

//$arquivo = array($_FILES["arquivo"]);
//var_dump($_FILES["arquivo"]);

//$upload_image = basename($_FILES["arquivo"]["name"]);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['idusuario', 'O ID do usuario é obrigatório.'],
    ['idevento', 'O ID do evento é obrigatório.'],
    ['cod', 'O codigo do evento é obrigatório.'],
    ['codArquivo', 'O cod do Arquivo é obrigatório.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

$evento = DB::select('SELECT * FROM evento e WHERE e.id = ? AND cod = ?', [$data['idevento'],$data['cod']]);

if (!$evento) {
    http_response_code(422);
    echo json_encode(['Não existe este Evento.']);
    exit();
} else {

    for ($a = 0; $a < count($_FILES["arquivo"]["name"]); $a++){

        $extensao = strtolower(pathinfo($_FILES["arquivo"]["name"][$a],PATHINFO_EXTENSION));
        $novo_nome = md5($_FILES["arquivo"]["name"][$a].time()).".". $extensao; //define o nome do arquivo
        $novo_nome_sem_extensao = md5($_FILES["arquivo"]["name"][$a].time()); //define o nome do arquivo

        if(!is_dir("../telao/fotos/".$data['cod']."/")) {
            mkdir("../telao/fotos/".$data['cod']."/", 0777);
        }

        $path = "../telao/fotos/".$data['cod']."/".$novo_nome; //define o diretorio para onde enviaremos o arquivo
        //move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome); //efetua o upload
        //$path = "../telao/fotos/".$_FILES["arquivo"]["name"][$a];

        if($extensao=="mp4") {
            //Verifica se for um video tranforma em GIF animado
            $videoPath = $path;

            // The gif duration will be as long as the video/
            $ffprobe = FFProbe::create();
            $duration = (int)$ffprobe->format($videoPath)->get('duration');

            // The gif will have the same dimension. You can change that of course if needed.
            $dimensions = $ffprobe->streams($videoPath)->videos()->first()->getDimensions();

            $gifPath = "../telao/fotos/".$data['cod']."/".$novo_nome_sem_extensao.".gif";

            // Transform
            $ffmpeg = FFMpeg::create();
            $ffmpegVideo = $ffmpeg->open($videoPath);
            $ffmpegVideo->gif(TimeCode::fromSeconds(0), $dimensions, $duration)->save($gifPath);
        }



        DB::safeTransaction(function () use ($data, $a, $path, $novo_nome) {
            $sqlEventoArquivos = 'INSERT INTO arquivos (idevento, idtipo, titulo, datacadastro, status) VALUES (?, ?, ?, ?, ?)';
            $values = [$data['idevento'], 1, $novo_nome, date("Y-m-d H:i:s"), 'S'];
            $eventoArquivos = DB::action($sqlEventoArquivos, $values);

            move_uploaded_file($_FILES["arquivo"]["tmp_name"][$a], $path);

            if ($eventoArquivos) {
                //Log de Cadastro dos Arquivos
                $sqlLogArquivos = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
                $valuesLogArquivos = [$data['idusuario'], 'INSERT', 'ARQUIVOS', $_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
                DB::action($sqlLogArquivos, $valuesLogArquivos);
            }
        });
    }

    http_response_code(201);
    echo json_encode(['Arquivos cadastrados com sucesso.', $data['idevento'], $data['cod']]);
    exit();

    /*

    //Verifica os arquivos para publicar
    if($upload_image<>""){

            $extensao = strtolower(pathinfo($_FILES["arquivo"]["name"],PATHINFO_EXTENSION));
            //$extensao = strtolower(substr($_FILES["file_edital_arquivo"]["name"], -4)); //pega a extensao do arquivo
            $novo_nome = md5(time()).".". $extensao; //define o nome do arquivo
            //$diretorio = "noticia/$pasta/"; //define o diretorio para onde enviaremos o arquivo
            //move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome); //efetua o upload

            //Grava o nome da foto no perfil
            //$sqlFotoGrava = "INSERT INTO foto (foto_nome, foto_evento_id) VALUES ('$novo_nome', 1)";
            //$exeFotoGrava = mysqli_query($conexao,$sqlFotoGrava);

            $target_dir = "../telao/fotos/";
            $target_file = $target_dir . $novo_nome;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["registrarEventoArquivo"])) {
                $check = getimagesize($_FILES["arquivo"]["tmp_name"]);
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
            if ($_FILES["arquivo"]["size"] > 2000000) {
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
                if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $target_file)) {

                    $msg .= "<div class='alert alert-success' role='alert'>Foto publicada: $novo_nome</div>";
                }
            }
        } //Verifica Anexo


    DB::safeTransaction(function () use ($data, $novo_nome) {
        $sqlEventoArquivos = 'INSERT INTO arquivos (idevento, idtipo, titulo, datacadastro, status) VALUES (?, ?, ?, ?, ?)';
        $values = [$data['idevento'], 1, $novo_nome, date("Y-m-d H:i:s"), 'S'];
        $eventoArquivos = DB::action($sqlEventoArquivos, $values);

        if ($eventoArquivos) {
            //Log de Cadastro dos Arquivos
            $sqlLogArquivos = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
            $valuesLogArquivos = [$data['idusuario'], 'INSERT', 'ARQUIVOS', $_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
            DB::action($sqlLogArquivos, $valuesLogArquivos);
        }
    });
    */
}
