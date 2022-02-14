<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();
?>


<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">DIGITAL ALLOCATE</h4>
            <h6 class="m-0 font-weight-bold text-primary">CADASTROS - AGENTES EXECUTIVOS</h6>
            <p class="mb-4">Abaixo serão listadas todos os AE cadastrados no sistema.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                            <th style='text-align: center; vertical-align:middle !important' width="25%">NOME</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">RG</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">CPF</th>
                            <th style='text-align: center; vertical-align:middle !important' width="20%">TELEFONES</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">CIDADE</th>
                            <th style='text-align: center; vertical-align:middle !important' width="5%">UF</th>
                            <th style='text-align: center; vertical-align:middle !important'>ATUAÇÃO</th>
                            <th style='text-align: center; vertical-align:middle !important'>DT. CAD.</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_cadastros WHERE empresa = "4" AND atuacao = "5" AND status = "1" ORDER BY nome ASC';

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['meu_id']) {
                                $meu_id = '' . $row['meu_id'] . '';
                            }
                            if ($row['nome']) {
                                $nome = '' . $row['nome'] . '';
                            }
                            if ($row['rg']) {
                                $rg = '' . $row['rg'] . '';
                            }
                            if ($row['cpf']) {
                                $cpf = '' . $row['cpf'] . '';
                            }
                            if ($row['telefone']) {
                                $telefone = '' . $row['telefone'] . '';
                            }
                            if ($row['celular']) {
                                $celular = '' . $row['celular'] . '';
                            }
                            if($row['telefone'] == ''){
                                $telefone = '-';
                            }
                            if($row['celular'] == ''){
                                $celular = '-';
                            }
                            if ($row['cidade']) {
                                $cidade = '' . $row['cidade'] . '';
                            }
                            if ($row['estado']) {
                                $estado = '' . $row['estado'] . '';
                            }
                            if ($row['atuacao'] == 1) {
                                $atuacao = '<font size="3" color="blue" ><strong> AEN </strong></font>';
                            }
                            if ($row['atuacao'] == 2) {
                                $atuacao = '<font size="3" color="blue" ><strong> AEM </strong></font>';
                            }
                            if ($row['atuacao'] == 3) {
                                $atuacao = '<font size="3" color="blue" ><strong> AOIO </strong></font>';
                            }
                            if ($row['atuacao'] == 4) {
                                $atuacao = '<font size="3" color="blue" ><strong> AOI </strong></font>';
                            }
                            if ($row['atuacao'] == 5) {
                                $atuacao = '<font size="3" color="blue" ><strong> AEE </strong></font>';
                            }
                            if ($row['dt_cadastro']) {
                                $dt_cadastro = '' . converte($row['dt_cadastro'], 2) . '';
                            }
                            echo "<tr>";
                            echo '<form action="lista-aee-allocate" method="POST">';
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $meu_id . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'>" . $nome . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $rg . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $cpf . "</font></td>";
                            if ($telefone != '' && $celular == '') {
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $telefone . "</font></td>";
                            }
                            if ($telefone == '' && $celular != '') {
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $celular . "</font></td>";
                            }
                            if ($telefone != '' && $celular != '') {
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $telefone . " / " . $celular . "</font></td>";
                            }
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $cidade . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $estado . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $atuacao . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_cadastro . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            echo '<div align="center"><input type="hidden" name="id_agente" id="id_agente" value="' . $row['id'] . '" >';
                            echo '&nbsp;<button type="submit" class="btn btn-sm btn-danger" title="DESATIVAR" name="desativar"><i  class="fa fa-thumbs-down"></i></button>';
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="cadastros-digital-allocate-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                            echo '&nbsp;<button type="submit" class="btn btn-sm btn-info" title="REENVIA E-MAIL DE CADASTRO" name="envia-email"><i  class="fa fa-paper-plane"></i></button>';
                            echo "</form>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        BancoCadastros::desconectar()
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>

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

switch (get_post_action('desativar', 'envia-email')) {
    case 'desativar':

        if (!empty($_POST)) {

            $id = $_POST['id_agente'];

            $validacao = true;
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $status = "2";
        $sql = "UPDATE tbl_cadastros set status = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($status, $id));
        echo '<script>setTimeout(function () { 
        swal({
          title: "Parabéns!",
          text: "Agente Executivo desativado com sucesso!",
          type: "success",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "lista-aee-allocate";
          }
        }); }, 1000);</script>';
        BancoCadastros::desconectar();
        break;

    case 'envia-email':

        if (!empty($_POST)) {

            $id_agente = $_POST['id_agente'];

            $validacao = true;
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM tbl_cadastros WHERE id="' . $id_agente . '"';
        $q = $pdo->prepare($sql);
        $q->execute(array($id_agente));
        $cadastro = $q->fetch(PDO::FETCH_ASSOC);

        $nome   = $cadastro['nome'];
        $meu_id = $cadastro['meu_id'];
        $email  = $cadastro['email'];

        date_default_timezone_set('America/Sao_Paulo');
        $datahora = date('d/m/Y H:i:s');
        $IP = $_SERVER['REMOTE_ADDR'];
        $emailAssunto = 'CONFIRMAÇÃO DE CADASTRO - DIGITAL ALLOCATE';


        if ($cadastro['atuacao'] == '1') {
            $atuacao_agente = 'Agente Executivo Municipal';
            $link1 = 'https://aem.digitalallocate.com';
        }
        if ($cadastro['atuacao'] == '2') {
            $atuacao_agente = 'Agente Operacional de Inteligência Originário';
            $link1 = 'https://aoio.digitalallocate.com';
        }
        if ($cadastro['atuacao'] == '3') {
            $atuacao_agente = 'Agente Operacional de Inteligência';
            $link1 = 'https://aoi.digitalallocate.com';
        }
        if ($cadastro['atuacao'] == '5') {
            $atuacao_agente = 'Agente Executivo de Expansão';
            $link1 = 'https://aee.digitalallocate.com';
        }

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
          <p><img src='https://aen.digitalallocate.com/app-assets/img/logos/logo-color-big.png' width='390'></p>
          <p>&nbsp;</p>
          <p class='style2'>Seja bem vindo(a) {$nome}</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'>Obrigado por se cadastrar em nossa plataforma.</p>
          <p class='style3'>&nbsp;</p>
          <p class='style3'>Seu cadastro foi realizado com sucesso!</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'><strong>Código Pessoal de Trabalho:</strong><br>
          <br> 
          <span class='style7'>{$meu_id}</span></p><br /><br />
          <p class='style3'>Muito obrigado,</p>
          <p><span class='style5'>Digital Allocate</span><br>
          <a href='https://www.digitalallocate.com' target='_blank'><span class='style3'>www.digitalallocate.com</span></a>
          </p>
        </div>
        </body>
        </html>
        <br />
        ";

        $emailDe = array();
        $emailDe['from']        = 'cadastro@digitalallocate.com';
        $emailDe['fromName']    = 'Cadastro - Digital Allocate';
        $emailDe['replyTo']     = $email;
        $emailDe['returnPath']  = 'cadastro@digitalallocate.com';
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
            echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='lista-aee-allocate';</script>";
            exit;
        }
        echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "E-mail de cadastro reenviado com sucesso!",
        type: "success",
        confirmButtonText: "OK" 
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "lista-aee-allocate";
        }
      }); }, 1000);</script>';
        BancoCadastros::desconectar();
        break;

    default:
}
?>