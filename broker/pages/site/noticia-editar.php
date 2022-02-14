<?php
if (!isset($_SESSION)) session_start();

$nivel_necessario = 99;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
  echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
  exit;
}
?>

<?php
include("../../includes/header.php");

$id = null;
if (!empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

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
switch (get_post_action('atualizar')) {

  case 'atualizar':

    if (!empty($_POST)) {

      $titulo             = $_POST['produto'];
      $descricao          = $_POST['descricao'];

      $validacao = true;

      if ($validacao) {

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tbl_noticias set titulo = ?, descricao = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($titulo, $descricao, $id));

        $img = $_FILES['imagem'];

        if ($img != '' || $img != $_FILES['imagem']) {

          $sql2 = 'SELECT * FROM tbl_produtos WHERE id="' . $id . '"';
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

                  move_uploaded_file($img['tmp_name'][$q], '../../assets/img/noticias/' . $tmpname);

                  list($larg_orig, $alt_orig) = getimagesize('../../assets/img/noticias/' . $tmpname);
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
                    $original = imagecreatefromjpeg('../../assets/img/noticias/' . $tmpname);
                  } elseif ($tipo == 'image/png') {
                    $original = imagecreatefrompng('../../assets/img/noticias/' . $tmpname);
                  }
                  imagecopyresampled($img, $original, 0, 0, 0, 0, $largura, $altura, $larg_orig, $alt_orig);

                  imagejpeg($img, '../../assets/img/noticias/' . $tmpname, 80);

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
          //echo "<script>alert('Cadastro realizado com sucesso!');location.href='produtos';</script>";
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

$pdo = BancoCadastros::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_noticias where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-panel">
  <div class="main-content">
    <div class="content-wrapper">
      <div class="container-fluid">

        <section class="basic-elements">
          <div class="row">
            <div class="col-sm-6">
              <h2 class="content-header">EDITAR NOTÍCIA</h2>
            </div>
          </div>
          <form action="noticia-editar?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title-wrap bar-danger">
                      <h4 class="card-title mb-0">Preencha a notícia se atentando a gramática.</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="px-3">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-12">
                            <fieldset class="form-group">
                              <label for="basicInput">Título</label>
                              <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $data['titulo']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                            </fieldset>
                          </div>
                          <div class="col-md-12">
                            <fieldset class="form-group">
                              <label for="basicTextarea">Descrição</label>
                              <textarea class="form-control" name="descricao" id="descricao" rows="6" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required><?php echo $data['descricao']; ?></textarea>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title-wrap bar-danger">
                      <h4 class="card-title mb-0">Imagem da Notícia</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="card-block">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-lg-12 col-md-12">
                            <fieldset class="form-group">
                              <input type="file" class="form-control-file" name="imagem[]" id="imagem">
                              <p>
                                <font size="1">Enviar a imagem da notícia.</font>
                              </p>
                            </fieldset>
                          </div>
                          <figure class="col-xl-12 col-lg-4 col-sm-6 col-12" align="center">
                            <p>
                              <font size="1"><strong>Sua notícia está utilizando a seguinte imagem:</strong></font>
                            </p>
                            <img class="img-thumbnail img-fluid" src="assets/img/noticias/<?php echo $data['imagem']; ?>" alt="<?php echo $data['imagem']; ?>" width="310px" />
                          </figure>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions" align="center">
              <button type="submit" class="btn btn-success" name="atualizar">
                <i class="icon-note"></i> Atualizar Produto
              </button>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>

  <?php include("../../includes/footer.php"); ?>