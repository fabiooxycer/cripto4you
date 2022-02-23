<?php

if ($_SERVER['HTTP_HOST'] != 'localhost') {
    if (!isset($_SESSION)) session_start();

    $nivel = 98;

    if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
        echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
        exit;
    }
}

include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

$pdo = BancoCadastros::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_usuarios where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [2, "desc"]
            ]
        });
    });
</script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="ml-auto" align="left">
                <div>
                    <button class="btn btn-primary mt-4 mt-sm-0" data-toggle="modal" data-target="#modalSaque"><i class="fa fa-minus mr-1 mt-1"></i> SAQUE</button>

                    <button class="btn btn-secondary mt-4 mt-sm-0" data-toggle="modal" data-target="#modalDeposito"><i class="fa fa-plus mr-1 mt-1"></i> DEPÓSITO</button>

                    <button class="btn btn-info mt-4 mt-sm-0" data-toggle="modal" data-target="#modalLucro"><i class="fa fa-coins mr-1 mt-1"></i> LUCRO</button>
                </div>
            </div><br>
            <h4 class="m-0 font-weight-bold text-primary">Movimentação de <?php echo $data['nome']; ?></h4>
            <p class="mb-4">Abaixo serão listadas todas as movimentações concluídas e pendentes do usuário/cliente.</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='text-align: center; vertical-align:middle !important'>DESCRIÇÃO</th>
                                <th style='text-align: center; vertical-align:middle !important'>TIPO</th>
                                <th style='text-align: center; vertical-align:middle !important'>DATA/HORÁRIO</th>
                                <th style='text-align: center; vertical-align:middle !important'>SITUAÇÃO</th>
                                <th style='text-align: center; vertical-align:middle !important'>VALOR</th>
                                <th style='text-align: center; vertical-align:middle !important'>AÇÃO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $id . '" ORDER BY dt_criacao DESC, hr_criacao DESC';

                            foreach ($pdo->query($sql) as $row) {

                                $id_movimentacao = $row['id'];

                                if ($row['descricao']) {
                                    $descricao = '' . $row['descricao'] . '';
                                }
                                if ($row['tipo'] == 1) {
                                    $tipo = '<font color="blue"> Crédito </font>';
                                }
                                if ($row['tipo'] == 2) {
                                    $tipo = '<font color="red"> Débito </font>';
                                }
                                if ($row['tipo'] == 3) {
                                    $tipo = '<font color="green"> Lucro </font>';
                                }
                                if ($row['tipo'] == 3 AND $row['reinvestir'] == 1) {
                                    $tipo = '<font color="blue"> Lucro reinvestido </font>';
                                }
                                
                                if ($row['dt_criacao']) {
                                    $data_criacao = '' . $row['dt_criacao'] . '';
                                    $timestamp = strtotime($data_criacao);
                                    $dt_criacao = date('d/m/Y', $timestamp);
                                }
                                if ($row['hr_criacao']) {
                                    $hora_criacao = '' . $row['hr_criacao'] . '';
                                    $timestamp2 = strtotime($hora_criacao);
                                    $hr_criacao = date('H:i:s', $timestamp2);
                                }
                                if ($row['valor']) {
                                    $valor = '' . number_format($row['valor'], 2, ',', '.') . '';
                                }
                                if ($row['confirmado'] == 1) {
                                    $confirmado = 'Autorizado';
                                }
                                if ($row['confirmado'] == 2) {
                                    $confirmado = 'Aguardando Liberação';
                                }
                                if ($row['confirmado'] == 3) {
                                    $confirmado = 'Cancelado';
                                }

                                echo "<tr>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $descricao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $tipo . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $dt_criacao . " às " . $hr_criacao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $confirmado . "</td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>R$ " . $valor . "</font></td>";

                                echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                                echo '<form action="clientes-movimentacao" method="POST">';
                                echo '<input type="hidden" name="id_user" id="id_user" value="' . $id . '" >';
                                echo '<input type="hidden" name="nome" id="nome" value="' . $data['nome'] . '" >';
                                echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                                echo '<input type="hidden" name="tipo" id="tipo" value="' . $row['tipo'] . '" >';
                                echo '<input type="hidden" name="valor" id="valor" value="' . $valor . '" >';
                                if ($row['confirmado'] == 2) {
                                    echo '<button type="submit" title="LIBERAR MOVIMENTAÇÃO" class="btn btn-sm btn-success" name="liberar">LIBERAR</button><br>';
                                    echo '<button type="submit" title="CANCELAR MOVIMENTAÇÃO" class="btn btn-sm btn-danger" name="cancelar">CANCELAR</button>';
                                } else {
                                    echo '-';
                                }
                                if ($row['tipo'] == 3) {
                                    echo '<br><button type="submit" title="REINVESTIR LUCRO" class="btn btn-sm btn-info" name="reinvestir">REINVESTIR</button>';
                                }
                                echo "</form>";
                                echo "</td>";
                            }
                            echo "</tr>";
                            // BancoCadastros::desconectar()
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Exibe o Modal para solicitação de saque -->
    <div class="modal fade" id="modalSaque" tabindex="-1" role="dialog" aria-labelledby="modalSaque" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">SOLICITAR SAQUE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="clientes-movimentacao?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="basicInput">Valor:</label>
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>" autocomplete="off" readonly>
                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" placeholder="Informe o valor do saque" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="justify">
                            <font size="2" color="red"><strong>Observação:</strong></font>
                            <font size="2"> Após aprovação do saque pela nossa equipe, o prazo de tranferência para sua conta bancária através de PIX é de até 7 dias úteis. Está transferência será realizada para sua conta PIX informada em sua conta em nossa plataforma.</font>
                        </p>
                        <div class="form-actions">
                            <button type="submit" name="saque" class="btn btn-primary"><i class="fa fa-check"></i> SOLICITAR SAQUE</button>
                            <button type="button" class="btn btn-secondary text-white" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- Exibe o Modal para solicitação de depósito -->
    <div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="modalDeposito" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">DEPÓSITO DE APORTE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="clientes-movimentacao?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="basicInput">Valor:</label>
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>" autocomplete="off" readonly>
                                        <input type="hidden" class="form-control" id="nome" name="nome" value="<?php echo $data['nome']; ?>" autocomplete="off" readonly>
                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" placeholder="Informe o valor do aporte" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="justify">
                            <font size="2" color="red"><strong>Observação:</strong></font>
                            <font size="2"> Todo depósito de aporte de capital deverá ser enviado por uma conta bancária ou carteira em sua titularidade. A transferência deverá ser realizada para as carteiras ou PIX listados abaixo no prazo de 2h. Após realizar a transferência, enviar comprovante da transação para <a href="mailto:financeiro@cripto4you.net" target="_blank">financeiro@cripto4you.net</a>, utilizando seu e-mail de cadastro em nossa plataforma. O prazo de confirmação e inclusão do valor em seu saldo é de até 24h.</font><br><br>
                        </p>
                        <p align="left">
                            <font size="2"><strong>Carteira BUSD:</strong> 0x8d0c1fb55d15faa0aaa53e94ac5cf867ae532e63</font><br>
                            <font size="2"><strong>Rede:</strong> BEP20</font><br><br>
                            <font size="2"><strong>PIX CNPJ:</strong> 34.837.022/0001-22</font>
                        </p>
                        <div class="form-actions">
                            <button type="submit" name="deposito" class="btn btn-primary"><i class="fa fa-check"></i> ENVIAR APORTE</button>
                            <button type="button" class="btn btn-secondary text-white" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- Exibe o Modal para inseção de Lucro -->
    <div class="modal fade" id="modalLucro" tabindex="-1" role="dialog" aria-labelledby="modalLucro" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">INSERIR LUCRO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="clientes-movimentacao?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="basicInput">Valor:</label>
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>" autocomplete="off" readonly>
                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" placeholder="Informe o valor do lucro" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="justify">
                            <font size="2" color="red"><strong>Observação:</strong></font>
                            <font size="2"> Todo lucro obtido com o investimento do usuário/cliente, deve ser inserido um a um para manter a ordem das operações.</font><br><br>
                        </p>
                        <div class="form-actions">
                            <button type="submit" name="lucro" class="btn btn-primary"><i class="fa fa-check"></i> ENVIAR LUCRO</button>
                            <button type="button" class="btn btn-secondary text-white" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

