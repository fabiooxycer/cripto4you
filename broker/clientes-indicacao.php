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
                        <li>CLIENTES INDICADOS</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo será listado todos os clientes cadastrados na plataforma pela sua indicação</p>
                  <!-- <div class="ml-auto" align="left">
                     <div>
                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalNovoUsuario" title="ADICIONAR USUÁRIO/CLIENTE"><i class="fas fa-user-plus"></i> Adicionar</button>
                     </div>
                  </div><br> -->
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important'>Nome</th>
                              <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                              <th style='text-align: center; vertical-align:middle !important'>Telefone</th>
                              <th style='text-align: center; vertical-align:middle !important'>E-mail</th>
                              <th style='text-align: center; vertical-align:middle !important'>Dt. Cadastro</th>
                              <th style='text-align: center; vertical-align:middle !important'>Situação</th>
                              <th style='text-align: center; vertical-align:middle !important' width="12%">Ação</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           $sql = 'SELECT * FROM tbl_usuarios WHERE id_indicacao == "' . $_SESSION['UsuarioID'] . '" ORDER BY nome ASC';

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
                              if ($row['email']) {
                                 $email = '' . $row['email'] . '';
                              }
                              if ($row['dt_cadastro']) {
                                 $data_cadastro = '' . $row['dt_cadastro'] . '';
                              }
                              if ($row['status'] == 1) {
                                 $status = '<font color="green"> ATIVO </font>';
                              }
                              if ($row['status'] == 2) {
                                 $status = '<font color="red"> INATIVO </font>';
                              }

                              echo "<tr>";
                              echo "<td style='text-align: left; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $cpf . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $telefone . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $email . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . converte($data_cadastro, 2) . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $status . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'>";
                              echo '<form action="clientes" method="POST">';
                              echo '<a class="btn btn-sm btn-outline-info" title="MOVIMENTAÇÕES" href="clientes-indicacao-movimentacao?id=' . $row['id'] . '"><i class="fa fa-list"></i></a>';
                              echo "</form>";
                              echo "</td>";
                           }
                           echo "</tr>";
                           ?>
                        </tbody>
                        <tfoot>
                           <tr>
                           <th style='text-align: center; vertical-align:middle !important'>Nome</th>
                              <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                              <th style='text-align: center; vertical-align:middle !important'>Telefone</th>
                              <th style='text-align: center; vertical-align:middle !important'>E-mail</th>
                              <th style='text-align: center; vertical-align:middle !important'>Dt. Cadastro</th>
                              <th style='text-align: center; vertical-align:middle !important'>Situação</th>
                              <th style='text-align: center; vertical-align:middle !important' width="12%">Ação</th>
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

<?php include('includes/footer.php'); ?>