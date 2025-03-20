<?php

require_once '../engine/DB.php';
require_once '../helpers/helpers.php';

//Verifica se a requisição é diferente de POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(500);
    echo json_encode(['Somente requisições do tipo POST.']);
    exit();
}

header('Content-Type: application/json');

//Recebe os dados da requisição
//$data = json_decode(file_get_contents('php://input'), true);

$data = array('titulo'=>$_POST['titulo'],'descricao'=>$_POST['descricao'],'idusuario'=>$_POST['idusuario'],'idevento'=>$_POST['idevento'],'cod'=>$_POST['cod'],'status'=>$_POST['status'],'idordem'=>$_POST['idordem']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['titulo', 'O titulo é obrigatório.'],
	['descricao', 'A descricao é obrigatória.'],
	['idusuario', 'O idusuario é obrigatório.'],
    ['idevento', 'O titulo é obrigatório.'],    
    ['cod', 'O Cod é obrigatório.'],
	['status', 'O status é obrigatório.'],
	['idordem', 'A ordem é obrigatória.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}
$atualizarEvento = "";

try {
	$cod = DB::select("SELECT * FROM evento e WHERE e.id = ?", [$data['idevento']]);

	//var_dump($data);
	//exit;

	if (!$cod) {
		http_response_code(422);
		echo json_encode(['Não existe este evento.']);
		exit();
	} else {
		
		$atualizarEvento = DB::safeTransaction(function () use ($data) {
			$sqlEventoAplicar = 'UPDATE evento SET titulo = ?, descricao = ?, status = ?, idordem = ? WHERE id = ? AND cod = ?';
			$values = [$data['titulo'], $data['descricao'], $data['status'], $data['idordem'], $data['idevento'], $data['cod']];
			$eventoAplicar = DB::action($sqlEventoAplicar, $values);

			if ($eventoAplicar) {
				//var_dump($eventoAplicar);
				//exit;
		
				//Log de Evento Aplicar
				$sqlLog = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
				$valuesLog = [$data['idusuario'], 'UPDATE', 'EVENTO APLICAR', $_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
				DB::action($sqlLog, $valuesLog);
			}
			http_response_code(200);
			echo json_encode(['Ajustes aplicado para o Evento.', $data['cod']]);
			exit();
		});
	}

} catch (Exception $e) {	
	http_response_code(422);
	echo json_encode(['Erro de acesso.']);
	exit();	
}
