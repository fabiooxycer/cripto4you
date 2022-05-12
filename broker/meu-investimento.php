<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
   echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
   exit;
} else {
   if (!isset($_SESSION)) session_start();
}

include('includes/header.php');
include('includes/menu.php');
include('includes/topnavbar.php');
include('includes/scripts.php');

$id = $_SESSION['UsuarioID'];
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
                        <li>EXTRATO DO MEU INVESTIMENTO</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo será listado todo histório de movimentação da sua carteira.</p>
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
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important' width="5%">Cód.</th>
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
                           $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" ORDER BY id DESC';

                           foreach ($pdo->query($sql) as $row) {

                              if ($row['id']) {
                                 $id_movimentacao = '' . $row['id'] . '';
                              }

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
                                 $timestamp = strtotime($data_criacao);
                                 $dt_criacao = date('d/m/Y', $timestamp);
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
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $dt_criacao . " às " . $hr_criacao . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $confirmado . "</td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='blue'>R$ " . number_format($valor_bruto, 2, ',', '.') .  "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='red'>" . $taxa .  "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='green'>R$ " . number_format($valor_liquido, 2, ',', '.') . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important' width=80>";

                              if ($row['tipo'] == 3 and $row['reinvestir'] == 2) {
                                 echo '<form action="meu-investimento" method="POST">';
                                 echo '<input type="hidden" name="id_user" id="id_user" value="' . $_SESSION['UsuarioID'] . '" >';
                                 echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                                 echo '<input type="hidden" name="valor" id="valor" value="' . $valor . '" >';
                                 echo '<button type="submit" title="REINVESTIR LUCRO" class="btn btn-sm btn-outline-info" name="reinvestir">REINVESTIR</button><br>';
                                 echo '<br><button type="submit" title="SACAR LUCRO" class="btn btn-sm btn-outline-danger" name="sacarLucro">SACAR</button>';
                                 echo "</form>";
                              }
                              echo "</td>";
                           }
                           echo "</tr>";
                           ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important' width="5%">Cód.</th>
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
            <h4 class="modal-title"><i class="fas fa-minus-circle"></i> Solicitar Retirada de Valor</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <p class="text-justify">Prezados investidores,
               <br><br>
               Informamos que a função saque está desativa devido a queda repentina do mercado.
               Operamos na data de ontem (11/05/2022), onde tivemos uma baixa de 34%.
               <br><br>
               Precisamos desta recuperação para retornar a inserção de lucros em nossa plataforma.
               <br><br>
               Vamos aguardar os próximos passos do mercado, focando sempre na recuperação do capital e lucro.
               <br><br>
               Qualquer dúvida, estamos a disposição no WhatsApp +55 (41) 99282-3979.
            </p>
            <!-- <form action="meu-investimento" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="basicInput">Informe o Valor da Retirada:</label>
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
                  <button type="submit" name="saque" class="btn btn-sm btn-outline-danger"><i class="fa fa-check"></i> Solicitar Retirada</button>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
               </div>
            </form> -->
            <div class="form-actions" align="right">
               <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Exibe o Modal para solicitação de depósito -->
<div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="modalDeposito" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-plus-circle"></i> Envio de Aporte</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <form action="meu-investimento" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="basicInput">Informar o Valor do Aporte:</label>
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
                  <button type="submit" name="deposito" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Enviar Aporte</button>
                  <button type="button" class="btn btn-sm outline btn-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Exibe o Modal para aceite de contrato -->
<div class="modal fade" id="modalContrato" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" ole="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Aceitar Contrato de Investimento</h5>
         </div>
         <p class="text-justify">Prezados investidores,
            <br><br>
            Informamos que a função saque está desativa devido a queda repentina do mercado.
            Operamos na data de ontem (11/05/2022), onde tivemos uma baixa de 34%.
            <br><br>
            Precisamos desta recuperação para retornar a inserção de lucros em nossa plataforma.
            <br><br>
            Vamos aguardar os próximos passos do mercado, focando sempre na recuperação do capital e lucro.
            <br><br>
            Qualquer dúvida, estamos a disposição no WhatsApp +55 (41) 99282-3979.
         </p>
         <!-- <form action="dashboard" method="post">
            <div class="modal-body">
               <div style="width: 100%; height:400px; overflow-y:scroll;">
                  <br>
                  <?php include('../../includes/contrato.php'); ?>
                  <br>
                  <br>
               </div>
            </div>
            <div class="modal-footer text-center">
               <button type="submit" name="contrato" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Li e aceito os termos deste contrato</button>
            </div>
         </form> -->
         <div class="form-actions" align="right">
            <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
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

switch (get_post_action('saque', 'deposito', 'reinvestir', 'sacarLucro')) {

   case 'saque':

      if (!empty($_POST)) {

         $usuario          = $_SESSION['UsuarioID'];
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

         $dt_criacao       = date("Y-m-d");
         $hr_criacao       = date("H:i:s");
         $timestamp        = strtotime($dt_criacao);
         $timestamp2       = strtotime($hr_criacao);
         $dt_saque         = date('d/m/Y', $timestamp);
         $hr_saque         = date('H:i:s', $timestamp2);
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

         $usuario          = $_SESSION['UsuarioID'];
         $descricao        = 'Depósito aporte';
         $tipo             = '1';
         $valor_deposito   = str_replace(',', '.', str_replace('.', '', $_POST['aporte']));
         $valor_solicitado = number_format($valor_deposito, 2, ',', '.');
         $comprovante      = '-';
         $confirmado       = '2';

         $dt_criacao       = date("Y-m-d");
         $hr_criacao       = date("H:i:s");
         $timestamp        = strtotime($dt_criacao);
         $timestamp2       = strtotime($hr_criacao);
         $dt_deposito      = date('d/m/Y', $timestamp);
         $hr_deposito      = date('H:i:s', $timestamp2);
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

         $id_usuario   = $_POST['id_user'];
         $id_transacao = $_POST['id'];
         $reinvest     = '1';
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

include('includes/footer.php');

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