<?php
// Chama função para pegar o POST de cada FORM
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
switch (get_post_action('saque', 'deposito', 'lucro', 'liberar', 'cancelar', 'reinvestir')) {

    case 'saque':

        if (!empty($_POST)) {

            $usuario        = $_POST['id'];
            $descricao      = 'Saque aporte/lucro';
            $tipo           = '2';
            $valor         = $_POST['valor'];
            $valor_saque    = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_saque, 2, ',', '.');
            $valor1 = str_replace('.', '', $valor_solicitado);
            $valor2 = str_replace(',00', '', $valor1);
            $comprovante    = '-';
            $confirmado     = '2';

            $dt_criacao = date("Y-m-d");
            $hr_criacao = date("H:i:s");
            $timestamp = strtotime($dt_criacao);
            $timestamp2 = strtotime($hr_criacao);
            $dt_saque = date('d/m/Y', $timestamp);
            $hr_saque = date('H:i:s', $timestamp2);
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql1 = 'SELECT sum(valor) FROM tbl_investimentos WHERE id_usuario = "' . $usuario . '" AND tipo = 3 AND confirmado = 1';
        foreach ($pdo->query($sql1) as $data_lucro) {
            $lucro = $data_lucro['sum(valor)'];
        }


        $sql2 = 'SELECT sum(valor) FROM tbl_investimentos WHERE id_usuario = "' . $usuario . '" AND tipo = 2 AND confirmado = 1';
        foreach ($pdo->query($sql2) as $data_retiradas) {
            $retiradas = $data_retiradas['sum(valor)'];
        }

        $sql3 = 'SELECT sum(valor) FROM tbl_investimentos WHERE id_usuario = "' . $usuario . '" AND tipo = 1 AND confirmado = 1';
        foreach ($pdo->query($sql3) as $data_saldo) {
            $saldo = $data_saldo['sum(valor)'] + $lucro - $retiradas;
        }

        $saldo_cliente = $saldo;

        if ($valor2 > $saldo_cliente) {
            echo '<script>setTimeout(function () { 
                swal({
                  title: "Opsss!",
                  text: "Valor solicitado superior ao saldo do usuário/cliente!",
                  type: "warning",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes-movimentacao?id=' . $usuario . '";
                  }
                }); }, 1000);</script>';
        }

        if ($saldo_cliente >= $valor2) {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado, operador) VALUES(?,?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario, $descricao, $tipo, $valor_saque, $comprovante, $dt_criacao, $hr_criacao, $confirmado, $_SESSION['UsuarioNome']));

            $sql = "SELECT * FROM tbl_usuarios where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario));
            $data_users = $q->fetch(PDO::FETCH_ASSOC);

            $nome_user = $data_users['nome'];
            $operador  = $_SESSION['UsuarioNome'];

            // ENVIA TELEGRAM    
            $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
            $data2 = [
                "chat_id" => "-1001322495863",
                // "chat_id" => "184418484", // id_telegram: fabio
                'parse_mode' => 'HTML',
                'text' => "\n<b>SOLICITAÇÃO DE SAQUE</b> \n\nSolicitado por: $operador\n\nCliente: $nome_user\nValor: R$ $valor_solicitado\nData: $dt_saque às $hr_saque\n",
            ];

            $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data2));

            echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Solicitação de saque realizada com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes-movimentacao?id=' . $usuario . '";
              }
            }); }, 1000);</script>';
        }

        break;

    case 'deposito':

        if (!empty($_POST)) {

            $usuario        = $_POST['id'];
            $descricao      = 'Depósito aporte';
            $tipo           = '1';
            $valor_deposito = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_deposito, 2, ',', '.');
            $comprovante    = '-';
            $confirmado     = '2';

            $dt_criacao = date("Y-m-d");
            $hr_criacao = date("H:i:s");
            $timestamp = strtotime($dt_criacao);
            $timestamp2 = strtotime($hr_criacao);
            $dt_deposito = date('d/m/Y', $timestamp);
            $hr_deposito = date('H:i:s', $timestamp2);
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado, operador) VALUES(?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario, $descricao, $tipo, $valor_deposito, $comprovante, $dt_criacao, $hr_criacao, $confirmado, $_SESSION['UsuarioNome']));

        $sql = "SELECT * FROM tbl_usuarios where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario));
        $data_users = $q->fetch(PDO::FETCH_ASSOC);

        $nome_user = $data_users['nome'];
        $operador  = $_SESSION['UsuarioNome'];

        // ENVIA TELEGRAM    
        $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
        $data2 = [
            "chat_id" => "-1001322495863",
            'parse_mode' => 'HTML',
            'text' => "\n<b>SOLICITAÇÃO DE DEPÓSITO</b> \n\nSolicitado por: $operador\n\nCliente: $nome_user\nValor: R$ $valor_solicitado\nData: $dt_deposito as $hr_deposito\n ",
        ];

        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data2));

        echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Solicitação de aporte realizada com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes-movimentacao?id=' . $usuario . '";
              }
            }); }, 1000);</script>';

        break;

    case 'lucro':

        if (!empty($_POST)) {

            $usuario        = $_POST['id'];
            $descricao      = 'Lucro de operações';
            $tipo           = '3';
            $valor_lucro    = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $lucro          = number_format($valor_lucro, 2, ',', '.');
            $comprovante    = '-';
            $confirmado     = '1';
            $reinvestir     = '2';

            $dt_criacao = date("Y-m-d");
            $hr_criacao = date("H:i:s");
            $timestamp = strtotime($dt_criacao);
            $timestamp2 = strtotime($hr_criacao);
            $dt_deposito = date('d/m/Y', $timestamp);
            $hr_deposito = date('H:i:s', $timestamp2);
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado, operador, reinvestir) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario, $descricao, $tipo, $valor_lucro, $comprovante, $dt_criacao, $hr_criacao, $confirmado, $_SESSION['UsuarioNome'], $reinvestir));
        echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Lucro inserido com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes-movimentacao?id=' . $usuario . '";
                  }
                }); }, 1000);</script>';

        break;

    case 'liberar':

        if (!empty($_POST)) {

            $id_usuario      = $_POST['id_user'];
            $nome_usuario    = $_POST['nome'];
            $id_transacao    = $_POST['id'];
            $tipo_transacao  = $_POST['tipo'];
            $valor_transacao = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_transacao, 2, ',', '.');
            $confirmado   = '1';

            if ($tipo_transacao == 1) {
                $tipo_transacao = 'DEPÓSITO';
            }
            if ($tipo_transacao == 2) {
                $tipo_transacao = 'SAQUE';
            }
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_investimentos SET confirmado = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($confirmado, $id_transacao));

        $sql = "SELECT * FROM tbl_investimentos where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id_transacao));
        $data_operacao = $q->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM tbl_usuarios where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id_usuario));
        $data_users = $q->fetch(PDO::FETCH_ASSOC);

        $user_id   = $data_users['id'];
        $nome_user = $data_users['nome'];

        $timestamp = strtotime($data_operacao['dt_criacao']);
        $timestamp2 = strtotime($data_operacao['hr_criacao']);
        $dt_transacao = date('d/m/Y', $timestamp);
        $hr_transacao = date('H:i:s', $timestamp2);

        require('../../includes/phpmailer/hdw-phpmailer.php');


        $emailAssunto  = 'Liberação de Movimentação | Cripto4You';
        $emailMensagem = "
