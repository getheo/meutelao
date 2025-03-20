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

$data = array('cpf'=>preg_replace('/[^0-9]/', '', $_POST['cpf']),'senha'=>$_POST['senha']);
//var_dump($data);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['cpf', 'O CPF é obrigatório.'],
    ['senha', 'A senha é obrigatória.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

try {
	
	//$senhaCript = password_hash($data['senha'], PASSWORD_DEFAULT);
	//var_dump($senhaCript);
	
	$usuario = DB::select("SELECT * FROM usuario u WHERE u.cpf = ?", [$data['cpf']]);
	//var_dump($usuario);
	
	if ($usuario) {
		
		$senhaCript = password_verify($data['senha'], $usuario[0]['senha']);
		
		if (password_verify($data['senha'], $usuario[0]['senha'])) {
			//echo "Password is valid: ".$senhaCript;
			$usuarioValido = true;			
			//var_dump($usuario);
			
		} else {
			//echo 'Invalid password.';
			$usuarioValido = false;
			http_response_code(422);
			echo json_encode(['Senha incorreta.']);
			exit();
		}	
		
	} else {
		//echo 'Invalid password.';
		$usuarioValido = false;
		http_response_code(422);
		echo json_encode(['CPF não encontrado.']);
		exit();
	}
	
	//$usuarioSenha = DB::select("SELECT * FROM usuario WHERE cpf = '?' AND senha = '?'", [$data['cpf'], $senhaCript]);	
	
	if ($usuarioValido === true) {
		
		//$senhaDecript = password_verify($data['senha'], $usuario[0]['senha']);
		//echo json_encode(['Senha errada.']);
		//exit();		
		//$usuarioSenha = DB::select("SELECT * FROM usuario WHERE cpf = '?' AND senha = '?'", [$data['cpf'], $senhaDecript]);			
		//var_dump($senhaDecript);
		DB::safeTransaction(function () use ($usuario) {
			$sql = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
			$values = [$usuario[0]['id'], 'LOGIN', 'USUARIO',$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
			DB::action($sql, $values);

			session_start();
			$_SESSION['id'] = $usuario[0]['id'];
			$_SESSION['nome'] = $usuario[0]['nome'];
			$_SESSION['cpf'] = $usuario[0]['cpf'];
			$_SESSION['senha'] = $usuario[0]['senha'];
			$_SESSION['email'] = $usuario[0]['email'];
			$_SESSION['fone'] = $usuario[0]['fone'];
			$_SESSION['idnivel'] = $usuario[0]['idnivel'];
		});
		
		//var_dump($senhaDecript);
		http_response_code(200);
		echo json_encode(['Login no portal realizado com sucesso.']);
		exit();
	}
	
	//$senha_verifica = password_verify($data['senha'], $usuario[0]['senha']);	
	//$usuarioSenha = DB::select('SELECT * FROM usuario WHERE cpf = ? AND senha = ?', [$data['cpf'], $senha_verifica]);
	//var_dump($data);
	//var_dump($acessou);
	//exit;	
	
} catch (Exception $e) {	
	http_response_code(422);
	echo json_encode(['Erro de acesso.']);
	exit();	
}

//var_dump($usuarioSenha);





