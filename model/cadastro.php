<?php

require_once '../engine/DB.php';
require_once '../helpers/helpers.php';

require_once '../assets/js/plugins/PHPMailer-master/src/PHPMailer.php';

//Verifica se a requisição é diferente de POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(500);
    echo json_encode(['Somente requisições do tipo POST.']);
    exit();
}

header('Content-Type: application/json');

//Recebe os dados da requisição
//$data = json_decode(file_get_contents('php://input'), true);

$data = array('cpf'=>preg_replace('/[^0-9]/', '', $_POST['cpf']),'nome'=>$_POST['nome'],'senha'=>$_POST['senha'],'email'=>$_POST['email'],'fone'=>preg_replace('/[^0-9]/', '', $_POST['fone']));

//$nome = filter_input($_POST['nome'], FILTER_SANITIZE_STRING);
//$cpf = preg_replace('/[0-9\@\.\;\" "]+/', '', $data['cpf']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['cpf', 'O CPF é obrigatório.'],
    ['nome', 'O Nome é obrigatório.'],
    ['senha', 'A senha é obrigatória.'],
    ['email', 'O Email é obrigatório.'],
    ['fone', 'O telefone ou celular é obrigatório.'],
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

$usuario = DB::select('SELECT * FROM usuario WHERE cpf = ?', [$data['cpf']]);
if ($usuario) {
    http_response_code(422);
    echo json_encode(['Usuario já existente.']);
    exit();
}

DB::safeTransaction(function () use ($data) {
    $sql = 'INSERT INTO usuario (nome, cpf, senha, email, fone, status, datacadastro, idnivel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $values = [$data['nome'], $data['cpf'], password_hash($data['senha'], PASSWORD_DEFAULT), $data['email'], $data['fone'], 'S', date("Y-m-d H:i:s"), 2];
    $user = DB::action($sql, $values);

    if($user){
        //Log de Cadastro
        $sqlLog = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $valuesLog = [$user, 'INSERT', 'SQL',$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
        DB::action($sqlLog, $valuesLog);

        $usuarioCadastrado = DB::select('SELECT * FROM usuario WHERE id = ?', [$user]);

        session_start();
        $_SESSION['id'] = $usuarioCadastrado[0]['id'];
        $_SESSION['nome'] = $usuarioCadastrado[0]['nome'];
        $_SESSION['cpf'] = $usuarioCadastrado[0]['cpf'];
        $_SESSION['senha'] = $usuarioCadastrado[0]['senha'];
        $_SESSION['email'] = $usuarioCadastrado[0]['email'];
        $_SESSION['fone'] = $usuarioCadastrado[0]['fone'];
        $_SESSION['idnivel'] = $usuarioCadastrado[0]['idnivel'];

        $sqlLog = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $valuesLog = [$usuarioCadastrado[0]['id'], 'INSERT', 'USUARIO',$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
        DB::action($sqlLog, $valuesLog);

        
        //Envia email com os dados de acesso
        $mail = new PHPMailer;

        $assunto = "Meu Telão - Cadastro de Usuário";
        $mensagem = "<h3>Meu Telão</h3><p>Plataforma de publicação e compartilhamento de imagens e videos em telões e smartvs.</p>";
        $mensagem .= "<p>Nome: ".$data['nome']."</p><p>CPF: ".$data['cpf']."</p><p>Nome: ".$data['email']."</p><p>Fone/Cel: ".$data['fone']."</p><p>Senha: ".$data['senha']."</p>";
		

        $mail->isSMTP();
        //$mail->Host = "h15.servidorhh.com";
		$mail->Host = "h61.servidorhh.com";		
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Username = "contato@meutelao.com.br";
        $mail->Password = "M39T3l@0";
        $mail->Port = 465;
        $mail->setFrom("contato@meutelao.com.br", "Meu Telão");
        $mail->addAddress($data['email'], $data['nome']);

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = nl2br($mensagem);
        $mail->AltBody = nl2br(strip_tags($mensagem));
        if($mail->send()) {
			
			http_response_code(201);
			echo json_encode(['Email enviado com sucesso.']);
			exit();

        } else {
            http_response_code(422);
            echo json_encode(['Erro de envio de email', $mail->ErrorInfo]);
            exit();
        }
		
		
		http_response_code(200);
		echo json_encode(['Cadastro efetuado com sucesso.']);
		exit();
    }
});