<style type='text/css'>
<!--
.style1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
	font-size: 18px;
}
-->
</style>
<p align='center'>&nbsp;</p>
<p align='center'><img src='https://cripto4you.net/assets/images/email/header_email.png' width='980' height='150'></p>
<p align='center' class='style1'>&nbsp;</p>
<p align='center' class='style1'>Ol&aacute; {$nome_user},</p>
<p align='center' class='style1'>Sua solicita&ccedil;&atilde;o de {$tipo_transacao} no valor de R$ {$valor_solicitado} realizada em {$dt_transacao} às {$hr_transacao} foi realizada com sucesso.</p>
<p align='center' class='style1'>Voc&ecirc; pode conferir a transa&ccedil;&atilde;o acessando nosso painel de gest&atilde;o no menu INVESTIMENTO \ EXTRATO.</p>
<p align='center' class='style1'>&nbsp;</p>
<p align='center' class='style1'>Obrigado,</p>
<p align='center' class='style1'>&nbsp;</p>
<p align='center'><img src='https://cripto4you.net/assets/images/email/footer_email.png' width='350' height='130'></p>
<br />
";
        $id_smtp =  '1';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM tbl_smtp';
        $q = $pdo->prepare($sql);
        $q->execute(array($id_smtp));
        $contato = $q->fetch(PDO::FETCH_ASSOC);

        $email_de        = $contato['email_de'];
        $email_para      = $data_users['email'];
        $email_para_nome = $data_users['nome'];
        $host_smtp       = $contato['host_smtp'];
        $porta_smtp      = $contato['porta_smtp'];
        $encrypt_smtp    = $contato['encrypt_smtp'];
        $email_login     = $contato['email_login'];
        $email_senha     = $contato['email_senha'];
        $emailDe          = array();

        $emailDe['from']        = $email_de;
        $emailDe['fromName']    = $contato['email_para_nome'];
        $emailDe['replyTo']     = $email;
        $emailDe['returnPath']  = $email_de;
        $emailDe['confirmTo']   = '';
        $emailPara              = array();
        $emailPara[1]['to']     = $email_para;
        $emailPara[1]['toName'] = $email_para_nome;
        // #2
        //$emailPara[2]['to']		= 'seuemail2@seudominio.com.br';
        //$emailPara[2]['toName']	= 'Seu Nome2';

        $SMTP             = array();
        $SMTP['host']     = $host_smtp;
        $SMTP['port']     = $porta_smtp;
        $SMTP['encrypt']  = $encrypt_smtp;
        $SMTP['username'] = $email_login;
        $SMTP['password'] = $email_senha;
        $SMTP['charset']  = 'utf-8';
        $SMTP['priority'] = 1;
        $SMTP['debug']    = FALSE;

        $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);

        if ($mail !== TRUE) {
            echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
            exit;
        }

        echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Liberação realizada com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes-movimentacao?id=' . $user_id . '";
              }
            }); }, 1000);</script>';

        break;

    case 'cancelar':

        if (!empty($_POST)) {

            $id_usuario      = $_POST['id_user'];
            $nome_usuario    = $_POST['nome'];
            $id_transacao    = $_POST['id'];
            $tipo_transacao  = $_POST['tipo'];
            $valor_transacao = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_transacao, 2, ',', '.');
            $confirmado   = '3';

            if ($tipo_transacao == 1) {
                $tipo_transacao = 'DEPÓSITO';
            }
            if ($tipo_transacao == 2) {
                $tipo_transacao = 'SAQUE';
            }
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_investimentos SET confirmado = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($confirmado, $id_transacao));

        $sql = "SELECT * FROM tbl_investimentos where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id_transacao));
        $data_operacao = $q->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM tbl_usuarios where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id_usuario));
        $data_users = $q->fetch(PDO::FETCH_ASSOC);

        $user_id   = $data_users['id'];
        $nome_user = $data_users['nome'];

        $timestamp = strtotime($data_operacao['dt_criacao']);
        $timestamp2 = strtotime($data_operacao['hr_criacao']);
        $dt_transacao = date('d/m/Y', $timestamp);
        $hr_transacao = date('H:i:s', $timestamp2);

        require('../../includes/phpmailer/hdw-phpmailer.php');


        $emailAssunto  = 'Liberação de Movimentação | Cripto4You';
        $emailMensagem = "
    <style type='text/css'>
    <!--
    .style1 {
        font-family: Geneva, Arial, Helvetica, sans-serif;
        color: #333333;
        font-size: 18px;
    }
    -->
    </style>
    <p align='center'>&nbsp;</p>
    <p align='center'><img src='https://cripto4you.net/assets/images/email/header_email.png' width='980' height='150'></p>
    <p align='center' class='style1'>&nbsp;</p>
    <p align='center' class='style1'>Ol&aacute; {$nome_user},</p>
    <p align='center' class='style1'>Sua solicita&ccedil;&atilde;o de {$tipo_transacao} no valor de R$ {$valor_solicitado} realizada em {$dt_transacao} às {$hr_transacao} foi cancelada com sucesso.</p>
    <p align='center' class='style1'>Voc&ecirc; pode conferir a transa&ccedil;&atilde;o acessando nosso painel de gest&atilde;o no menu INVESTIMENTO \ EXTRATO.</p>
    <p align='center' class='style1'>&nbsp;</p>
    <p align='center' class='style1'>Obrigado,</p>
    <p align='center' class='style1'>&nbsp;</p>
    <p align='center'><img src='https://cripto4you.net/assets/images/email/footer_email.png' width='350' height='130'></p>
    <br />
    ";
        $id_smtp =  '1';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM tbl_smtp';
        $q = $pdo->prepare($sql);
        $q->execute(array($id_smtp));
        $contato = $q->fetch(PDO::FETCH_ASSOC);

        $email_de        = $contato['email_de'];
        $email_para      = $data_users['email'];
        $email_para_nome = $data_users['nome'];
        $host_smtp       = $contato['host_smtp'];
        $porta_smtp      = $contato['porta_smtp'];
        $encrypt_smtp    = $contato['encrypt_smtp'];
        $email_login     = $contato['email_login'];
        $email_senha     = $contato['email_senha'];
        $emailDe          = array();

        $emailDe['from']        = $email_de;
        $emailDe['fromName']    = $contato['email_para_nome'];
        $emailDe['replyTo']     = $email;
        $emailDe['returnPath']  = $email_de;
        $emailDe['confirmTo']   = '';
        $emailPara              = array();
        $emailPara[1]['to']     = $email_para;
        $emailPara[1]['toName'] = $email_para_nome;
        // #2
        //$emailPara[2]['to']		= 'seuemail2@seudominio.com.br';
        //$emailPara[2]['toName']	= 'Seu Nome2';

        $SMTP             = array();
        $SMTP['host']     = $host_smtp;
        $SMTP['port']     = $porta_smtp;
        $SMTP['encrypt']  = $encrypt_smtp;
        $SMTP['username'] = $email_login;
        $SMTP['password'] = $email_senha;
        $SMTP['charset']  = 'utf-8';
        $SMTP['priority'] = 1;
        $SMTP['debug']    = FALSE;

        $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);

        if ($mail !== TRUE) {
            echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
            exit;
        }

        echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Cancelamento realizado com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes-movimentacao?id=' . $user_id . '";
                  }
                }); }, 1000);</script>';

        break;

    case 'reinvestir':

        if (!empty($_POST)) {

            $id_usuario       = $_POST['id_user'];
            $nome_usuario     = $_POST['nome'];
            $id_transacao     = $_POST['id'];
            $tipo_transacao   = $_POST['tipo'];
            $valor_transacao  = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_transacao, 2, ',', '.');
            $reinvestir       = '1';
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_investimentos SET reinvestir = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($reinvestir, $id_transacao));

        echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Lucro reinvestido com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes-movimentacao?id=' . $user_id . '";
                  }
                }); }, 1000);</script>';

        break;

    default:
}
?>

<?php include('../../includes/footer.php'); ?>