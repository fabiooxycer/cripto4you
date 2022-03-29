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
                     <li>MOVIMENTAÇÃO DE <font color="#DD7F12"><?php echo $data['nome']; ?></font></li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo serão listadas, todas as movimentações do cliente indicado selecionado</p>
                  <div class="ml-auto" align="left">
                     <div>
                        <a type="button" class="btn btn-sm btn-outline-dark" href="clientes-indicacao" title="VOLTAR"><i class="fas fa-undo"></i> Voltar</a>
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
                              <th style='text-align: center; vertical-align:middle !important'>Com. Indicação</th>
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
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='red'>" . $taxa .  "</font></td>";
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
                              <th style='text-align: center; vertical-align:middle !important'>Com. Indicação</th>
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

<?php
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