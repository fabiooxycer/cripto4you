<?php

// inclusao do arquivo com a funcao para envio de email com autenticacao SMTP
require('phpmailer/hdw-phpmailer.php');



// recebe os campos do formulario
$nome			= trim($_REQUEST['nome']);
$email			= trim($_REQUEST['email']);
$telefone		= trim($_REQUEST['telefone']);
$mensagem		= trim($_REQUEST['mensagem']);




// define a data e hora da mensagem
date_default_timezone_set('America/Sao_Paulo');
$datahora = date('d/m/Y H:i:s');



// define o IP de envio da mensagem
$IP = $_SERVER['REMOTE_ADDR'];



// define o assunto da mensagem
$emailAssunto = 'Contato do site Cripto4You';



// define o texto da mensagem em HTML
$emailMensagem = "
<strong>{$emailAssunto}</strong><br />
<hr />

<strong>Nome:</strong> {$nome}<br />
<strong>Email:</strong> {$email}<br />
<strong>Telefone:</strong> {$telefone}<br />
<br />
<strong>Mensagem:</strong><br />
{$mensagem}<br />

<hr />
<strong>Data/Hora:</strong> {$datahora}<br />
<strong>IP:</strong> {$IP}<br />
<br />
";


// Inicia conexão com o banco de dados para autenticação no disparo do e-mail
include("database.php");
$pdo = BancoCadastros::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_smtp';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

$email_de 		 = $data['email_de'];
$email_para 	 = $data['email_para'];
$email_para_nome = $data['email_para_nome'];
$host_smtp 		 = $data['host_smtp'];
$porta_smtp 	 = $data['porta_smtp'];
$encrypt_smtp 	 = $data['encrypt_smtp'];
$email_login 	 = $data['email_login'];
$email_senha 	 = $data['email_senha'];



// inicia configuracoes do email

// DADOS DO REMETENTE (quem envia o email)
$emailDe = array();


// informe o email do remetente
// IMPORTANTE: este email deve obrigatoriamente ser do mesmo dominio do site
$emailDe['from']		= $email_de;


// informe o nome do remetente
$emailDe['fromName']	= $nome; // por padrao puxa o nome preenchido no formulario


// informe o email para resposta
// pode ser informado qualquer email de qualquer dominio
$emailDe['replyTo']		= $email; // por padrao puxa o email preenchido no formulario


// informe o email de retorno em caso de erro
// IMPORTANTE: este email deve obrigatoriamente ser do mesmo dominio do site
$emailDe['returnPath']	= $email_de;


// informe o email para envio de confirmacao de leitura (opcional)
// deixe vazio para nao enviar confirmacao
// IMPORTANTE: este email deve obrigatoriamente ser do mesmo dominio do site
$emailDe['confirmTo']	= '';



// DADOS DO DESTINATARIO (quem ira receber o email)
$emailPara = array();


// informe ao menos um email de destinatario, o nome é opcional
// IMPORTANTE: podem ser adicionados varios destinatarios, fique atento a numeracao do array!
// #1
$emailPara[1]['to']		= $email_para;
$emailPara[1]['toName']	= $email_para_nome;
// #2
//$emailPara[2]['to']		= 'seuemail2@seudominio.com.br';
//$emailPara[2]['toName']	= 'Seu Nome2';



// DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
$SMTP = array();
$SMTP['host']		= $host_smtp;
$SMTP['port']		= $porta_smtp; // para o gmail utilize 587
$SMTP['encrypt']	= $encrypt_smtp; // ssl ou tls ou vazio, para o gmail utilize tls
$SMTP['username']	= $email_login; // recomendamos criar uma conta de email somente para ser utilizada aqui
$SMTP['password']	= $email_senha; // pois cada vez que a senha for alterada este arquivo tambem devera ser atualizado
$SMTP['charset']	= 'utf-8'; // 'utf-8' ou 'iso-8859-1', siga o padrao do arquivo para nao haver erros na acentuacao
$SMTP['priority']	= 1; // prioridade: 1=alta; 3=normal; 5=baixa;


// DEBUG (ajuda para descobrir erros)
// - use TRUE para ver os erros de envio
// - uma vez configurado e funcionando obrigatoriamente utilize FALSE
$SMTP['debug'] = FALSE;


// faz o envio
$mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);


// em caso de erro
if ($mail !== TRUE) {
	// redireciona ou exibe uma mensagem de erro
	//header('location: erro.html');
	echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
	exit;
}


// em caso de sucesso
// redireciona ou exibe a mensagem de agradecimento
//header('location: obrigado.html'); exit;
echo "<script>alert('SUA MENSAGEM FOI ENVIADA COM SUCESSO!');location.href='../inicio';</script>";
//echo $email_de;
//echo $email_para;
//echo $email_para_nome;
//echo $host_smtp;
//echo $porta_smtp;
//echo $encrypt_smtp;
//echo $email_login;
//echo $email_senha;
?>
<html>

<body>
</body>

</html>