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

$data = array('cpf_alterar'=>preg_replace('/[^0-9]/', '', $_POST['cpf_alterar']),'nome_alterar'=>$_POST['nome_alterar'],'senha_alterar'=>$_POST['senha_alterar'],'senha_repete_alterar'=>$_POST['senha_repete_alterar'],'email_alterar'=>$_POST['email_alterar'],'fone_alterar'=>preg_replace('/[^0-9]/', '', $_POST['fone_alterar']));

//$nome = filter_input($_POST['nome'], FILTER_SANITIZE_STRING);
//$cpf = preg_replace('/[0-9\@\.\;\" "]+/', '', $data['cpf']);

//Valida inputs obrigatórios
$errors = validateJSON($data, [
	['nome_alterar', 'O Nome é obrigatório.'],
    ['cpf_alterar', 'O CPF é obrigatório.'],
	['email_alterar', 'O Email é obrigatório.'],
	['fone_alterar', 'O CPF é obrigatório.'],
	['senha_alterar', 'A senha é obrigatória.'],
	['senha_repete_alterar', 'Repita a NOVA senha.']
]);

//Envia os inputs que não passaram na validação
if ($errors) {
    http_response_code(422);
    echo json_encode($errors);
    exit();
}

// Verifica se senha e repetir a senha são iguais
if ($data['senha_alterar'] != $data['senha_repete_alterar']) {
    http_response_code(422);
    echo json_encode(['A senha deve ser igual.']);
    exit();
}

try {
	
	$usuario = DB::select("SELECT * FROM usuario WHERE cpf = ?", [$data['cpf_alterar']]);	
	
	if (!$usuario) {
		http_response_code(422);
		echo json_encode(['Usuario não encontrado.']);
		exit();
	} else {
		
		//var_dump($usuario);
		//exit;
		
		// Atualiza os dados do usuario
		$usuarioAtualizar = DB::safeTransaction(function () use ($data) {
			$sqlAlterar = "UPDATE usuario SET senha = ?, dataatualizacao = ? WHERE u.cpf = ?";
			$valuesAlterar = [password_hash($data['senha_alterar'], PASSWORD_DEFAULT), date("Y-m-d H:i:s"), $data['cpf_alterar']];
			$userAlterar = DB::action($sqlAlterar, $valuesAlterar);			
		});
		
		if($usuarioAtualizar){
			
			$sqlLog = "INSERT INTO log (idusuario, operacao, detalhe, url, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$valuesLog = [$usuario[0]['id'], 'UPDATE', 'USUARIO ALTERAR SENHA',$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date("Y-m-d H:i:s")];
			DB::action($sqlLog, $valuesLog);		
			
			// Monta o HTML para envio do email
			$assunto = "Meu Telão - Atualizou a senha";
			$mensagem = "<p><strong>Meu Telão</strong></p>";
			$mensagem .= "<p><img src='https://meutelao.com.br/assets/img/logo/MeuTelaoLogo.jpg' width='150' /></p>";		
			$mensagem .= "<p>Plataforma de publicação e compartilhamento de imagens e videos em telões e smartvs.</p>";
			$mensagem .= "<p>Nome: <strong>".$usuario[0]['nome']."</strong></p>";
			$mensagem .= "<p>CPF: <strong>".$usuario[0]['cpf']."</strong></p>";
			$mensagem .= "<p>Nome: <strong>".$usuario[0]['email']."</strong></p>";
			$mensagem .= "<p>Fone/Cel: <strong>".$usuario[0]['fone']."</strong></p>";
			$mensagem .= "<p>Atualizou a senha!</p>";
			//$mensagem .= "<p>Acesse o link para atualizar a senha: <a href='https://meutelao.com.br/index.php?pg=esqueci&cod=".$usuario[0]['senha']."'>LINK</a></p>";
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
			$mail->addBCC('getheo@hotmail.com', 'Meu Telao - Copia');
			
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
				session_start();
				$_SESSION['id'] = $usuario[0]['id'];
				$_SESSION['nome'] = $usuario[0]['nome'];
				$_SESSION['cpf'] = $usuario[0]['cpf'];
				$_SESSION['senha'] = $usuario[0]['senha'];
				$_SESSION['email'] = $usuario[0]['email'];
				$_SESSION['fone'] = $usuario[0]['fone'];
				$_SESSION['idnivel'] = $usuario[0]['idnivel'];
		
				http_response_code(200);
				echo json_encode(['Atualizou a senha e enviou um email de confirmação!']);
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
		
		
	}

} catch (Exception $e) {	
	http_response_code(422);
	echo json_encode(['Erro de acesso.']);
	exit();	
}

