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

         $titulo             = $_POST['titulo'];
         $descricao          = $_POST['descricao'];

         $validacao = true;

         if ($validacao) {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tbl_noticias set titulo = ?, descricao = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($titulo, $descricao, $id));

            $img = $_FILES['imagem'];

            if ($img != '' || $img != $_FILES['imagem']) {

               $sql2 = 'SELECT * FROM tbl_noticia WHERE id="' . $id . '"';
               foreach ($pdo->query($sql2) as $row) {

                  $_SESSION['id'] = $row['id'];

                  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $img = $_FILES['img'];

                  if (count($img) > 0) {
                     for ($q = 0; $q < count($img['tmp_name']); $q++) {
                        $tipo = $img['type'][$q];
                        if (in_array($tipo, array('image/jpeg', 'image/png'))) {

                           $tmpname = md5(time() . rand(0, 999)) . '.jpeg';

                           move_uploaded_file($img['tmp_name'][$q], 'assets/images/noticias/' . $tmpname);

                           list($larg_orig, $alt_orig) = getimagesize('assets/images/noticias/' . $tmpname);
                           $tamanho = $larg_orig / $alt_orig;

                           $largura = 839;
                           $altura = 630;

                           if ($largura / $altura > $tamanho) {
                              $largura = $altura * $tamanho;
                           } else {
                              $altura = $largura / $tamanho;
                           }
                           $img = imagecreatetruecolor($largura, $altura);
                           if ($tipo == 'image/jpeg') {
                              $original = imagecreatefromjpeg('assets/images/noticias/' . $tmpname);
                           } elseif ($tipo == 'image/png') {
                              $original = imagecreatefrompng('assets/images/noticias/' . $tmpname);
                           }
                           imagecopyresampled($img, $original, 0, 0, 0, 0, $largura, $altura, $larg_orig, $alt_orig);

                           imagejpeg($img, 'assets/images/noticias/' . $tmpname, 80);

                           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           $sql3 = "UPDATE tbl_noticias set imagem = ? WHERE id = ?";
                           $q = $pdo->prepare($sql3);
                           $q->execute(array($tmpname, $_SESSION['id']));
                           echo '<script>setTimeout(function () { 
                    swal({
                      title: "Parabéns!",
                      text: "Notícia atualizada com sucesso!",
                      type: "success",
                      confirmButtonText: "OK"
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        window.location.href = "noticias";
                      }
                    }); }, 1000);</script>';
                        }
                     }
                  }
               }
            }
            if ($img == $_FILES['imagem']) {
               echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Notícia atualizada com sucesso!",
              type: "success",
              confirmButtonText: "OK"
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "noticias";
              }
            }); }, 1000);</script>';
            }
         }
      }
      break;

   default:
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_noticias where id = ?";
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
                        <li>EDITAR NOTÍCIA</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Preencha a notícia corretamente, atentando-se a ortografia</p>
                  <form action="noticia-editar?id=<?php echo $id ?>" method="post">
                     <div class="px-3">
                        <div class="form-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">
                                       <font size="1">Título</font>
                                    </label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['titulo']; ?>" autocomplete="off" required>
                                 </div>
                              </div>
                              |<div class="col-md-12">
                                 <div class="form-group">
                                    <label for="basicInput">
                                       <font size="1">Descrição</font>
                                    </label>
                                    <textarea type="text" class="form-control content" id="descricao" name="descricao" rows="10" autocomplete="off" required><?php echo $data['descricao']; ?></textarea>
                                 </div>
                              </div>
                           </div>
                           <br />
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="basicInput">
                                       <font size="1">Imagem da Notícia</font>
                                    </label>
                                    <input type="file" class="form-control-file" id="imagem" name="imagem[]" value="<?php echo $data['imagem']; ?>" autocomplete="off">
                                    <p>
                                       <font size="1">Enviar a imagem da notícia.</font>
                                    </p>
                                 </div>
                              </div>
                              <figure class="col-xl-12 col-lg-4 col-sm-6 col-12" align="center">
                                 <p>
                                    <font size="1"><strong>Sua notícia está utilizando a seguinte imagem:</strong></font>
                                 </p>
                                 <img class="img-thumbnail img-fluid" src="assets/img/noticias/<?php echo $data['imagem']; ?>" alt="<?php echo $data['imagem']; ?>" width="50%" />
                              </figure>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <br /><br />
                     <div class="form-actions" align="center">
                        <button type="button" class="btn btn-sm btn-outline-dark" onClick="history.go(-1)">
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