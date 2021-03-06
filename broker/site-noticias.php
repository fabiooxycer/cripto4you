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
                        <li>NOTÍCIAS</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo serão listadas todas as noticias exbidas no site e enviadas via canal do Telegram</p>
                  <div class="ml-auto" align="left">
                     <div>
                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalNovaNoticia"><i class="fa fa-plus mr-1 mt-1"></i> Cadastrar</button>
                     </div>
                  </div><br>
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important' width="5%">Imagem</th>
                              <th style='text-align: center; vertical-align:middle !important' width="15%">Data/Hora Publicação</th>
                              <th style='text-align: center; vertical-align:middle !important'>Título</th>
                              <th style='text-align: center; vertical-align:middle !important' width="8%">Ação</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           $sql = "SELECT * FROM tbl_noticias ORDER BY id DESC";

                           foreach ($pdo->query($sql) as $row) {
                              if ($row['imagem']) {
                                 $imagem = '<img src="assets/images/noticias/' . $row['imagem'] . '" width="100%">';
                              }
                              if ($row['dt_postagem']) {
                                 $data_postagem = '' . $row['dt_postagem'] . '';
                                 $timestamp = strtotime($data_postagem);
                                 $dt_postagem = date('d/m/Y', $timestamp);
                              }
                              if ($row['hr_postagem']) {
                                 $hora_postagem = '' . $row['hr_postagem'] . '';
                                 $timestamp2 = strtotime($hora_postagem);
                                 $hr_postagem = date('H:i:s', $timestamp2);
                              }

                              if ($row['titulo']) {
                                 $titulo = '' . $row['titulo'] . '';
                              }

                              echo "<tr>";
                              echo "<td width=150>" . $imagem . "</td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $dt_postagem . " às " . $hr_postagem . "</font></td>";
                              echo "<td style='text-align: left; vertical-align:middle !important'><font size='2'>" . $titulo . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                              echo '<form action="noticias" method="POST">';
                              echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                              echo '<a class="btn btn-sm btn-outline-warning" title="EDITAR" href="noticia-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                              echo '&nbsp;<button type="submit" title="EXCLUIR" class="btn btn-sm btn-outline-danger" name="excluir"><i  class="fa fa-trash"></i></button>';
                              echo "</form>";
                              echo "</td>";
                           }
                           echo "</tr>";
                           ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important' width="5%">Imagem</th>
                              <th style='text-align: center; vertical-align:middle !important' width="15%">Data/Hora Publicação</th>
                              <th style='text-align: center; vertical-align:middle !important'>Título</th>
                              <th style='text-align: center; vertical-align:middle !important' width="8%">Ação</th>
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

<!-- Exibe o Modal para inserção dos Cliente -->
<div class="modal fade" id="modalNovaNoticia" tabindex="-1" role="dialog" aria-labelledby="modalNovaNoticia" aria-hidden="true">
   <div class="modal-dialog modal-xl " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">ADICIONAR NOVA NOTÍCIA</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <form action="noticias" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="basicInput">Título</label>
                           <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título da notícia" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <input type="file" class="form-control-file" id="imagem" name="imagem[]" multiple="multiple" required>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <textarea type="text" class="form-control content" id="descricao" name="descricao" placeholder="Descrição sobre a notícia" rows="8" required></textarea>
                        </div>
                     </div>
                  </div>
                  <strong>
                     <font size="2" color="#2CABE3">Sua imagem será redefinida para:</font>
                  </strong>
                  <font size="2"> 839 x 630 px </font>
                  <br><br>
               </div>
               <div class="modal-footer"></div>
               <div class="form-actions" align="right">
                  <button type="submit" name="adicionar" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> CADASTRAR</button>
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

// Verifica qual botao foi clicado
switch (get_post_action('excluir', 'adicionar')) {

   case 'excluir':

      if (!empty($_POST)) {

         $id = $_POST['id'];

         //Validaçao dos campos:
         $validacao = true;
      }

      //Delete do banco:
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "DELETE FROM tbl_noticias where id = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($id));
      echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Notícia excuída com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "noticias";
              }
            }); }, 1000);</script>';
      break;

   case 'adicionar':

      if (!empty($_POST)) {

         $titulo      = $_POST['titulo'];
         $descricao   = $_POST['descricao'];
         $dt_postagem = date("Y-m-d");
         $hr_postagem = date("H:i:s");;

         //Validaçao dos campos:
         $validacao = true;
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO tbl_noticias (titulo, descricao, dt_postagem, hr_postagem) VALUES(?,?,?,?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($titulo, $descricao, $dt_postagem, $hr_postagem));

      $sql2 = 'SELECT id FROM tbl_noticias ORDER BY id DESC limit 1';
      foreach ($pdo->query($sql2) as $row) {

         $_SESSION['id'] = $row['id'];

         /* INICIA INSERÇÃO DAS IMAGENS NA PASTA */
         $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $imagem = $_FILES['imagem'];

         //aqui eu verifico se o array de fotos é maior que zero e começo a fazer o loop
         if (count($imagem) > 0) {
            for ($q = 0; $q < count($imagem['tmp_name']); $q++) {
               $tipo = $imagem['type'][$q];
               if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                  $tmpname = md5(time() . rand(0, 999)) . '.jpeg';
                  move_uploaded_file($imagem['tmp_name'][$q], 'assets/images/noticias/' . $tmpname);
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

                  $sql = "SELECT * FROM tbl_noticias WHERE id = ?";
                  $q = $pdo->prepare($sql);
                  $q->execute(array($_SESSION['id']));
                  $img_news = $q->fetch(PDO::FETCH_ASSOC);

                  // ENVIA TELEGRAM    
                  $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
                  $dataPhoto = [
                     "chat_id" => "-1001662279487", // ID Canal Notícias
                     'photo' => 'https://broker.cripto4you.net/assets/img/noticias/"' . $img_news['imagem'] . '"',
                     'parse_mode' => 'HTML',
                  ];

                  $dataMessage = [
                     "chat_id" => "-1001662279487",
                     'parse_mode' => 'HTML',
                     'text' => "\n<b>$titulo</b> \n\nConfira em: https://cripto4you.net/ver-noticia?id=" . $_SESSION['id'] . "\n",
                  ];

                  $response  = file_get_contents("https://api.telegram.org/bot$apiToken/sendPhoto?" . http_build_query($dataPhoto));
                  $response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($dataMessage));

                  echo '<script>setTimeout(function () { 
                        swal({
                        title: "Parabéns!",
                        text: "Notícia cadastrada com sucesso!",
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

      break;

   default:
}

include('includes/footer.php');
?>