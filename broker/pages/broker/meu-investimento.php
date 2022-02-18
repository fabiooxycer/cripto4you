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
                </div>
            </div><br>
            <h4 class="m-0 font-weight-bold text-primary">EXTRATO - MEU INVESTIMENTO</h4>
            <p class="mb-4">Abaixo serão listadas todas movimentações realizadas em sua conta.</p>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pdo = BancoCadastros::conectar();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" ORDER BY dt_criacao DESC, hr_criacao DESC';

                            foreach ($pdo->query($sql) as $row) {

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
                                    $valor = '' . $row['valor'] . '';
                                }
                                if ($row['confirmado'] == 1) {
                                    $confirmado = 'Autorizado';
                                }
                                if ($row['confirmado'] == 2) {
                                    $confirmado = 'Aguardando Liberação';
                                }

                                echo "<tr>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $descricao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $tipo . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $dt_criacao . " às " . $hr_criacao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $confirmado . "</td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>R$ " . number_format($valor, 2, ',', '.') . "</font></td>";
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
    <div class="modal" id="modalSaque" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">SOLICITAR SAQUE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="meu-investimento" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="basicInput">Valor:</label>
                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" placeholder="3.000,00" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
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
    <div class="modal" id="modalDeposito" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">DEPÓSITO DE APORTE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="meu-investimento" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="basicInput">Valor:</label>
                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" placeholder="20.000,00" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="justify">
                            <font size="2" color="red"><strong>Observação:</strong></font>
                            <font size="2"> Todo depósito de aporte de capital deverá ser enviado por uma conta bancária ou carteira em sua titularidade. A transferência deverá ser realizada para as carteiras ou PIX listados abaixo no prazo de 2h. Após realizar a transferência, enviar comprovante da transação para <a href="mailto:financeiro@cripto4you.net" target="_blank">financeiro@cripto4you.net</a>, utilizando seu e-mail de cadastro em nossa plataforma. O prazo de confirmação e inclusão do valor em seu saldo é de até 24h.</font><br><br>
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
switch (get_post_action('saque', 'deposito')) {

    case 'saque':

        if (!empty($_POST)) {

            $usuario     = $_SESSION['UsuarioID'];
            $descricao   = 'Saque aporte/lucro';
            $tipo        = '2';
            $valor       = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $comprovante = '-';
            $dt_criacao  = date("Y-m-d");
            $hr_criacao  = date("H:i:s");
            $confirmado  = '2';
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado) VALUES(?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario, $descricao, $tipo, $valor, $comprovante, $dt_criacao, $hr_criacao, $confirmado));
        echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Solicitação de saque realizada com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "meu-investimento";
              }
            }); }, 1000);</script>';
        break;

    case 'deposito':

        if (!empty($_POST)) {

            $usuario     = $_SESSION['UsuarioID'];
            $descricao   = 'Depósito aporte';
            $tipo        = '1';
            $valor       = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $comprovante = '-';
            $dt_criacao  = date("Y-m-d");
            $hr_criacao  = date("H:i:s");
            $confirmado  = '2';
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado) VALUES(?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario, $descricao, $tipo, $valor, $comprovante, $dt_criacao, $hr_criacao, $confirmado));
        echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Solicitação de aporte realizada com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "meu-investimento";
                  }
                }); }, 1000);</script>';
        break;

    default:
}
?>

<?php include('../../includes/footer.php'); ?>