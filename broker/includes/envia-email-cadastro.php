<?php

include("../includes/database.php");
require('../includes/hdw-phpmailer.php');

$nome       = trim($_REQUEST['nome']);
$email      = trim($_REQUEST['email']);
//$telefone = trim($_REQUEST['telefone']);
//$mensagem = trim($_REQUEST['mensagem']);

date_default_timezone_set('America/Sao_Paulo');
$datahora = date('d/m/Y H:i:s');
$IP = $_SERVER['REMOTE_ADDR'];
$emailAssunto = 'CONFIRMAÇÃO DE CADASTRO - IUSTA LEGIS';



// TEMPLATE HTML DA MENSAGEM
$emailMensagem = "
<br />
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf8'>
<style type='text/css'>
<!--
.style1 {font-family: arial}
.style2 {
	font-size: 24px;
	font-weight: bold;
}
.style3 {font-size: 16px}
.style5 {font-size: 16px; font-weight: bold; }
-->
</style>
</head>

<body>
<div align='center' class='style1'>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p><img src='https://adv-estatual.iustalegis.com/app-assets/img/logos/logo-color-big.png' width='351' height='90'></p>
  <p>&nbsp;</p>
  <p class='style2'>Seja bem vindo(a) {$nome}</p>
  <p class='style2'>&nbsp;</p>
  <p class='style3'>Obrigado por se cadastrar em nossa plataforma.</p>
  <p class='style3'>&nbsp;</p>
  <p class='style3'>Estamos validando seu cadastro, e assim que o mesmo estiver ativo, entraremos em contato!</p>
  <p class='style2'>&nbsp;</p>
  <p class='style3'>Obrigado(a),</p>
  <p><span class='style5'>Equipe Iusta Legis s<br>
    </span><a href='https://www.iustalegis.com/' target='_blank'><span class='style3'>https://www.iustalegis.com
  </span></a><span class='style3'>  </span>  </p>
  <p>&nbsp; </p>
</div>
</body>
</html>
<br />
";



$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_servidor_smtp WHERE id="1"';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
$email_de        = $data['email_login'];
$email_para      = $email;
$email_para_nome = $nome;
$host_smtp       = $data['host_smtp'];
$porta_smtp      = $data['porta_smtp'];
$encrypt_smtp    = $data['encrypt_smtp'];
$email_login     = $data['email_login'];
$email_senha     = $data['email_senha'];

$emailDe = array();
$emailDe['from']        = $email_de;
$emailDe['fromName']    = $nome;
$emailDe['replyTo']     = $email;
$emailDe['returnPath']  = $email_de;
$emailDe['confirmTo']   = '';
$emailPara              = array();
$emailPara[1]['to']     = $email_para;
$emailPara[1]['toName'] = $email_para_nome;

// DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
$SMTP = array();
$SMTP['host']        = $host_smtp;
$SMTP['port']        = $porta_smtp;
$SMTP['encrypt']     = $encrypt_smtp;
$SMTP['username']    = $email_login;
$SMTP['password']    = $email_senha;
$SMTP['charset']     = 'utf-8';
$SMTP['priority']    = 1;
$SMTP['debug']       = FALSE;
$mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);
if ($mail !== TRUE) {
    echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='https://www.iustalegis.com/';</script>";
    //echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
    exit;
}
echo "<script>alert('SUA MENSAGEM FOI ENVIADA COM SUCESSO!');location.href='https://www.iustalegis.com/';</script>";
?>
<html>

<body>
</body>

</html>