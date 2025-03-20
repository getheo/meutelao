<?php

require_once '../engine/DB.php';
require_once '../helpers/helpers.php';

//Verifica se a requisição é diferente de POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(500);
    echo json_encode(['Somente requisições do tipo POST.']);
    exit();
}

//if(!isset($_POST['cpf'])){ echo "<script>alert('Aki')</script>"; }

header('Content-Type: application/json');

//Recebe os dados da requisição
$data = json_decode(file_get_contents('php://input'), true);
//var_dump($data);

$data = array('id'=>$_POST['id'],'cpf'=>$_POST['cpf'],'nome'=>$_POST['nome'],'email'=>$_POST['email'],'fone'=>$_POST['fone']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['id', 'O ID é obrigatório.'],
    ['cpf', 'O CPF é obrigatório.'],
    ['nome', 'O Nome é obrigatório.'],
    ['email', 'O Email é obrigatório.'],
    ['fone', 'O telefone ou celular é obrigatório.'],
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
    echo json_encode(['Usuario já existente.']);
    exit();
}

$userAtualizar = DB::safeTransaction(function () use ($data) {
    $sql = 'UPDATE usuario SET nome = ?, cpf = ?, email = ?, fone = ?, dataatualizacao = ? WHERE id = ?';
    $values = [$data['nome'], $data['cpf'], $data['email'], $data['fone'], date("Y-m-d H:i:s"), $data['id']];
    DB::action($sql, $values);
});

if($userAtualizar){

    $userAtualizado = DB::select('SELECT * FROM usuario WHERE id = ?', [$userAtualizar]);
    /*
    session_start();
    $_SESSION['user'] = $user;
    $_SESSION['expire'] = date('Y-m-d H:i:s', strtotime('+360 minutes'));
    $_SESSION['nome'] = $data['nome'];
    $_SESSION['cpf'] = $data['cpf'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['datacadastro'] = $data['datacadastro'];
    $_SESSION['fone'] = $data['fone'];
    $_SESSION['fone'] = $data['fone'];
    */

}

http_response_code(201);
echo json_encode(['Dados do usuário atualizado com sucesso.']);
exit();
