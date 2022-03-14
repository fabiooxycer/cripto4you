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

$id = '1';
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

         $whatsapp    = $_POST['whatsapp'];
         $telefone    = $_POST['telefone'];
         $email       = $_POST['email'];
         $titulo      = $_POST['titulo'];
         $dominio     = $_POST['dominio'];
         $keywords    = $_POST['keywords'];
         $descricao   = $_POST['descricao'];
         $analytics   = $_POST['analytics'];
         $tag_manager = $_POST['tag_manager'];
         $facebook    = $_POST['facebook'];
         $instagram   = $_POST['instagram'];
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql1 = "UPDATE tbl_contato set whatsapp = ?, telefone = ?, email = ? WHERE id = ?";
      $q = $pdo->prepare($sql1);
      $q->execute(array($whatsapp, $telefone, $email, $id));

      $sql2 = "UPDATE tbl_seo set titulo = ?, dominio = ?, keywords = ?, descricao = ?, analytics = ?, tag_manager = ?, facebook = ?, instagram = ? WHERE id = ?";
      $q = $pdo->prepare($sql2);
      $q->execute(array($titulo, $dominio, $keywords, $descricao, $analytics, $tag_manager, $facebook, $instagram, $id));
      echo '<script>setTimeout(function () { 
            swal({
            title: "Parabéns!",
            text: "Contato & SEO atualizados com sucesso!",
            type: "success",
            confirmButtonText: "OK"
            },
            function(isConfirm){
            if (isConfirm) {
                window.location.href = "seo";
            }
            }); }, 1000);</script>';
      break;

   default:
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_contato where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$contato = $q->fetch(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM tbl_seo where id = ?";
$q = $pdo->prepare($sql1);
$q->execute(array($id));
$seo = $q->fetch(PDO::FETCH_ASSOC);
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
                        <li>EDITAR SEO</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <form action="seo?id=<?php echo $id ?>" method="post">
                     <div class="px-3">
                        <div class="form-body">
                           <h6 class="m-0 font-weight-bold text-primary">DADOS DE CONTATO DO SITE</h6><br>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $contato['whatsapp']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">Telefone</label>
                                    <input type="text" class="form-control phone" id="telefone" name="telefone" value="<?php echo $contato['telefone']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="basicInput">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $contato['email']; ?>" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                                 </div>
                              </div>
                           </div>
                           <hr><br>
                           <h6 class="m-0 font-weight-bold text-primary">DADOS DE SEO DO SITE</h6><br>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="basicInput">Título do Site</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $seo['titulo']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="basicInput">Domínio</label>
                                    <input type="text" class="form-control" id="dominio" name="dominio" value="<?php echo $seo['dominio']; ?>" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">Keywords</label>
                                    <textarea type="text" class="form-control" id="keywords" name="keywords" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required><?php echo $seo['keywords']; ?></textarea>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">Descrição</label>
                                    <textarea type="text" class="form-control" id="descricao" name="descricao" autocomplete="off" required><?php echo $seo['descricao']; ?></textarea>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Google Analytics</label>
                                    <input type="text" class="form-control" id="analytics" name="analytics" value="<?php echo $seo['analytics']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Google Tag Manager</label>
                                    <input type="text" class="form-control" id="tag_manager" name="tag_manager" value="<?php echo $seo['tag_manager']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $seo['facebook']; ?>" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="basicInput">Instagram</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $seo['instagram']; ?>" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <br /><br />
                     <div class="form-actions" align="center">
                        <button type="button" class="btn btn-sm btn-outline-primary" onClick="history.go(-1)">
                           <i class="fa fa-times-circle"></i> VOLTAR
                        </button>
                        <button type="submit" class="btn btn-sm btn-outline-success" name="atualizar">
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