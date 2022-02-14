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
            <h4 class="m-0 font-weight-bold text-primary">L & L ADVOCATUS</h4>
            <h6 class="m-0 font-weight-bold text-primary">CADASTROS - ADVOCATUS CORPORATE</h6>
            <p class="mb-4">Abaixo serão listadas todos os cadastrados no sistema.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important' width="25%">NOME</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">CPF</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">OAB</th>
                            <th style='text-align: center; vertical-align:middle !important' width="20%">TELEFONES</th>
                            <th style='text-align: center; vertical-align:middle !important' width="8%">CIDADE</th>
                            <th style='text-align: center; vertical-align:middle !important' width="5%">UF</th>
                            <th style='text-align: center; vertical-align:middle !important'>ATUAÇÃO</th>
                            <th style='text-align: center; vertical-align:middle !important'>DT. CAD.</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_cadastros WHERE empresa = "2" AND status="1" ORDER BY nome ASC';

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['nome']) {
                                $nome = '' . $row['nome'] . '';
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
                            if ($row['oab']) {
                                $oab = '' . $row['oab'] . '';
                            }
                            if ($row['cidade']) {
                                $cidade = '' . $row['cidade'] . '';
                            }
                            if ($row['estado']) {
                                $estado = '' . $row['estado'] . '';
                            }
                            if ($row['atuacao'] == 1) {
                                $atuacao = '<font size="3" color="blue" ><strong> ASE </strong></font>';
                            }
                            if ($row['atuacao'] == 2) {
                                $atuacao = '<font size="3" color="blue" ><strong> AAM </strong></font>';
                            }
                            if ($row['atuacao'] == 3) {
                                $atuacao = '<font size="3" color="blue" ><strong> AAMO </strong></font>';
                            }
                            if ($row['dt_cadastro']) {
                                $dt_cadastro = '' . converte($row['dt_cadastro'], 2) . '';
                            }
                            echo "<tr>";
                            echo '<form action="cadastros-iusta-legis" method="POST">';
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'>" . $nome . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $cpf . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $oab . "</font></td>";
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
                            echo '<div align="center"><input type="hidden" name="id_advocatus" id="id_advocatus" value="' . $row['id'] . '" >';
                            echo '&nbsp;<button type="submit" class="btn btn-sm btn-secondary" title="DUPLICAR" name="duplicar"><i  class="fa fa-exchange-alt"></i></button>';
                            echo '&nbsp;<a type="button" class="desativa btn btn-sm btn-danger"data-nome="' . $nome . '" data-id="' . $row['id'] . '" title="DESATIVAR"><i  class="fa fa-thumbs-down"></i></a>';
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="cadastros-lybor-landgraf-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
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

<script>
    $('.desativa').on('click', function() {
        var nome = $(this).data('nome'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
        var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
        //$('span.nome').text(nome + ' (id = ' + id + ')'); // inserir na o nome na pergunta de confirmação dentro da modal
        $('span.nome').text(nome); // inserir na o nome na pergunta de confirmação dentro da modal
        $('a.desativa-yes').attr('href', 'desativa-cadastro?id=' + id); // mudar dinamicamente o link, href do botão confirmar da modal
        $('#myModal').modal('show'); // modal aparece
    });
</script>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Desativar cadastro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                <h2><strong>
                        <font color="#FF4D4D">ATENÇÃO</font>
                    </strong></h2>
                Tem certeza que deseja desativar o cadastro:<br />
                <h4><strong><span class="nome"></span></strong></h4>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-danger desativa-yes"><i class="fa fa-check"></i> Sim</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
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

switch (get_post_action('duplicar', 'envia-email')) {
    case 'duplicar':

        if (!empty($_POST)) {

            $id_advocatus = $_POST['id_advocatus'];

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM tbl_cadastros where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id_advocatus));
            $data = $q->fetch(PDO::FETCH_ASSOC);

            $nome                  = $data['nome'];
            $rg                    = $data['rg'];
            $cpf                   = $data['cpf'];
            $senha                 = $data['senha'];
            $telefone              = $data['telefone'];
            $celular               = $data['celular'];
            $oab                   = $data['oab'];
            $email                 = $data['email'];
            $cep                   = $data['cep'];
            $endereco              = $data['endereco'];
            $numero                = $data['numero'];
            $complemento           = $data['complemento'];
            $bairro                = $data['bairro'];
            $cidade                = $data['cidade'];
            $estado                = $data['estado'];
            $cep_exterior          = '';
            $endereco_exterior     = '';
            $cidade_exterior       = '';
            $estado_exterior       = '';
            $pais_exterior         = '';
            $banco                 = $data['banco'];
            $conta_tipo            = $data['conta_tipo'];
            $agencia               = $data['agencia'];
            $conta                 = $data['conta'];
            $pix                   = $data['pix'];
            $chave_pix             = $data['chave_pix'];
            $foto_cadastro         = $data['foto_cadastro'];
            $status                = '1';
            $validado              = '1';
            $dt_cadastro           = date("Y-m-d");
            $dt_validacao          = date("Y-m-d");
            $hr_cadastro           = date("H:i:s");
            $atuacao               = $data['atuacao'];
            $empresa               = $data['empresa'];
            $meu_id                = $data['meu_id'];
            $id_vinculo            = $_SESSION['vinculoID'];
            $id_usuario            = '';
            $nivel                 = '1';
            $aplicativos           = 'NÃO';
            $bancos_digitais       = '';
            $digital_allocate      = '';
            $digital_intelligentia = '';
            $iustalegis_advocatus  = '';
            $lybor_advocatus       = '';

            //Validaçao dos campos:
            $validacao = true;
        }

        // Duplica
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbl_cadastros (nome, rg, cpf, telefone, celular, oab, email, cep, endereco, numero, complemento, bairro, cidade, estado, banco, conta_tipo, agencia, conta, pix, chave_pix, foto_cadastro, atuacao, empresa, status, meu_id, id_vinculo, id_usuario, validado, nivel) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $rg, $cpf, $telefone, $celular, $oab, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $banco, $conta_tipo, $agencia, $conta, $pix, $chave_pix, $foto_cadastro, $atuacao, $empresa, $status, $meu_id, $id_vinculo, $id_usuario, $validado, $nivel));
        echo '<script>setTimeout(function () { 
          swal({
            title: "Parabéns!",
            text: "Cadastro duplicado com sucesso!",
            type: "success",
            confirmButtonText: "OK"
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = "cadastros-iusta-legis";
            }
          }); }, 1000);</script>';
        Banco::desconectar();
        break;

    case 'envia-email':

        if (!empty($_POST)) {

            $id_advocatus = $_POST['id_advocatus'];

            $validacao = true;
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM tbl_cadastros WHERE id="' . $id_advocatus . '"';
        $q = $pdo->prepare($sql);
        $q->execute(array($id_advocatus));
        $cadastro = $q->fetch(PDO::FETCH_ASSOC);

        $nome   = $cadastro['nome'];
        $email  = $cadastro['email'];

        date_default_timezone_set('America/Sao_Paulo');
        $datahora = date('d/m/Y H:i:s');
        $IP = $_SERVER['REMOTE_ADDR'];
        $emailAssunto = 'CONFIRMAÇÃO DE CADASTRO - L & L ADVOCATUS';

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
          <p><img src='https://adv-estadual.lyboradvocatus.com/app-assets/img/logos/logo-color-big.png' width='390'></p>
          <p>&nbsp;</p>
          <p class='style2'>Seja bem vindo(a) {$nome}</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'>Obrigado por se cadastrar em nossa plataforma.</p>
          <p class='style3'>&nbsp;</p>
          <p class='style3'>Seu cadastro foi realizado com sucesso!</p>
          <p class='style2'>Estamos validando seu cadastro. Em breve nossa equipe entrará em contato!</p>
          <p class='style3'><strong>SEU CÓDIGO PARA INDICAÇÕES PARA FORMAÇÃO DA SUA EQUIPE É:</strong><br>
          <br> 
          <p class='style3'>Obrigado,</p>
          <p><span class='style5'>L & L Advocatus</span><br>
          <a href='https://www.lyboradvocatus.com' target='_blank'><span class='style3'>www.lyboradvocatus.com</span></a>
          </p>
        </div>
        </body>
        </html>
        <br />
        ";

        $emailDe = array();
        $emailDe['from']        = 'cadastro@lyboradvocatus.com';
        $emailDe['fromName']    = 'Cadastro - L & LAdvocatus';
        $emailDe['replyTo']     = $email;
        $emailDe['returnPath']  = 'cadastro@lyboradvocatus.com';
        $emailDe['confirmTo']   = '';
        $emailPara              = array();
        $emailPara[1]['to']     = $email;
        $emailPara[1]['toName'] = $nome;

        // DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
        $SMTP = array();
        $SMTP['host']        = 'mail.lyboradvocatus.com';
        $SMTP['port']        = 587;
        $SMTP['encrypt']     = '';
        $SMTP['username']    = 'cadastro@lyboradvocatus.com';
        $SMTP['password']    = 'zxcvbnm@2021';
        $SMTP['charset']     = 'utf-8';
        $SMTP['priority']    = 1;
        $SMTP['debug']       = FALSE;
        $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);
        if ($mail !== TRUE) {
            echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='cadastros-lybor-landgraf';</script>";
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
          window.location.href = "cadastros-lybor-landgraf";
        }
      }); }, 1000);</script>';
        BancoCadastros::desconectar();
        break;

    default:
}
?>