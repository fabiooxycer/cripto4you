<?php
session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
  echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
  exit;
}

include('../../includes/header.php');

$id = null;
if (!empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

if (null == $id) {
  header("Location: financeiro-pericias");
} else {
  require_once("../../includes/databaseApps.php");
  $pdo = BancoApps::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql_pericia = "SELECT * FROM tbl_cadastro_pericias WHERE id = ?";
  $q = $pdo->prepare($sql_pericia);
  $q->execute(array($id));
  $data_pericia = $q->fetch(PDO::FETCH_ASSOC);

  $sql_user = "SELECT * FROM tbl_usuarios WHERE id = ?";
  $q = $pdo->prepare($sql_user);
  $q->execute(array($data_pericia['id_usuario']));
  $data_user = $q->fetch(PDO::FETCH_ASSOC);


  $sql = "SELECT * FROM tbl_historico_pagamentos WHERE id_pericia = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);

  date_default_timezone_set('America/Sao_Paulo');
  $datahora = date('d/m/Y H:i:s');
  $IP = $_SERVER['REMOTE_ADDR'];
  $emailAssunto = 'INTELLIGENTTIA LEGALE - LINK PARA PAGAMENTO PERÍCIA TÉCNICA';
  $id_pericia = $data['id_pericia'];
  $link_pagamento = $data['link_pagamento'];
  $email = $data_user['email'];


  // TEMPLATE HTML DA MENSAGEM
  $emailMensagem = "
        <br />
        <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
        'http://www.w3.org/TR/html4/loose.dtd'>
        <html>
        <head>
        <title></title>
        <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
        <style type='text/css'>
        <!--
        .style1 {font-family: Arial, Helvetica, sans-serif}
        .style3 {font-family: Arial, Helvetica, sans-serif; font-size: 18px; }
        .style5 {color: #0066CC}
        .style6 {
          color: #333333;
          font-size: 9px;
        }
        body {
          background-color: #003300;
        }
        a:link {
          color: #0066CC;
          text-decoration: none;
        }
        a:visited {
          text-decoration: none;
          color: #006600;
        }
        a:hover {
          text-decoration: none;
          color: #006600;
        }
        a:active {
          text-decoration: none;
          color: #006600;
        }
        -->
        </style>
        </head>

        <body>
        <div align='center'>
          <table width='757' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
            <!--DWLayoutTable-->
            <tr>
              <td width='757' height='250' valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
                  <!--DWLayoutTable-->
                  <tr>
                    <td width='757' height='250' valign='top'><img src='https://cdn.digitalintelligentia.com/intelligenttia/logo-intelligenttia.jpg' width='757' height='250'>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height='499' valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
                <!--DWLayoutTable-->
                <tr>
                  <td width='757' height='499' valign='top'><p>&nbsp;</p>
                    <p align='center'>&nbsp;</p>
                    <p align='center' class='style1 style4'>Ol&aacute;,</p>
                    <p align='center' class='style3'>Segue abaixo link para pagamento da per&iacute;cia t&eacute;cnica<span class='style5'> {$id_pericia}</span> .</p>
                    <p align='center' class='style1 style4'>&nbsp;</p>
                    <p align='center' class='style1 style4'><strong>{$link_pagamento}</strong></p>
                    <p align='center' class='style1'>&nbsp;</p>
                    <p align='center' class='style1'>&nbsp;</p>
                    <p align='center' class='style1'><br>
                    </p>            
                    <p align='center' class='style1'>&nbsp;</p>
                    <p align='center' class='style1'>&nbsp;</p>
                    <p align='center' class='style1'>Muito obrigado!</p>
                    <p align='center' class='style1'><strong>Intelligentia Legale </strong></p></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height='142'>&nbsp;</td>
            </tr>
            <tr>
              <td height='17' valign='top'><div align='center'><span class='style1 style6'>Este e-mail &eacute; autom&aacute;tico e enviado atrav&eacute;s do nosso sistema de gest&atilde;o. Favor n&atilde;o responder. Para contato es suporte, envie um e-mail para suporte@intelligenttia.com.</span></div></td>
            </tr>
          </table>
        </div>
        </body>
        </html>
        <br />
        ";

  $emailDe = array();
  $emailDe['from']        = 'naoresponda@intelligenttia.com';
  $emailDe['fromName']    = 'Financeiro - Intelligenttia Legale';
  $emailDe['replyTo']     = $email;
  $emailDe['returnPath']  = 'naoresponda@intelligenttia.com';
  $emailDe['confirmTo']   = '';
  $emailPara              = array();
  $emailPara[1]['to']     = $email;
  $emailPara[1]['toName'] = $nome;

  // DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
  $SMTP = array();
  $SMTP['host']        = '200.195.183.75';
  $SMTP['port']        = 587;
  $SMTP['encrypt']     = '';
  $SMTP['username']    = 'naoresponda@intelligenttia.com';
  $SMTP['password']    = 'zxcvbnm@2021';
  $SMTP['charset']     = 'utf-8';
  $SMTP['priority']    = 1;
  $SMTP['debug']       = FALSE;
  $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);
  if ($mail !== TRUE) {
    echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='financeiro-pericias';</script>";
    exit;
  }
  echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "E-mail de link de pagamento enviado com sucesso!",
        type: "success",
        confirmButtonText: "OK" 
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "financeiro-pericias";
        }
      }); }, 1000);</script>';
      BancoApps::desconectar();
}