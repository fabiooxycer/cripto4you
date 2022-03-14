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

function get_post_action($name)
{
   $params = func_get_args();

   foreach ($params as $name) {
      if (isset($_POST[$name])) {
         return $name;
      }
   }
}


switch (get_post_action('atualizar')) {

   case 'atualizar':

      if (!empty($_POST)) {

         $nome          = $_POST['nome'];
         $rg            = $_POST['rg'];
         $cpf           = $_POST['cpf'];
         $telefone      = $_POST['telefone'];
         $email         = $_POST['email'];
         $cep           = $_POST['cep'];
         $endereco      = $_POST['endereco'];
         $numero        = $_POST['numero'];
         $complemento   = $_POST['complemento'];
         $bairro        = $_POST['bairro'];
         $cidade        = $_POST['cidade'];
         $estado        = $_POST['estado'];
         $tipo_pix      = $_POST['tipo_pix'];
         $chave         = $_POST['chave'];
         $tipo_contrato = $_POST['tipo_contrato'];
         $dt_saque      = $_POST['dt_saque'];
         $status        = '1';
         $nivel         = $_POST['nivel'];

         if ($complemento == '') {
            $complemento = '-';
         }
         if ($chave == '') {
            $chave = '-';
         }
         if ($dt_saque == '') {
            $dt_saque = '0000-00-00';
         }
         if ($dt_saque == '') {
            $dt_saque = '0000-00-00';
         }
         if ($tipo_contrato == '1') {
            $percentual = '1';
         }
         if ($tipo_contrato == '2') {
            $percentual = '1';
         }
         if ($tipo_contrato == '3') {
            $percentual = '7';
         }
         if ($tipo_contrato == '4') {
            $percentual = '15';
         }
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE tbl_usuarios set nome = ?, rg = ?, cpf = ?, telefone = ?, email = ?, cep = ?, endereco = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, tipo_pix = ?, chave = ?, tipo_contrato = ?, percentual = ?, dt_saque = ?, nivel = ? WHERE id = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($nome, $rg, $cpf, $telefone, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $tipo_pix, $chave, $tipo_contrato, $percentual, $dt_saque, $nivel, $id));
      echo '<script>setTimeout(function () { 
            swal({
            title: "Parabéns!",
            text: "Cliente/Usuário atualizado com sucesso!",
            type: "success",
            confirmButtonText: "OK"
            },
            function(isConfirm){
            if (isConfirm) {
                window.location.href = "clientes";
            }
            }); }, 1000);</script>';
      break;

   default:
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
                        <li>EDITAR DADOS DO(a) CLIENTE - <?php echo $_SESSION['UsuarioNome']; ?></li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Preencha os dados abaixo corretamente</p>
                  <form action="clientes-editar?id=<?php echo $id ?>" method="post">
                     <div class="px-3">
                        <div class="form-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $data['nome']; ?>" onChange=" this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg" value="<?php echo $data['rg']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $data['cpf']; ?>" onkeyup="cpfCheck(this)" maxlength="18" onkeydown="javascript: fMasc( this, mCPF );" autocomplete="off" required><span id="cpfResponse"></span></p>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Telefone</label>
                                    <input type="text" class="form-control phone" id="telefone" name="telefone" value="<?php echo $data['telefone']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-9">
                                 <div class="form-group">
                                    <label for="basicInput">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $data['cep']; ?>" onchange="pesquisacep(this.value);" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-9">
                                 <div class="form-group">
                                    <label for="basicInput">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $data['endereco']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $data['numero']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $data['complemento']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $data['bairro']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $data['cidade']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" value="<?php echo $data['estado']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">PIX</label>
                                    <select type="text" class="form-control" id="tipo_pix" name="tipo_pix" autocomplete="off" onchange="verifica(this.value)" required>
                                       <?php if ($data['tipo_pix'] != 'Não Possuo') { ?>
                                          <option value="<?php echo $data['tipo_pix']; ?>"><?php echo $data['tipo_pix']; ?></option>
                                       <?php } else { ?>
                                          <option value="">Selecione...</option>
                                          <option value="Chave Aleatória">Chave Aleatória</option>
                                          <option value="E-mail">E-mail</option>
                                          <option value="CNPJ">CNPJ</option>
                                          <option value="CPF">CPF</option>
                                          <option value="Telefone">Telefone</option>
                                          <option value="Não Possuo">Não Possuo</option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="basicInput">Chave PIX</label>
                                    <input type="text" class="form-control" id="chave" name="chave" value="<?php echo $data['chave']; ?>" autocomplete="off">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Tipo de Contrato</label>
                                    <select type="text" class="form-control" id="tipo_contrato" name="tipo_contrato" autocomplete="off" required>
                                       <option value="<?php echo $data['tipo_contrato']; ?>"><?php if ($data['tipo_contrato'] == '1') {
                                                                                                echo 'DIÁRIO';
                                                                                             }
                                                                                             if ($data['tipo_contrato'] == '2') {
                                                                                                echo 'MENSAL DIÁRIO';
                                                                                             }
                                                                                             if ($data['tipo_contrato'] == '3') {
                                                                                                echo 'QUINZENAL';
                                                                                             }
                                                                                             if ($data['tipo_contrato'] == '4') {
                                                                                                echo 'MENSAL';
                                                                                             } ?></option>
                                       <option value="">Selecione...</option>
                                       <option value="1">Diário</option>
                                       <option value="2">Mensal Diário</option>
                                       <option value="3">Quinzenal</option>
                                       <option value="4">Mensal</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Data para Saque:</label>
                                    <input type="date" class="form-control" id="dt_saque" name="dt_saque" value="<?php echo $data['dt_saque']; ?>" autocomplete="off">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Nível Acesso</label>
                                    <select type="text" class="form-control" id="nivel" name="nivel" <?php echo $data['nivel']; ?> autocomplete="off" required>
                                       <option value="<?php echo $data['nivel']; ?>">Selecionado como <?php if ($data['nivel'] == '1') {
                                                                                                         echo 'Cliente';
                                                                                                      }
                                                                                                      if ($data['nivel'] == '99') {
                                                                                                         echo 'Operador';
                                                                                                      }
                                                                                                      if ($data['nivel'] == '100') {
                                                                                                         echo 'Administrador';
                                                                                                      } ?></option>
                                       <option value="1">Cliente</option>
                                       <option value="99">Operador</option>
                                       <option value="100">Administrador</option>
                                    </select>
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

<?php include('includes/footer.php'); ?>