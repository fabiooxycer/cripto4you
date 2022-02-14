<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../../includes/header.php');
require_once("../../../includes/database.php");
$pdo = BancoCadastros::conectar();
?>

<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">CONFIGURAÇÃO DE AGENTES</h4>
            <h6 class="m-0 font-weight-bold text-primary">VÍNCULO DE AGENTES À MUNICÍPIOS</h6>
            <p class="mb-4">Abaixo serão listadas todos os AEM cadastrados no sistema.</p>
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
                            <th style='text-align: center; vertical-align:middle !important' width="15%">CIDADE</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">UF</th>
                            <th style='text-align: center; vertical-align:middle !important'>ATUAÇÃO</th>
                            <th style='text-align: center; vertical-align:middle !important'>EMPRESA</th>
                            <th style='text-align: center; vertical-align:middle !important'>DT. CAD.</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_cadastros WHERE status="1" AND atuacao = "2" ORDER BY nome ASC';

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
                            if ($row['cidade']) {
                                $cidade = '' . $row['cidade'] . '';
                            }
                            if ($row['estado']) {
                                $estado = '' . $row['estado'] . '';
                            }
                            if ($row['atuacao'] == 2) {
                                $atuacao = '<font size="3" color="blue" ><strong> CFFE-AEM </strong></font>';
                            }
                            if ($row['dt_cadastro']) {
                                $dt_cadastro = '' . converte($row['dt_cadastro'], 2) . '';
                            }
                            if ($row['empresa'] == 8) {
                                $empresa = 'Constellater';
                            }
                            if ($row['empresa'] == 7) {
                                $empresa = 'Intelligenz';
                            }
                            if ($row['empresa'] == 6) {
                                $empresa = 'Lavvor';
                            }
                            if ($row['empresa'] == 4) {
                                $empresa = 'Allocate';
                            }
                            if ($row['empresa'] == 3) {
                                $empresa = 'Intelligentia';
                            }

                            echo "<tr>";

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
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $empresa . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_cadastro . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'>";
                            echo '<form action="pages/configuracoes/cidades.php" method="POST">';
                            echo '<input type="hidden" name="id_agente" id="id_agente" value="' . $row['id'] . '" >';
                            
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="vincular-agentes-cidades/' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                            //echo '&nbsp;<input type="submit" class="btn btn-sm btn-warning" value="Cidades"></a>';
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
                Tem certeza que deseja desativar o CFFE:<br />
                <h4><strong><span class="nome"></span></strong></h4>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-danger desativa-yes"><i class="fa fa-check"></i> Sim</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php
include('../../../includes/footer.php');

function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

switch (get_post_action('envia-email')) {
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
        $emailAssunto = 'CONFIRMAÇÃO DE CADASTRO - LAVVOR BANCO RURAL DIGITAL';


        if ($cadastro['atuacao'] == '1') {
            $atuacao_agente = 'Conselheiro Financeiro Familiar e Empresarial - Agente Executivo Municipal';
            $link3 = 'https://aem.lavvor.com';
        }
        if ($cadastro['atuacao'] == '2') {
            $atuacao_agente = 'Conselheiro Financeiro Familiar e Empresarial - Agente Operacional de Inteligência Originário';
            $link3 = 'https://aoio.lavvor.com';
        }
        if ($cadastro['atuacao'] == '3') {
            $atuacao_agente = 'Conselheiro Financeiro Familiar e Empresarial - Agente Operacional de Inteligência';
            $link3 = 'https://aoi.lavvor.com';
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
          <p><img src='https://aen.lavvor.com/app-assets/img/logos/logo-color-big.png' width='700'></p>
          <p>&nbsp;</p>
          <p class='style2'>Seja bem vindo(a) {$nome}</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'>Obrigado por se cadastrar em nossa plataforma.</p>
          <p class='style3'>&nbsp;</p>
          <p class='style3'>Seu cadastro foi realizado com sucesso!</p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'><strong>SEU CÓDIGO PARA INDICAÇÕES PARA FORMAÇÃO DA SUA EQUIPE É:</strong><br>
            <br> 
            <span class='style7'>{$meu_id}</span></p>
          <p class='style2'>&nbsp;</p>
          <p class='style3'>Para criar sua equipe de <strong> {$atuacao_agente}</strong>, basta compartilhar os links abaixo e inserir o c&oacute;digo acima para realizar o cadastro:<br></p>
          <p class='style3'><a href='{$link3}' target='_blank'>{$link3}</a></p><br /><br />
          <p class='style3'>Obrigado,</p>
          <p><span class='style5'>LAVVOR BANCO RURAL DIGITAL<br>
            </span><a href='https://www.lavvor.com' target='_blank'><span class='style3'>www.lavvor.com</span></a><span class='style3'>  </span>
          </p>
        </div>
        </body>
        </html>
        <br />
        ";

        $emailDe = array();
        $emailDe['from']        = 'cadastro@lavvor.com';
        $emailDe['fromName']    = 'Cadastro - Lavvor Banco Rural Digital';
        $emailDe['replyTo']     = $email;
        $emailDe['returnPath']  = 'cadastro@lavvor.com';
        $emailDe['confirmTo']   = '';
        $emailPara              = array();
        $emailPara[1]['to']     = $email;
        $emailPara[1]['toName'] = $nome;

        // DADOS DA CONTA SMTP PARA AUTENTICACAO DO ENVIO
        $SMTP = array();
        $SMTP['host']        = 'mail.lavvor.com';
        $SMTP['port']        = 587;
        $SMTP['encrypt']     = '';
        $SMTP['username']    = 'cadastro@lavvor.com';
        $SMTP['password']    = 'zxcvbnm@2021';
        $SMTP['charset']     = 'utf-8';
        $SMTP['priority']    = 1;
        $SMTP['debug']       = FALSE;
        $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);
        if ($mail !== TRUE) {
            echo "<script>alert('NÂO FOI POSSÍVEL ENVIAR O E-MAIL DE CONFIRMAÇÃO DE CADASTRO. POR FAVOR, ENTRE EM CONTATO CONOSCO!');location.href='lista-aen-lavvor';</script>";
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
          window.location.href = "lista-aen-lavvor";
        }
      }); }, 1000);</script>';
        BancoCadastros::desconectar();
        break;

    default:
}
?>