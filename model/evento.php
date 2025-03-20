<?php

require_once '../engine/DB.php';
require_once '../helpers/helpers.php';

// API QRCod
include('../phpqrcode/qrlib.php');
include('../phpqrcode/qrconfig.php');

//Verifica se a requisição é diferente de POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(500);
    echo json_encode(['Somente requisições do tipo POST.']);
    exit();
}

header('Content-Type: application/json');

//Recebe os dados da requisição
$data = json_decode(file_get_contents('php://input'), true);

$data = array('idusuario'=>$_POST['idusuario'],'titulo'=>$_POST['titulo'],'descricao'=>$_POST['descricao'],'cod'=>$_POST['cod']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['idusuario', 'O idusuario é obrigatório.'],
    ['titulo', 'O titulo é obrigatório.'],
    ['descricao', 'O descrição é obrigatório.'],
    ['cod', 'O Cod é obrigatório.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

$cod = DB::select('SELECT * FROM evento WHERE idusuario = ? AND cod = ?', [$data['idusuario'], $data['cod']]);
if ($cod) {
    http_response_code(422);
    echo json_encode(['Evento já registrado.']);
    exit();
} else {
    DB::safeTransaction(function () use ($data) {
        $sqlEvento = 'INSERT INTO evento (idusuario, titulo, descricao, cod, datacadastro, status) VALUES (?, ?, ?, ?, ?, ?)';
        $values = [$data['idusuario'], $data['titulo'], $data['descricao'], $data['cod'], date("Y-m-d H:i:s"), 'N'];
        $evento = DB::action($sqlEvento, $values);
		
		$verEvento = DB::select('SELECT * FROM evento WHERE cod = ?', [$data['cod']]);		
		$eventoId = $verEvento[0]['id'];

        if ($evento) {
			
			// Cria o diretoria e seta permissao
			if(!is_dir("../telao/fotos/".$data['cod']."/")) {
				mkdir("../telao/fotos/".$data['cod']."/", 0777);
			}
		
			// Salvar PNG com link    
			$tempDir = "../telao/fotos/".$data['cod']."/";
			
			$codeContents = "https://meutelao.com.br/telao/index.php?cod=".$data['cod'];
			
			$fileName = $data['cod'].".png";
			
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = "../telao/fotos/".$data['cod']."/".$fileName;
			
			// generating
			if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath);
				
				//Grava no Banco a Imagem PNG
				$sqlGravaPng = "INSERT INTO arquivos (idevento, idtipo, titulo, datacadastro, status, destaque) VALUES (?, ?, ?, ?, ?, ?)";
				$valuesGravaPng = [$eventoId, '3', $fileName, date("Y-m-d H:i:s"), 'S', 1];
				DB::action($sqlGravaPng, $valuesGravaPng);
				
				$textoQrCod = "Criou o PNG do QRCod";
				
			} else {
				$textoQrCod = "Erro ao criar o PNG do QRCod";
			} 
	
            //Log de Cadastro
            $sqlLog = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
            $valuesLog = [$data['idusuario'], 'INSERT', 'EVENTO: '.$textoQrCod." [ ".$ultimoId." ]", $_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
            DB::action($sqlLog, $valuesLog);
        }
    });

    http_response_code(201);
    echo json_encode(['Evento registrado com sucesso. Agora cadastre as fotos e/ou videos.', $data['cod']]);
    exit();
}
