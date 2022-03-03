<?php

if ($_SERVER['HTTP_HOST'] != 'localhost') {
    if (!isset($_SESSION)) session_start();

    $nivel = 1;

    if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
        echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
        exit;
    }
}

include('../../includes/header.php');

$id = $_SESSION['UsuarioID'];
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
                [0, "DESC"]
            ]
        });
    });
</script>


<script>
    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function mreais(v) {
        v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
        v = v.replace(/(\d{2})$/, ",$1") //Coloca a virgula
        v = v.replace(/(\d+)(\d{3},\d{2})$/g, "$1.$2") //Coloca o primeiro ponto

        if (v.length >= 5) {
            var maximo = v.replace(/\./g, '').replace(',', '.') > 5000;
            var minimo = v.replace(/\./g, '').replace(',', '.') < 100;

            if (maximo) {
                return '5.000,00';
            } else if (minimo) {
                return '100,00';
            } else {
                return v;
            }
        } else {
            return v;
        }
    }
</script>
<script>
    function mascara2(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function mreais(v) {
        v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
        v = v.replace(/(\d{2})$/, ",$1") //Coloca a virgula
        v = v.replace(/(\d+)(\d{3},\d{2})$/g, "$1.$2") //Coloca o primeiro ponto

        if (v.length >= 5) {
            var maximo = v.replace(/\./g, '').replace(',', '.') > 500000;
            var minimo = v.replace(/\./g, '').replace(',', '.') < 1000;

            if (maximo) {
                return '500.000,00';
            } else if (minimo) {
                return '1.000,00';
            } else {
                return v;
            }
        } else {
            return v;
        }
    }
</script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="ml-auto" align="left">
                <div>
                    <?php if ($data['contrato_aceito'] == 2) { ?>
                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalSaque" title="SOLICITAR RETIRADA"><i class="fas fa-minus-circle"></i> Retirada</button>
                    <?php }
                    if ($data['contrato_aceito'] == 1) { ?>
                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalContrato" title="SOLICITAR RETIRADA"><i class="fas fa-minus-circle"></i> Retirada</button>
                    <?php } ?>
                    <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#modalDeposito" title="ADICIONAR APORTE"><i class="fas fa-plus-circle"></i> Aporte</button>
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
                                <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
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
                            // $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" ORDER BY dt_criacao DESC, hr_criacao DESC';
                            $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" ORDER BY id DESC';

                            foreach ($pdo->query($sql) as $row) {

                                if ($row['id']) {
                                    $id_movimentacao = '' . $row['id'] . '';
                                }

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
                                if ($row['tipo'] == 3 and $row['reinvestir'] == 1) {
                                    $tipo = '<font color="orange"> Lucro reinvestido </font>';
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
                                if ($row['confirmado'] == 3) {
                                    $confirmado = 'Cancelado';
                                }

                                echo "<tr>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $id_movimentacao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $descricao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $tipo . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $dt_criacao . " às " . $hr_criacao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $confirmado . "</td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>R$ " . number_format($valor, 2, ',', '.') . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important' width=80>";

                                if ($row['tipo'] == 3 and $row['reinvestir'] == 2) {
                                    echo '<form action="meu-investimento" method="POST">';
                                    echo '<input type="hidden" name="id_user" id="id_user" value="' . $_SESSION['UsuarioID'] . '" >';
                                    echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                                    echo '<input type="hidden" name="valor" id="valor" value="' . $valor . '" >';
                                    echo '<button type="submit" title="REINVESTIR LUCRO" class="btn btn-sm btn-outline-info" name="reinvestir">REINVESTIR</button>';
                                    echo '<br><button type="submit" title="SACAR LUCRO" class="btn btn-sm btn-outline-danger" name="sacarLucro">SACAR</button>';
                                    echo "</form>";
                                }
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
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">SOLICITAR RETIRADA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="meu-investimento" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="basicInput">Informe o Valor da Retirada:</label>
                                        <input type="hidden" class="form-control" id="dias" name="dias" value="<?php if ($data['tipo_contrato'] == 2) { ?>30<?php }
                                                                                                                                                        if ($data['tipo_contrato'] == 3) { ?>15<?php } ?>" readonly>
                                        <input type="hidden" class="form-control" id="dt_saque" name="dt_saque" value="<?php echo converte($data['dt_saque'], 2); ?>" autocomplete="off" readonly>
                                        <input type="hidden" class="form-control" id="prox_saque" name="prox_saque" autocomplete="off" readonly>
                                        <input type="text" class="form-control" id="valor" name="valor" placeholder="1.000,00" onkeypress="mascara(this,mreais)" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="justify">
                            <font size="2" color="red"><strong>Observação:</strong></font><br>
                            <font size="2" color="black">Valor mínimo para retirada: R$ 100,00<br>Valor máximo para retirada: R$ 5.000,00</font><br><br>
                            <font size="2">Após aprovação do saque pela nossa equipe, o prazo de tranferência para sua conta bancária através de PIX é de até 7 dias úteis. Está transferência será realizada para sua conta PIX informada em sua conta em nossa plataforma.</font>
                        </p>
                        <div class="form-actions">
                            <button type="submit" name="saque" class="btn btn-sm btn-outline-danger"><i class="fa fa-check"></i> SOLICITAR RETIRADA</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- Exibe o Modal para solicitação de depósito -->
    <div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="modalDeposito" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ENVIO DE APORTE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="meu-investimento" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="basicInput">Informar o Valor do Aporte:</label>
                                        <input type="text" class="form-control" id="valor" name="valor" placeholder="100.000,00" onkeypress="mascara2(this,mreais)" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="justify">
                            <font size="2" color="red"><strong>Observação:</strong></font><br>
                            <font size="2" color="black">Valor mínimo para aporte: R$ 1.000,00<br>Valor máximo para aporte: R$ 500.000,00</font><br><br>
                            <font size="2"> Todo depósito de aporte de capital deverá ser enviado por uma conta bancária ou carteira em sua titularidade. A transferência deverá ser realizada para as carteiras ou PIX listados abaixo no prazo de 2h. Após realizar a transferência, enviar comprovante da transação para <a href="mailto:financeiro@cripto4you.net" target="_blank">financeiro@cripto4you.net</a>, utilizando seu e-mail de cadastro em nossa plataforma. O prazo de confirmação e inclusão do valor em seu saldo é de até 24h.</font><br><br>
                        </p>
                        <p align="left">
                            <font size="2"><strong>Carteira BUSD:</strong> 0x8d0c1fb55d15faa0aaa53e94ac5cf867ae532e63</font><br>
                            <font size="2"><strong>Rede:</strong> BEP20</font><br><br>
                            <font size="2"><strong>PIX CNPJ:</strong> 34.837.022/0001-22</font>
                        </p>
                        <div class="form-actions">
                            <button type="submit" name="deposito" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> ENVIAR APORTE</button>
                            <button type="button" class="btn btn-sm outline btn-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalContrato" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" ole="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ACEITE DE CONTRATO</h5>
            </div>
            <form action="dashboard" method="post">
                <div class="modal-body">
                    <div style="width: 100%; height:400px; overflow-y:scroll;">
                        <br>
                        <?php include('../../includes/contrato.php'); ?>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <!-- <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> DEIXAR PARA DEPOIS</button> -->
                    <button type="submit" name="contrato" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Li e aceito os termos deste contrato</button>
                </div>
            </form>
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
switch (get_post_action('saque', 'deposito', 'reinvestir', 'sacarLucro')) {

    case 'saque':

        if (!empty($_POST)) {

            $usuario        = $_SESSION['UsuarioID'];
            $descricao      = 'Saque aporte/lucro';
            $tipo           = '2';
            $valor         = $_POST['valor'];
            $valor_saque    = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_saque, 2, ',', '.');
            $valor1 = str_replace('.', '', $valor_solicitado);
            $valor2 = str_replace(',00', '', $valor1);
            $comprovante    = '-';
            $confirmado     = '2';
            $prox_saque       = $_POST['prox_saque'];

            $dt_criacao = date("Y-m-d");
            $hr_criacao = date("H:i:s");
            $timestamp = strtotime($dt_criacao);
            $timestamp2 = strtotime($hr_criacao);
            $dt_saque = date('d/m/Y', $timestamp);
            $hr_saque = date('H:i:s', $timestamp2);
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql_contrato = "SELECT * FROM tbl_usuarios where id = ?";
        $q = $pdo->prepare($sql_contrato);
        $q->execute(array($usuario));
        $data_contrato = $q->fetch(PDO::FETCH_ASSOC);


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

        if ($data['dt_saque'] != date('Y-m-d')) {
            echo '<script>setTimeout(function () { 
            swal({
              title: "Opsss!",
              text: "Saque fora da data programada. Entre em contato conosco!",
              type: "warning",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "meu-investimento";
              }
            }); }, 1000);</script>';
        }
        if ($data['dt_saque'] >= date('Y-m-d') and $data_contrato['contrato_aceito'] != 1) {
            if ($valor2 > $saldo_cliente) {
                echo '<script>setTimeout(function () { 
                swal({
                  title: "Opsss!",
                  text: "Valor solicitado superior ao saldo disponível!",
                  type: "warning",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "meu-investimento";
                  }
                }); }, 1000);</script>';
            }
            if ($saldo_cliente >= $valor2) {

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql_saque = "UPDATE tbl_usuarios set dt_saque = ? WHERE id = ?";
                $q = $pdo->prepare($sql_saque);
                $q->execute(array($prox_saque, $usuario));

                $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado) VALUES(?,?,?,?,?,?,?,?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($usuario, $descricao, $tipo, $valor_saque, $comprovante, $dt_criacao, $hr_criacao, $confirmado));

                $sql = "SELECT * FROM tbl_usuarios where id = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($usuario));
                $data_users = $q->fetch(PDO::FETCH_ASSOC);

                $nome_user = $data_users['nome'];

                // ENVIA TELEGRAM    
                $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
                $data2 = [
                    "chat_id" => "-1001322495863",
                    // "chat_id" => "184418484", // id_telegram: fabio
                    'parse_mode' => 'HTML',
                    'text' => "\n<b>SOLICITAÇÃO DE SAQUE</b> \n\nCliente: $nome_user\nValor: R$ $valor_solicitado\nData: $dt_saque às $hr_saque\n",
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
                window.location.href = "meu-investimento";
              }
            }); }, 1000);</script>';
            }
        } else {
            echo '<script>setTimeout(function () { 
            swal({
              title: "Opsss!",
              text: "Contrato não aceito ou data de saque indisponível!",
              type: "warning",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "meu-investimento";
              }
            }); }, 1000);</script>';
        }
        break;

    case 'deposito':

        if (!empty($_POST)) {

            $usuario        = $_SESSION['UsuarioID'];
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
        $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, valor, comprovante, dt_criacao, hr_criacao, confirmado) VALUES(?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario, $descricao, $tipo, $valor_deposito, $comprovante, $dt_criacao, $hr_criacao, $confirmado));

        $sql = "SELECT * FROM tbl_usuarios where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($usuario));
        $data_users = $q->fetch(PDO::FETCH_ASSOC);

        $nome_user = $data_users['nome'];

        // ENVIA TELEGRAM    
        $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
        $data2 = [
            "chat_id" => "-1001322495863",
            'parse_mode' => 'HTML',
            'text' => "\n<b>SOLICITAÇÃO DE DEPÓSITO</b> \n\nUsuário: $nome_user\nValor: R$ $valor_solicitado\nData: $dt_deposito as $hr_deposito\n ",
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
                window.location.href = "meu-investimento";
              }
            }); }, 1000);</script>';

        break;

    case 'reinvestir':

        if (!empty($_POST)) {

            $id_usuario       = $_POST['id_user'];
            $id_transacao     = $_POST['id'];
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
                        window.location.href = "meu-investimento?id=' . $id_usuario . '";
                      }
                    }); }, 1000);</script>';

        break;

    case 'sacarLucro':

        if (!empty($_POST)) {

            $id_usuario       = $_POST['id_user'];
            $id_transacao     = $_POST['id'];
            $tipo_transacao   = '2';
            $valor_transacao  = str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $valor_solicitado = number_format($valor_transacao, 2, ',', '.');
            $confirmado       = '2';
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_investimentos SET valor = ?, tipo = ?, confirmado = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($valor_transacao, $tipo_transacao, $confirmado, $id_transacao));

        echo '<script>setTimeout(function () { 
                    swal({
                      title: "Parabéns!",
                      text: "Solicitação de saque do lucro realizada com sucesso!",
                      type: "success",
                      confirmButtonText: "OK" 
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        window.location.href = "clientes-movimentacao?id=' . $id_usuario . '";
                      }
                    }); }, 1000);</script>';

        break;

    default:
}
?>


<?php include('../../includes/footer.php');

// SOMA DIAS PARA SAQUE
if ($data['tipo_contrato'] == '1') { ?>
    <script type="text/javascript">
        $('#dt_saque')[0].valueAsDate = new Date();

        $('#dt_saque').change(function() {
            var date = this.valueAsDate;
            date.setDate(date.getDate() + 1);
            $('#prox_saque')[0].valueAsDate = date;
        });

        $('#dt_saque').change();
    </script>
<?php }
if ($data['tipo_contrato'] == '2') { ?>
    <script type="text/javascript">
        $('#dt_saque')[0].valueAsDate = new Date();

        $('#dt_saque').change(function() {
            var date = this.valueAsDate;
            date.setDate(date.getDate() + 30);
            $('#prox_saque')[0].valueAsDate = date;
        });

        $('#dt_saque').change();
    </script>
<?php }
if ($data['tipo_contrato'] == '3') { ?>
    <script type="text/javascript">
        $('#dt_saque')[0].valueAsDate = new Date();

        $('#dt_saque').change(function() {
            var date = this.valueAsDate;
            date.setDate(date.getDate() + 15);
            $('#prox_saque')[0].valueAsDate = date;
        });

        $('#dt_saque').change();
    </script>
<?php } ?>