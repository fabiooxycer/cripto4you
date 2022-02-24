<?php
session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
  echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
  exit;
}


if ($_POST) {
  require_once("../../includes/databaseApps.php");
  $pdo = BancoApps::conectar();

  $idUsuario   = trim($_REQUEST['comprovanteIdUsuario']);
  $usuario     = trim($_REQUEST['comprovanteUsuario']);
  $idAplicacao = trim($_REQUEST['comprovanteIdAplicacao']);
  $idPlano     = trim($_REQUEST['comprovanteIdPlano']);
  $data        = trim($_REQUEST['comprovanteData']);

  // Formatar data para gravar no banco
  $data = explode('/', $data);
  $dt_liberacao = $data[2] . '-' . $data[1] . '-' . $data[0];

  $uploaddir = '/home/digitalinteluser/public_html/teste/assets/img/comprovantes/';

  $fileExtension = explode('.', $_FILES['comprovante']['name']);
  $fileExtension = strtolower($fileExtension[1]);

  $nomeArquivo = $idUsuario . "-" . date('Ymd') . '.' . $fileExtension;

  if ($fileExtension == 'jpg' or $fileExtension == 'jpeg') {
    if (move_uploaded_file($_FILES['comprovante']['tmp_name'], $uploaddir . $nomeArquivo)) {
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $plano               = '1';
      $perfil_verificado   = '1';
      $id_aplicacao        = '14';
      $dt_assinatura_plano = date('Y-m-d');
      $dt_vencimento_plano = date('Y-m-d', strtotime("+30 days"));


      $sql = "INSERT INTO tbl_comprovantes_usuarios (id_usuario, id_aplicacao, id_plano, comprovante, dt_criacao) VALUES (?,?,?,?,?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($idUsuario, $idAplicacao, $plano, $nomeArquivo, $dt_liberacao));


      $sql = "UPDATE tbl_usuarios set id_aplicacao = ?, perfil_verificado = ?, id_plano = ?, dt_assinatura_plano = ?, dt_vencimento_plano = ? WHERE id = ?";
      $q = $pdo->prepare($sql);

      if ($q->execute(array($id_aplicacao, $perfil_verificado, $plano, $dt_assinatura_plano, $dt_vencimento_plano, $idUsuario))) {
        $sql = 'SELECT * FROM tbl_usuarios WHERE id="' . $idUsuario . '"';
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $cadastro = $q->fetch(PDO::FETCH_ASSOC);

        $nome   = $cadastro['nome'];
        $email  = $cadastro['email'];

        require('../../includes/phpmailer/hdw-phpmailer.php');

        date_default_timezone_set('America/Sao_Paulo');
        $datahora = date('d/m/Y H:i:s');
        $IP = $_SERVER['REMOTE_ADDR'];
        $emailAssunto = 'Ativação de Cadastro - Debtools';

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
        .style7 {
          font-size: 36px;
          color: #D90000;
        }
        -->
        </style>
        </head>

        <body>
        <div align='center' class='style1'>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><img src='https://debtools.com.br/img/logo.jpg' width='250'></p>
          <p>&nbsp;</p>
          <p class='style2'>Seja bem vindo(a) {$nome}</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'>Obrigado por se cadastrar em nossa plataforma Debtools.</p>
          <p class='style3'>&nbsp;</p>
          <p class='style3'>Seu cadastro foi ativado com sucesso!</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'><strong>Para acessar nossa plataforma, clique no link abaixo:</strong><br>
            <br> 
            <span class='style7'><a href='https://adv.debtools.com.br' target='_blank'>Debtools</a></span></p>
          <p class='style2'>&nbsp;</p><br /><br />
          <p class='style3'>Muito obrigado,</p>
          <p><span class='style5'>Debtools<br>
          </p>
        </div>
        </body>
        </html>
        <br />

        ";

        $emailDe = array();
        $emailDe['from']        = 'cadastro@intelligenttia.com';
        $emailDe['fromName']    = 'Ativação de Cadastro - Debtools';
        $emailDe['replyTo']     = $email;
        $emailDe['returnPath']  = 'cadastro@intelligenttia.com';
        $emailDe['confirmTo']   = '';
        $emailPara              = array();
        $emailPara[1]['to']     = $email;
        $emailPara[1]['toName'] = $nome;

        // DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
        $SMTP = array();
        $SMTP['host']        = 'mail.intelligenttia.com';
        $SMTP['port']        = 587;
        $SMTP['encrypt']     = '';
        $SMTP['username']    = 'cadastro@intelligenttia.com';
        $SMTP['password']    = 'U=Zm_pg8dza=';
        $SMTP['charset']     = 'utf-8';
        $SMTP['priority']    = 1;
        $SMTP['debug']       = FALSE;
        $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);
        if ($mail !== TRUE) {
          echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='assinaturas-planos';</script>";
        } else {
          echo 1;
        }
        BancoApps::desconectar();
      }
    } else {
      echo 0;
    }
  } else {
    echo "formatoinvalido";
  }
}
