<?php
if ($_SERVER['HTTP_HOST'] != 'localhost') {
   if (!isset($_SESSION)) session_start();

   $nivel = 1;

   if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo '<script>setTimeout(function () { 
            swal({
              title: "Oopss!",
              text: "Você não possui permissão para exibir esta tela!",
              type: "warning",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "entrar";
              }
            }); }, 1000);</script>';

      exit;
   }
} else {
   if (!isset($_SESSION)) session_start();
}

include('includes/header.php');
include('includes/menu.php');
include('includes/topnavbar.php');
include('includes/scripts.php');

$id = null;
if (!empty($_GET['id'])) {
   $id = $_REQUEST['id'];
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_usuarios where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
?>

<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">
                        <li>MOVIMENTAÇÃO DE <?php echo $data['nome']; ?></li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo serão listadas, todas as movimentações do cliente selecionado</p>
                  <div class="ml-auto" align="left">
                     <div>
                        <a type="button" class="btn btn-sm btn-outline-dark" href="clientes" title="VOLTAR"><i class="fas fa-undo"></i></a>
                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalSaque" title="SOLICITAR RETIRADA"><i class="fas fa-minus-circle"></i> Retirada</button>
                        <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#modalDeposito" title="ADICIONAR APORTE"><i class="fas fa-plus-circle"></i> Aporte</button>
                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modalLucro" title="ADICIONAR LUCRO"><i class="fas fa-money-bill"></i> Lucro</button>
                     </div>
                  </div><br>
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important'>Cód.</th>
                              <th style='text-align: center; vertical-align:middle !important'>Descrição</th>
                              <th style='text-align: center; vertical-align:middle !important'>Tipo</th>
                              <th style='text-align: center; vertical-align:middle !important'>Data/Horário</th>
                              <th style='text-align: center; vertical-align:middle !important'>Situação</th>
                              <th style='text-align: center; vertical-align:middle !important'>V. Bruto</th>
                              <th style='text-align: center; vertical-align:middle !important'>Taxa Trader</th>
                              <th style='text-align: center; vertical-align:middle !important'>V. Liq.</th>
                              <th style='text-align: center; vertical-align:middle !important'>Ação</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $id . '" ORDER BY id DESC';

                           foreach ($pdo->query($sql) as $row) {

                              $id_movimentacao = $row['id'];

                              if ($row['descricao']) {
                                 $descricao = '' . $row['descricao'] . '';
                              }
                              if ($row['tipo'] == 1) {
                                 $tipo = '<font color="blue"> Crédito/Aporte </font>';
                              }
                              if ($row['tipo'] == 2) {
                                 $tipo = '<font color="red"> Débito/Retirada </font>';
                              }
                              if ($row['tipo'] == 3) {
                                 $tipo = '<font color="green"> Lucro </font>';
                              }
                              if ($row['tipo'] == 3 and $row['reinvestir'] == 1) {
                                 $tipo = '<font color="orange"> Lucro reinvestido </font>';
                              }

                              if ($row['dt_criacao']) {
                                 $data_criacao = '' . $row['dt_criacao'] . '';
                              }
                              if ($row['hr_criacao']) {
                                 $hora_criacao = '' . $row['hr_criacao'] . '';
                                 $timestamp2 = strtotime($hora_criacao);
                                 $hr_criacao = date('H:i:s', $timestamp2);
                              }

                              // VALOR LUCRO - TAXA -------------------------------------------------
                              if ($row['taxa'] != null) {
                                 $taxa = '-R$ ' . number_format($row['taxa'], 2, ',', '.') . '';
                              }
                              if ($row['taxa'] == null) {
                                 $taxa = '<font color="black">-</font>';
                              }
                              if ($row['valor']) {
                                 $valor = '' . number_format($row['valor'], 2, ',', '.') . '';
                              }

                              $valor_bruto   = $row['valor'] + $row['taxa'];
                              $valor_liquido = $valor_bruto - $row['taxa'];
                              // -------------------------------------------------------------------

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
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . converte($data_criacao, 2) . " às " . $hr_criacao . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $confirmado . "</td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='blue'>R$ " . number_format($valor_bruto, 2, ',', '.') .  "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='red'>" . $taxa .  "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='green'>R$ " . number_format($valor_liquido, 2, ',', '.') . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                              echo '<form action="clientes-movimentacao" method="POST">';
                              echo '<input type="hidden" name="id_user" id="id_user" value="' . $id . '" >';
                              echo '<input type="hidden" name="nome" id="nome" value="' . $data['nome'] . '" >';
                              echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                              echo '<input type="hidden" name="tipo" id="tipo" value="' . $row['tipo'] . '" >';
                              echo '<input type="hidden" name="valor" id="valor" value="' . $valor . '" >';
                              if ($row['confirmado'] == 2) {
                                 echo '<button type="submit" title="LIBERAR MOVIMENTAÇÃO" class="btn btn-sm btn-outline-success" name="liberar">LIBERAR</button><br>';
                                 echo '<br><button type="submit" title="CANCELAR MOVIMENTAÇÃO" class="btn btn-sm btn-outline-danger" name="cancelar">CANCELAR</button>';
                              }
                              if ($row['tipo'] == 3 and $row['reinvestir'] != 1) {
                                 echo '<button type="submit" title="REINVESTIR LUCRO" class="btn btn-sm btn-outline-info" name="reinvestir">REINVESTIR</button><br>';
                                 echo '<br><button type="submit" title="SACAR LUCRO" class="btn btn-sm btn-outline-danger" name="sacarLucro">SACAR</button>';
                              }

                              echo "</form>";
                              echo "</td>";
                           }
                           echo "</tr>";
                           ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important'>Cód.</th>
                              <th style='text-align: center; vertical-align:middle !important'>Descrição</th>
                              <th style='text-align: center; vertical-align:middle !important'>Tipo</th>
                              <th style='text-align: center; vertical-align:middle !important'>Data/Horário</th>
                              <th style='text-align: center; vertical-align:middle !important'>Situação</th>
                              <th style='text-align: center; vertical-align:middle !important'>V. Bruto</th>
                              <th style='text-align: center; vertical-align:middle !important'>Taxa Trader</th>
                              <th style='text-align: center; vertical-align:middle !important'>V. Liq.</th>
                              <th style='text-align: center; vertical-align:middle !important'>Ação</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Exibe o Modal para solicitação de saque -->
<div class="modal fade" id="modalSaque" tabindex="-1" role="dialog" aria-labelledby="modalSaque" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">SOLICITAR RETIRADA</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <form action="clientes-movimentacao?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="basicInput">Informe o Valor da Retirada:</label>
                           <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>" autocomplete="off" readonly>

                           <input type="hidden" class="form-control" id="dias" name="dias" value="<?php if ($data['tipo_contrato'] == 2) { ?>30<?php }
                                                                                                                                             if ($data['tipo_contrato'] == 3) { ?>15<?php } ?>" readonly>
                           <input type="hidden" class="form-control" id="dt_saque" name="dt_saque" value="<?php echo converte($data['dt_saque'], 2); ?>" autocomplete="off" readonly>
                           <input type="hidden" class="form-control" id="prox_saque" name="prox_saque" autocomplete="off" readonly>
                           <input type="text" class="form-control" id="retirada" name="retirada" placeholder="1.000,00" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" required>
                        </div>
                     </div>
                  </div>
               </div>
               <p align="justify">
                  <font size="2" color="red"><strong>Observação:</strong></font><br>
                  <font size="2" color="white">Valor mínimo para retirada: R$ 100,00<br>Valor máximo para retirada: R$ 5.000,00</font><br><br>
                  <font size="2">Após aprovação do saque pela nossa equipe, o prazo de tranferência para sua conta bancária através de PIX é de até 7 dias úteis. Está transferência será realizada para sua conta PIX informada em sua conta em nossa plataforma.</font>
               </p>
               <div class="modal-footer"></div>
               <div class="form-actions" align="right">
                  <button type="submit" name="saque" class="btn btn-sm btn-outline-danger"><i class="fa fa-check"></i> SOLICITAR RETIRADA</button>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Exibe o Modal para solicitação de depósito -->
<div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="modalDeposito" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">ENVIO DE APORTE</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <form action="clientes-movimentacao?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="basicInput">Informar o Valor do Aporte:</label>
                           <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>" autocomplete="off" readonly>
                           <input type="hidden" class="form-control" id="nome" name="nome" value="<?php echo $data['nome']; ?>" autocomplete="off" readonly>
                           <input type="text" class="form-control" id="aporte" name="aporte" placeholder="100.000,00" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" required>
                        </div>
                     </div>
                  </div>
               </div>
               <p align="justify">
                  <font size="2" color="red"><strong>Observação:</strong></font><br>
                  <font size="2" color="white">Valor mínimo para aporte: R$ 1.000,00<br>Valor máximo para aporte: R$ 500.000,00</font><br><br>
                  <font size="2"> Todo depósito de aporte de capital deverá ser enviado por uma conta bancária ou carteira em sua titularidade. A transferência deverá ser realizada para as carteiras ou PIX listados abaixo no prazo de 2h. Após realizar a transferência, enviar comprovante da transação para <a href="mailto:financeiro@cripto4you.net" target="_blank">financeiro@cripto4you.net</a>, utilizando seu e-mail de cadastro em nossa plataforma. O prazo de confirmação e inclusão do valor em seu saldo é de até 24h.</font><br><br>
               </p>
               <p align="left">
                  <font size="2"><strong>Carteira BUSD:</strong> 0x8d0c1fb55d15faa0aaa53e94ac5cf867ae532e63</font><br>
                  <font size="2"><strong>Rede:</strong> BEP20</font><br><br>
                  <font size="2"><strong>PIX CNPJ:</strong> 34.837.022/0001-22</font>
               </p>
               <div class="modal-footer"></div>
               <div class="form-actions" align="right">
                  <button type="submit" name="deposito" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> ENVIAR APORTE</button>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Exibe o Modal para inseção de Lucro -->
<div class="modal fade" id="modalLucro" tabindex="-1" role="dialog" aria-labelledby="modalLucro" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">CREDITAR LUCRO</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <form action="clientes-movimentacao?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="basicInput">Informe o Valor do Lucro:</label>
                           <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>" autocomplete="off" readonly>
                           <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" placeholder="500,00" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="basicInput">Informe o Valor da Taxa:</label>
                           <input type="text" class="form-control" id="taxa" name="taxa" onKeyPress="return(moeda(this,'.',',',event))" placeholder="500,00" autocomplete="off" required>
                        </div>
                     </div>
                  </div>
               </div>
               <p align="justify">
                  <font size="2" color="red"><strong>Observação:</strong></font>
                  <font size="2"> Todo lucro obtido com o investimento do usuário/cliente, deve ser inserido um a um para manter a ordem das operações.</font><br><br>
               </p>
               <div class="modal-footer"></div>
               <div class="form-actions" align="right">
                  <button type="submit" name="lucro" class="btn btn-sm btn-outline-info"><i class="fa fa-check"></i> CREDITAR LUCRO</button>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

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

switch (get_post_action('saque', 'deposito', 'lucro', 'liberar', 'cancelar', 'reinvestir', 'sacarLucro')) {

   case 'saque':

      if (!empty($_POST)) {

         $usuario          = $_POST['id'];
         $descricao        = 'Saque aporte/lucro';
         $tipo             = '2';
         $valor            = $_POST['valor'];
         $valor_saque      = str_replace(',', '.', str_replace('.', '', $_POST['retirada']));
         $valor_solicitado = number_format($valor_saque, 2, ',', '.');
         $valor1           = str_replace('.', '', $valor_solicitado);
         $valor2           = str_replace(',00', '', $valor1);
         $comprovante      = '-';
         $confirmado       = '2';
         $prox_saque       = $_POST['prox_saque'];

         $dt_criacao = date("Y-m-d");
         $hr_criacao = date("H:i:s");
         $timestamp = strtotime($dt_criacao);
         $timestamp2 = strtotime($hr_criacao);
         $dt_saque = date('d/m/Y', $timestamp);
         $hr_saque = date('H:i:s', $timestamp2);
      }


      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql_contrato = "SELECT contrato_aceito FROM tbl_usuarios where id = ?";
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

      if ($data_contrato['contrato_aceito'] == '1') {
         echo '<script>setTimeout(function () { 
                swal({
                  title: "Opsss!",
                  text: "Usuário/Cliente não aceito o contrato de investimento!",
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
         $sql_saque = "UPDATE tbl_usuarios set dt_saque = ? WHERE id = ?";
         $q = $pdo->prepare($sql_saque);
         $q->execute(array($prox_saque, $usuario));

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
         $valor_deposito = str_replace(',', '.', str_replace('.', '', $_POST['aporte']));
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
         $taxa_lucro    = str_replace(',', '.', str_replace('.', '', $_POST['taxa']));
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
      $sql = "INSERT INTO tbl_investimentos (id_usuario, descricao, tipo, taxa, valor, comprovante, dt_criacao, hr_criacao, confirmado, operador, reinvestir) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($usuario, $descricao, $tipo, $taxa_lucro, $valor_lucro, $comprovante, $dt_criacao, $hr_criacao, $confirmado, $_SESSION['UsuarioNome'], $reinvestir));
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

      require('includes/phpmailer/hdw-phpmailer.php');


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

      require('includes/phpmailer/hdw-phpmailer.php');


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
                    window.location.href = "clientes-movimentacao?id=' . $id_usuario . '";
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

include('includes/footer.php');

// SOMA DIAS PARA SAQUE
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
<?php } ?>