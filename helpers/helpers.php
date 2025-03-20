<?php

if (strtolower(basename($_SERVER['REQUEST_URI'])) == strtolower(basename(__FILE__))) {

    exit('Error code: #CCR546');

}



//ini_set('session.gc_maxlifetime', 21600);

//session_cache_expire(360);

//session_set_cookie_params(21600);

//session_name(md5("MeuTelao{$_SERVER['REMOTE_ADDR']}:{$_SERVER['HTTP_USER_AGENT']}AX"));

//session_start();



/*

if(isset($_SESSION['expire'])){

    if($_SESSION['expire'] < date('Y-m-d H:i:s')){

        logout();

    }

}else{

    logout();

}

*/



function checkLogin()

{

    if (isset($_SESSION['auth'])) {

        if ($_SESSION['auth']) {

            return true;

        }

    }

    return false;

}



function logout()

{

    $_SESSION['auth'] = false;

    $_SESSION['user'] = [];

}



function verificavisao()

{

    $visao = 'setorial';

    $result = DB::select('SELECT idnivel FROM usuario u WHERE u.cpf = ?', [$_SESSION['user']['cpf']]);

    if ($result) {

        $visao = $result[0]['nivel'];

    }

    return strtolower($visao);

}



function createFileName()

{

    return str_replace(['$', '.', '/'], '', password_hash(time(), PASSWORD_DEFAULT)) . '.pdf';

}



function validate(array $inputs)

{

    $errors = [];



    /*if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH'){

		if(isset($_SERVER['HTTP_X_CSRF_TOKEN'])){

            if($_SESSION['_csrfToken'] != $_SERVER['HTTP_X_CSRF_TOKEN']){

                http_response_code(422);

                echo json_encode(['CSRF-TOKEN inválido.']);

                exit();

            }

		}else{

			if(!isset($_REQUEST['_token'])){

				http_response_code(422);

				echo json_encode(['CSRF-TOKEN inválido.']);

				exit();

			}



			if($_SESSION['_csrfToken'] != $_REQUEST['_token']){

				http_response_code(422);

				echo json_encode(['CSRF-TOKEN inválido.']);

				exit();

			}

		}

    }*/



    foreach ($inputs as $input) {

        if (!isset($_REQUEST[$input[0]])) {

            array_push($errors, $input[1]);

        } elseif (!$_REQUEST[$input[0]]) {

            array_push($errors, $input[1]);

        }

    }

    return $errors;

}



function validateJSON($data, array $inputs)

{

    $checks = true;

    $errors = [];



    foreach ($inputs as $row) {

        if (empty($data[$row[0]])) {

            array_push($errors, $row[1]);

        }

    }



    return $errors;

}



function mascara($valor, $formato)

{

    $retorno = '';

    $posicao_valor = 0;

    for ($i = 0; $i <= strlen($formato) - 1; $i++) {

        if ($formato[$i] == '#') {

            if (isset($valor[$posicao_valor])) {

                $retorno .= $valor[$posicao_valor++];

            }

        } else {

            $retorno .= $formato[$i];

        }

    }

    return $retorno;

}



function auth()

{

    $json = [];

    $user = DB::select('SELECT * FROM usuario WHERE id = ?', [$_SESSION['user']['id']]);

    $json['user'] = [

        'id' => $user[0]['id'],

        'nome' => $user[0]['nome'],

        'cpf' => $user[0]['cpf'],

        'email' => $user[0]['email'],

        'fone' => $user[0]['fone'],

        'status' => $user[0]['status'],

        'datacadastro' => $user[0]['datacadastro'],

        'nivel' => $user[0]['idnivel']

    ];

    return $json;

}



function csrf_token()

{

    $csrfToken = md5(time());

    $_SESSION['_csrfToken'] = $csrfToken;

    return $csrfToken;

}



function enviaUsuarioEmail($usuario, $senha)

