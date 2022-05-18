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
                        <li>CONFIGURAÇÕES GERAIS - <font color="#DD7F12">SISTEMA</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Ajuste o sistema conforme a necessidade</p>
                  <form action="geral" method="post">
                     <div class="px-3">
                        <div class="form-body">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">SAQUE</label>
                                    <select type="text" class="form-control" id="saque" name="saque" autocomplete="off" required>
                                       <option value="<?php echo $configuracoes['saque']; ?>"><?php if ($configuracoes['saque'] == '1') {
                                                                                                   echo 'HABILITADO';
                                                                                                }
                                                                                                if ($configuracoes['saque'] == '2') {
                                                                                                   echo 'DESABILITADO';
                                                                                                } ?></option>
                                       <option value="">Selecione...</option>
                                       <option value="1">Habilitado</option>
                                       <option value="2">Desabilitado</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">DEPÓSITO</label>
                                    <select type="text" class="form-control" id="deposito" name="deposito" autocomplete="off" required>
                                       <option value="<?php echo $configuracoes['deposito']; ?>"><?php if ($configuracoes['deposito'] == '1') {
                                                                                                      echo 'HABILITADO';
                                                                                                   }
                                                                                                   if ($configuracoes['deposito'] == '2') {
                                                                                                      echo 'DESABILITADO';
                                                                                                   } ?></option>
                                       <option value="">Selecione...</option>
                                       <option value="1">Habilitado</option>
                                       <option value="2">Desabilitado</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">QUADRO DE AVISOS</label>
                                    <select type="text" class="form-control" id="avisos" name="avisos" autocomplete="off" required>
                                       <option value="<?php echo $configuracoes['avisos']; ?>"><?php if ($configuracoes['avisos'] == '1') {
                                                                                                   echo 'HABILITADO';
                                                                                                }
                                                                                                if ($configuracoes['avisos'] == '2') {
                                                                                                   echo 'DESABILITADO';
                                                                                                } ?></option>
                                       <option value="">Selecione...</option>
                                       <option value="1">Habilitado</option>
                                       <option value="2">Desabilitado</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">DESCRIÇÃO DO AVISO</label>
                                    <textarea type="text" class="form-control content" id="descricao_avisos" name="descricao_avisos" rows="5" autocomplete="off" required><?php echo $configuracoes['descricao_avisos']; ?></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <br /><br />
                     <div class="form-actions" align="center">
                        <button type="button" class="btn btn-sm btn-outline-dark" onClick="history.go(-1)">
                           <i class="fa fa-times-circle"></i> VOLTAR
                        </button>
                        <button type="submit" class="btn btn-sm btn-outline-primary" name="atualizar">
                           <i class="fa fa-check"></i> ATUALIZAR
                        </button>
                     </div>
                  </form>
               </div>
            </div>
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

// Verifica qual botao foi clicado
switch (get_post_action('atualizar')) {

   case 'atualizar':

      if (!empty($_POST)) {

         $saque            = $_POST['saque'];
         $deposito         = $_POST['deposito'];
         $avisos           = $_POST['avisos'];
         $descricao_avisos = $_POST['descricao_avisos'];

         //Validaçao dos campos:
         $validacao = true;
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE tbl_configuracoes set saque = ?, deposito = ?, avisos = ?, descricao_avisos = ? WHERE id = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($saque, $deposito, $avisos, $descricao_avisos, $id_selects));
      echo '<script>setTimeout(function () { 
            swal({
            title: "Parabéns!",
            text: "Configurações atualizadas com sucesso!",
            type: "success",
            confirmButtonText: "OK"
            },
            function(isConfirm){
            if (isConfirm) {
                window.location.href = "geral";
            }
            }); }, 1000);</script>';
      break;

   default:
}

include('includes/footer.php');
?>