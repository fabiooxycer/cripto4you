<?php
include('includes/scripts.php');
include("includes/database.php");
$pdo = BancoCadastros::conectar();
require('includes/phpmailer/hdw-phpmailer.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Digital Intelligentia">
    <title>Recuperação de Código - Gestão Operacional</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').on('input', function() {
                $('#prosseguir').prop('disabled', $(this).val().length < 8);
            });
        });
    </script>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="assets/img/logo-color-big.png" width="50%"><br /><br />
                                        <h1 class="h4 text-gray-900 mb-4">Gestão Operacional</h1>
                                        <h6 class="text-gray-900 mb-4">Recuperação de Código de Cadastro</h6>
                                    </div>
                                    <form class="user" action="recupera-codigo" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" onChange="this.value=this.value.toLowerCase()" placeholder="INFORME SEU E-MAIL" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="cpf" name="cpf" maxlength="18" onkeydown="javascript: fMasc( this, mCPF );" placeholder="INFORME SEU CPF" required>
                                        </div>
                                        <button type="submit" id="prosseguir" name="prosseguir" class="btn btn-primary btn-user btn-block" disabled>
                                            RECUPERAR
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-user btn-block" style="background-color: #222222" onClick="history.go(-1)">
                                            <i class="icon-action-undo"></i> VOLTAR
                                        </button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>

<?php
function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

// Verifica qual botao foi clicado
switch (get_post_action('prosseguir')) {

    case 'prosseguir':

        if (!empty($_POST)) {

            $email = $_POST['email'];
            $cpf   = $_POST['cpf'];


            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = 'SELECT * FROM tbl_cadastros WHERE cpf = "' . $cpf . '" AND email = "' . $email  . '" AND status = 1 ';
            $q1 = $pdo->prepare($sql1);
            $q1->execute();
            $data = $q1->fetch(PDO::FETCH_ASSOC);
            if ($data['cpf'] == '' || $data['email'] == '') {

                echo '<script>setTimeout(function () { 
      swal({
        title: "Atenção!",
        text: "Cadastro não localizado!",
        type: "warning",
        confirmButtonText: "OK"
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "recupera-codigo";
        }
      }); }, 1000);</script>';
            }
            if ($data['cpf'] == $_POST['cpf'] && $data['email'] == $_POST['email']) {
                $nome = $data['nome'];

                date_default_timezone_set('America/Sao_Paulo');
                $datahora = date('d/m/Y H:i:s');
                $IP = $_SERVER['REMOTE_ADDR'];
                $emailAssunto = 'Recuperação de Códigos | Digital Intelligentia';

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
                  color: #0033CC;
                }
                -->
                </style>
                </head>
        
                <body>
                <div align='center' class='style1'>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p><img src='https://aen.digitalintelligentia.com/app-assets/img/logos/logo-color-big.png' width='390'></p>
                  <p>&nbsp;</p>
                  <p class='style2'>Olá, {$nome}!</p>
                  <p class='style2'>&nbsp;</p>
                  <p class='style3'>Recebemos sua solicitação de recuperação do código pessoal de trabalho.</p>
                  <p class='style3'>&nbsp;</p>
                  <p class='style3'>Segue abaixo seu(s) código(s) de Agente:</p>
                  <p class='style2'>&nbsp;</p>
                  <br>
                  ";

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT * FROM tbl_cadastros WHERE cpf = "' . $data['cpf'] . '" AND email = "' . $data['email'] . '" AND status = 1';

                foreach ($pdo->query($sql) as $row) {
                    if ($row['empresa'] == '3') {
                        $empresa = 'Digital Intelligentia';
                    }
                    if ($row['empresa'] == '4') {
                        $empresa = 'Digital Allocate';
                    }
                    if ($row['empresa'] == '6') {
                        $empresa = 'Banco Lavvor';
                    }
                    if ($row['empresa'] == '7') {
                        $empresa = 'Banco Intelligenz';
                    }
                    if ($row['empresa'] == '8') {
                        $empresa = 'Banco Constellater';
                    }

                    if ($row['atuacao'] == '1') {
                        $atuacao = 'AEN';
                    }
                    if ($row['atuacao'] == '2') {
                        $atuacao = 'AEM';
                    }
                    if ($row['atuacao'] == '3') {
                        $atuacao = 'AOIO';
                    }
                    if ($row['atuacao'] == '4') {
                        $atuacao = 'AOI';
                    }
                    if ($row['atuacao'] == '5') {
                        $atuacao = 'AEE';
                    }
                    if ($row['atuacao'] == '6') {
                        $atuacao = 'AEEM';
                    }

                    $meu_id = $row['meu_id'];

                    $emailMensagem .= "
                  <p class='style3'><strong>Empresa:</strong> {$empresa}</p>
                  <p class='style3'><strong>Atuação:</strong> {$atuacao}</p>
                  <p class='style3'><strong>Seu Cód.:</strong> {$meu_id}</p>
                  <br />
                    ";
                }

                $emailMensagem .= "
                  </p><br /><br />
                  <p class='style3'>Obrigado,</p>
                  <p><span class='style5'>Digital Intelligentia</span><br>
                  <a href='https://www.digitalintelligentia.com' target='_blank'><span class='style3'>www.digitalintelligentia.com</span></a>
                  </p>
                </div>
                </body>
                </html>
                <br />
        ";

                $emailDe = array();
                $emailDe['from']        = 'cadastro@digitalintelligentia.com';
                $emailDe['fromName']    = 'Cadastro - Digital Intelligentia';
                $emailDe['replyTo']     = $email;
                $emailDe['returnPath']  = 'cadastro@digitalintelligentia.com';
                $emailDe['confirmTo']   = '';
                $emailPara              = array();
                $emailPara[1]['to']     = $email;
                $emailPara[1]['toName'] = $nome;

                // DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
                $SMTP = array();
                $SMTP['host']        = '200.195.183.75';
                $SMTP['port']        = 587;
                $SMTP['encrypt']     = '';
                $SMTP['username']    = 'cadastro@digitalintelligentia.com';
                $SMTP['password']    = 'zxcvbnm@2021';
                $SMTP['charset']     = 'utf-8';
                $SMTP['priority']    = 1;
                $SMTP['debug']       = FALSE;
                $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);
                if ($mail !== TRUE) {
                    echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='recupera-codigo';</script>";
                    exit;
                }
                echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "Enviamos um e-mail com seu(s) código(s)!",
        type: "success",
        confirmButtonText: "OK" 
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "https://www.digitalintelligentia.com";
        }
      }); }, 1000);</script>';
            }
        }

        break;

    default:
}
?>