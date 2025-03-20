<?php

require_once '../engine/DB.php';
require_once '../helpers/helpers.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/js/plugins/PHPMailer-master/src/Exception.php';
require '../assets/js/plugins/PHPMailer-master/src/PHPMailer.php';
require '../assets/js/plugins/PHPMailer-master/src/SMTP.php';


//Verifica se a requisição é diferente de POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(500);
    echo json_encode(['Somente requisições do tipo POST.']);
    exit();
}

header('Content-Type: application/json');

//Recebe os dados da requisição
//$data = json_decode(file_get_contents('php://input'), true);

$data = array('cpf'=>preg_replace('/[^0-9]/', '', $_POST['cpf']));

//$nome = filter_input($_POST['nome'], FILTER_SANITIZE_STRING);
//$cpf = preg_replace('/[0-9\@\.\;\" "]+/', '', $data['cpf']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
    ['cpf', 'O CPF é obrigatório.']
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

try {
	
	$usuario = DB::select('SELECT * FROM usuario WHERE cpf = ?', [$data['cpf']]);
	
	if (!$usuario) {
		http_response_code(422);
		echo json_encode(['Usuario não encontrado.']);
		exit();
	} else {
		
		$sqlLog = 'INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$valuesLog = [$usuario[0]['id'], 'SELECT', 'USUARIO ESQUECEU SENHA',$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
		DB::action($sqlLog, $valuesLog);		
		
		// Monta o HTML para envio do email
		$assunto = "Meu Telão - Esqueceu a senha";
		//$mensagem = "<p><strong>Meu Telão</strong></p>";
		$mensagem = "<p><img src='https://meutelao.com.br/assets/img/logo/MeuTelaoLogo.jpg' width='150' /></p>";		
		$mensagem .= "<p>Plataforma de publicação e compartilhamento de imagens e videos em telões e smartvs.</p>";
		$mensagem .= "<p>Nome: <strong>".$usuario[0]['nome']."</strong></p>";
		$mensagem .= "<p>CPF: <strong>".$usuario[0]['cpf']."</strong></p>";
		$mensagem .= "<p>Nome: <strong>".$usuario[0]['email']."</strong></p>";
		$mensagem .= "<p>Fone/Cel: <strong>".$usuario[0]['fone']."</strong></p>";
		$mensagem .= "<p>Acesse o link para atualizar a senha: <a href='https://meutelao.com.br/index.php?pg=esqueci&cod=".$usuario[0]['senha']."'>LINK</a></p>";
		//$mensagem .= "<p>Senha: ".password_verify($data['senha'], $usuario[0]['senha'])."</p>";	
		
		//Envia email com os dados de acesso
		$mail = new PHPMailer();
		//var_dump($mail);
		//187.45.189.73
		
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
		$mail->isSMTP();		
		$mail->Host = "h61.servidorhh.com";			
		$mail->SMTPAuth = true;
		$mail->Username = "contato@meutelao.com.br";
		$mail->Password = "M39T3l@0";
		$mail->SMTPSecure = "ssl";
		//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;	
		$mail->Port = 465;
		
		$mail->setFrom("contato@meutelao.com.br", utf8_decode("Meu Telão"));
		$mail->addAddress($usuario[0]['email'], $usuario[0]['nome']);
		//$mail->addReplyTo('web@getheo.com.br', 'Meu Telão - Esqueci a senha');
		$mail->addBCC('web@getheo.com.br');
		
		//var_dump($mail);
		//exit;
		
		//$mail->SMTPDebug = 3;
		//$mail->Debugoutput = 'html';
		//$mail->setLanguage('pt');

		$mail->isHTML(true);
		$mail->Subject = utf8_decode($assunto);
		$mail->Body    = utf8_decode(nl2br($mensagem));
		$mail->AltBody = utf8_decode(nl2br(strip_tags($mensagem)));
		if($mail->send()) { $enviado = true; } else { $enviado = false; }
		
		if($enviado == true){
			http_response_code(200);
			echo json_encode(['Usuario Encontrado e dados de acesso enviado no email!']);
			exit();
		} else {
			http_response_code(422);
			echo json_encode(['Erro de envio de email', $mail->ErrorInfo]);
			exit();			
		}
		
		//var_dump($mensagem);	
		//var_dump($mail);
		
		//http_response_code(200);
		//echo json_encode(['Sucesso no envio dos dados.']);
		//exit();		
	
		
	}

} catch (Exception $e) {	
	http_response_code(422);
	echo json_encode(['Erro de acesso.']);
	exit();	
}