{

    $content = file_get_contents('../assets/template/email.html');

    //$template = substr_replace($content, '##CONTEUDO##', 0) ;



    $arquivoemail = "<p>Prezado(a) <strong>" . $usuario[0]['nome'] . "</strong>,<br>seu cadastro foi realizado com sucesso na Plataforma <u>Meu Telão</u>.

			<p>Segue abaixo suas credenciais de acesso.</p>

        	<p>Portal: <a href='https://meutelao.com.br'>https://meutelao.com.br</a></p>

            <p>Usuário: <strong>" . mascara($usuario[0]['cpf'], '###.###.###-##') . "</strong></p>

			<p>Senha: <strong>" . $senha . "</strong></p>

		</html>

	";

    $template = str_replace('##CONTEUDO##', $arquivoemail, $content);



    require('../engine/PHPMailer/src/PHPMailer.php');

    require('../engine/PHPMailer/src/SMTP.php');

    require('../engine/PHPMailer/src/Exception.php');



    $mail = new PHPMailer\PHPMailer\PHPMailer();



    try {



        $mail->CharSet = 'UTF-8';

        $mail->SMTP_PORT = "25"; // ajusto a porta de smt a ser utilizada.



        $mail->IsSMTP(); // ajusto o email para utilizar protocolo SMTP

        $mail->Host = "host_smtp";  // especifico o endereço do servidor smtp

        $mail->SMTPAuth = true;  // ativo a autenticação SMTP,

        $mail->Username = "email_smtp";  // Usuário SMTP

        $mail->Password = "senha_smtp";  // Senha do usuário SMTP



        $mail->SMTPOptions = [

            'ssl' => [

                'verify_peer' => false,

                //'verify_peer_name' => false,

                'allow_self_signed' => true,

                'peer_name' => 'meutelao.com.br',

                'cafile' => '/etc/ssl/certificado-cuco.pem',

            ]

        ];



        $mail->SMTPSecure = true;

        $mail->SMTPAutoTLS = true;

        $mail->From = "contato@meutelao.com.br";

        $mail->FromName = "Meu Telão";

        $mail->AddAddress($usuario[0]['email'], utf8_decode($usuario[0]['nome']));



        //Cópia Oculta ADMIN

        $mail->AddBCC("web@getheo.com.br", "Guilherme Theo - ADMIN");

        $mail->WordWrap = 50;

        $mail->IsHTML(true);

        $mail->Subject = "Meu Telão - Usuário criado";

        $mail->Body = $template;

        $mail->AltBody = "Meu Telão - Recuperar sua senha";

        $mail->send();



    } catch (Exception $e) {

        //http_response_code(500);

        //echo json_encode(['msg' => 'ERRO AO ENVIAR E-MAIL!', 'error' => $e->getMessage()]);

    }

}



//Valida cpf

function validateCPF($number)

{

    $cpf = str_replace(['.', '-'], '', $number);

    switch ($cpf) {

        case '00000000000':

        case '11111111111':

        case '22222222222':

        case '33333333333':

        case '44444444444':

        case '55555555555':

        case '66666666666':

        case '77777777777':

        case '88888888888':

        case '99999999999':

            return true;

            break;

    }

    $exDigit = strlen($cpf) - 2;

    $soma1 = 0;

    $soma2 = 0;

    for ($i = 0; $i < $exDigit; $i++) {

        $soma1 = $soma1 + (($i + 1) * $cpf[$i]);

    }

    $dv1 = $soma1 % 11 == 10 ? 0 : $soma1 % 11;

    $str = substr($cpf, 0, $exDigit) . $dv1;

    for ($i = 0; $i < strlen($str); $i++) {

        $soma2 = $soma2 + ($i * $str[$i]);

    }

    $dv2 = $soma2 % 11 == 10 ? 0 : $soma2 % 11;



    $r = $dv1 . $dv2;

    $v = substr($cpf, $exDigit, strlen($cpf));

    return $v == $r ? false : true;

}



function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){

    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas

    $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas

    $nu = "0123456789"; // $nu contem os números

    $si = "!@#$%¨&*()_+="; // $si contem os símbolos



    $senha = "";



    if ($maiusculas){

        // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha

        $senha .= str_shuffle($ma);

    }



    if ($minusculas){

        // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha

        $senha .= str_shuffle($mi);

    }



    if ($numeros){

        // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha

        $senha .= str_shuffle($nu);

    }



    if ($simbolos){

        // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha

        $senha .= str_shuffle($si);

    }



    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho

    return substr(str_shuffle($senha),0,$tamanho);

}





