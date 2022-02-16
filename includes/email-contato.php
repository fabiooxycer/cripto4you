<?php

require('phpmailer/hdw-phpmailer.php');

$nome	  = trim($_REQUEST['nome']);
$email	  = trim($_REQUEST['email']);
$telefone = trim($_REQUEST['telefone']);
$mensagem = trim($_REQUEST['mensagem']);

date_default_timezone_set('America/Sao_Paulo');
$datahora = date('d/m/Y H:i:s');

$IP 		   = $_SERVER['REMOTE_ADDR'];
$emailAssunto  = 'Contato do site Cripto4You';
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
$emailDe 		 = array();

$emailDe['from']		= $email_de;
$emailDe['fromName']	= $nome;
$emailDe['replyTo']		= $email;
$emailDe['returnPath']	= $email_de;
$emailDe['confirmTo']	= '';
$emailPara 				= array();
$emailPara[1]['to']		= $email_para;
$emailPara[1]['toName']	= $email_para_nome;
// #2
//$emailPara[2]['to']		= 'seuemail2@seudominio.com.br';
//$emailPara[2]['toName']	= 'Seu Nome2';

$SMTP 				= array();
$SMTP['host']		= $host_smtp;
$SMTP['port']		= $porta_smtp;
$SMTP['encrypt']	= $encrypt_smtp;
$SMTP['username']	= $email_login;
$SMTP['password']	= $email_senha;
$SMTP['charset']	= 'utf-8';
$SMTP['priority']	= 1;
$SMTP['debug'] 		= FALSE;

$mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);

if ($mail !== TRUE) {
	echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
	exit;
}

echo "<script>alert('SUA MENSAGEM FOI ENVIADA COM SUCESSO!');location.href='../inicio';</script>";
?>
<html>

<body>
</body>

</html>