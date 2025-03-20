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
$data = json_decode(file_get_contents('php://input'), true);

$data = array('idarquivo'=>$_POST['idarquivo'],'idevento'=>$_POST['idevento'],'idusuario'=>$_POST['idusuario']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['idarquivo', 'O ID do Evento é obrigatório.'],
    ['idevento', 'O ID do evento é obrigatório.'],
    ['idusuario', 'O ID do usuario é obrigatório.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

$arquivos = DB::select('SELECT * FROM arquivos a WHERE id = ? AND idevento = ?', [$data['idarquivo'], $data['idevento']]);
if (!$arquivos) {
    http_response_code(422);
    echo json_encode(['Não existe arquivos deste Evento.']);
    exit();
} else {
    DB::safeTransaction(function () use ($data) {
        $sqlArquivoExcluir = 'DELETE FROM arquivos WHERE id = ? AND idevento = ?';
        $values = [$data['idarquivo'], $data['idevento']];
        $exeArquivoExcluir = DB::action($sqlArquivoExcluir, $values);

        if ($exeArquivoExcluir) {
            //Log de Cadastro dos Arquivos
            $sqlLogArquivoExcluir = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
            $valuesLogArquivos = [$data['idusuario'], 'DELETE', 'ARQUIVOS', $_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
            DB::action($sqlLogArquivoExcluir, $valuesLogArquivos);
        }
    });

    http_response_code(201);
    echo json_encode(['Arquivo excluido com sucesso.']);
    exit();
}
