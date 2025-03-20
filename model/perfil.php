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

$data = array('id'=>$_POST['id'],'cpf'=>$_POST['cpf'],'nome'=>$_POST['nome'],'email'=>$_POST['email'],'fone'=>$_POST['fone'],'senha'=>$_POST['senha']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['id', 'O ID é obrigatório.'],
    ['cpf', 'O CPF é obrigatório.'],
    ['nome', 'O Nome é obrigatório.'],
    ['email', 'O Email é obrigatório.'],
    ['fone', 'O telefone ou celular é obrigatório.'],
    ['senha', 'A senha é é obrigatório.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

$usuario = DB::select('SELECT * FROM usuario WHERE id = ?', [$data['id']]);
if (!$usuario) {
    http_response_code(422);
    echo json_encode(['Usuario não existente.']);
    exit();
}

DB::safeTransaction(function () use ($data) {
    $sql = 'UPDATE usuario SET nome = ?, cpf = ?, email = ?, fone = ?, dataatualizacao = ? WHERE id = ?';
    $values = [$data['nome'], $data['cpf'], $data['email'], $data['fone'], date("Y-m-d H:i:s"), $data['id']];
    DB::action($sql, $values);

    $usuarioAtualizar = DB::select('SELECT * FROM usuario WHERE id = ?', [$data['id']]);

    session_start();
    $_SESSION['id'] = $usuarioAtualizar[0]['id'];
    $_SESSION['nome'] = $usuarioAtualizar[0]['nome'];
    $_SESSION['cpf'] = $usuarioAtualizar[0]['cpf'];
    $_SESSION['senha'] = $usuarioAtualizar[0]['senha'];
    $_SESSION['email'] = $usuarioAtualizar[0]['email'];
    $_SESSION['fone'] = $usuarioAtualizar[0]['fone'];
    $_SESSION['idnivel'] = $usuarioAtualizar[0]['idnivel'];

});

http_response_code(201);
echo json_encode(['Dados do usuário atualizado com sucesso.']);
exit();
