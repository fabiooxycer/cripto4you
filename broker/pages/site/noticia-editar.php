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
        <form action="produtos-editar?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
          <section class="basic-elements">
            <div class="row">
              <div class="col-sm-6">
                <h2 class="content-header">EDITAR PRODUTO</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title-wrap bar-danger">
                      <h4 class="card-title mb-0">Preencha o produto com todos os detalhes necessários</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="px-3">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-6">
                            <fieldset class="form-group">
                              <label for="basicInput">Produto</label>
                              <input type="text" class="form-control" name="produto" id="produto" value="<?php echo $data['produto']; ?>" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                            </fieldset>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="basicInput">Categoria</label>
                              <select type="text" class="form-control" id="categoria" name="categoria" autocomplete="off" required>
                                <option value="<?php echo $data['categoria']; ?>"><?php echo $data['categoria']; ?></option>
                                <?php
                                $sql = 'SELECT * FROM tbl_categorias ORDER BY categoria ASC';

                                foreach ($pdo->query($sql) as $row_categoria) {
                                ?>
                                  <option value="<?php echo $row_categoria['categoria']; ?>"><?php echo $row_categoria['categoria']; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <fieldset class="form-group">
                              <label for="basicTextarea">Descrição</label>
                              <textarea class="form-control" name="descricao" id="descricao" rows="3" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required><?php echo $data['descricao']; ?></textarea>
                            </fieldset>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="basicInput">Tipo</label>
                              <select type="text" class="form-control" id="tipo" name="tipo" onchange="validaTipo()" autocomplete=" off" required>
                                <option value="">Selecione ...</option>
                                <option value="CAIXA">CAIXA</option>
                                <option value="UNIDADE">UNIDADE</option>
                                <option value="CAIXA-UNIDADE">CAIXA + UNIDADE</option>
                              </select>
                              <font size="1"><strong>Tipo definido:</strong> <?php echo $data['tipo']; ?></font>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="basicInput">Preço Unitário</label>
                              <input type="text" class="form-control" id="preco_unit" name="preco_unit" placeholder="Preço Unitário" value="<?php echo $data['preco_unit']; ?>" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" disabled>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="basicInput">Preço Caixa</label>
                              <input type="text" class="form-control" id="preco_caixa" name="preco_caixa" placeholder="Preço Caixa" value="<?php echo $data['preco_caixa']; ?>" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" disabled>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="basicInput">Promoção?</label>
                              <select type="text" class="form-control" id="promocao" name="promocao" onchange="validaPromocao()" autocomplete="off" required>
                                <option value="">Selecione ...</option>
                                <option value="NÃO">NÃO</option>
                                <option value="PERCENTUAL">PERCENTUAL</option>
                                <option value="VALOR">VALOR</option>
                              </select>
                              <font size="1"><strong>Tipo definido:</strong> <?php echo $data['promocao']; ?></font>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="basicInput">% Promocional</label>
                              <input type="text" class="form-control" id="percentual_promocao" name="percentual_promocao" placeholder="Percentual Promocional" value="<?php echo $data['percentual_promocao']; ?>" autocomplete="off" disabled>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="basicInput">Valor Promocional</label>
                              <input type="text" class="form-control" id="valor_promocao" name="valor_promocao" placeholder="Valor Promocional" value="<?php echo $data['valor_promocao']; ?>" autocomplete="off" disabled>
                            </div>
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
                      <h4 class="card-title mb-0">Imagem do Produto</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="card-block">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-lg-12 col-md-12">
                            <fieldset class="form-group">
                              <input type="file" class="form-control-file" name="img[]" id="img">
                              <p>
                                <font size="1">Enviar a imagem do produto.</font>
                              </p>
                            </fieldset>
                          </div>
                          <figure class="col-xl-12 col-lg-4 col-sm-6 col-12" align="center">
                            <p>
                              <font size="1"><strong>Seu produto está utilizando a seguinte imagem:</strong></font>
                            </p>
                            <img class="img-thumbnail img-fluid" src="../images/produtos/<?php echo $data['img']; ?>" alt="<?php echo $data['produto']; ?>" width="310px" height="310px" />
                          </figure>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div class="form-actions" align="center">
            <button type="submit" class="btn btn-success" name="atualizar">
              <i class="icon-note"></i> Atualizar Produto
            </button>
          </div>
        </form>

        <form action="produtos-editar" method="post">
          <section class="basic-elements">
            <div class="row">
              <div class="col-sm-12">
                <h2 class="content-header">ADICIONAIS AO PRODUTO</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title-wrap bar-danger">
                      <h4 class="card-title mb-0">Insira um adicional de cada vez.</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="px-3">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="basicInput">Valor</label>
                              <input type="hidden" class="form-control" id="id_produto" name="id_produto" value="<?php echo $data['id']; ?>" readonly>
                              <input type="text" class="form-control" id="valor_adicional" name="valor_adicional" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off">
                            </div>
                          </div>
                          <div class="col-md-10">
                            <fieldset class="form-group">
                              <label for="basicInput">Adicional</label>
                              <input type="text" class="form-control" name="adicional" id="adicional" onChange="this.value=this.value.toUpperCase()" autocomplete="off">
                            </fieldset>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div class="form-actions" align="center">
            <button type="submit" class="btn btn-success" name="adicionar_adicional">
              <i class="icon-note"></i> Inserir Adicional
            </button>
          </div>
        </form>

        <!-- Accordion para inserção de adicionais do produto -->
        <div class="row">
          <div class="col-lg-12 col-xl-12">
            <div id="accordionWrap2" class="accordion">
              <div class="card collapse-icon accordion-icon-rotate left">
                <div id="heading21" class="card-header">
                  <a data-toggle="collapse" href data-target="#accordion21" aria-expanded="false" aria-controls="accordion21" class="card-title lead">LISTAR ADICIONAIS DO PRODUTO</a>
                </div>
                <div id="accordion21" data-parent="#accordionWrap2" aria-labelledby="heading21" class="collapse">
                  <div class="card-body">
                    <div class="card-block">
                      <section id="configuration">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <div class="card-body collapse show">
                                <div class="card-block card-dashboard">
                                  <table class="table table-striped zero-configuration">
                                    <thead>
                                      <tr>
                                        <th>Valor</th>
                                        <th>Adicional</th>
                                        <th>-</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                      $sql = 'SELECT * FROM tbl_adicionais ORDER BY id ASC';

                                      foreach ($pdo->query($sql) as $row) {
                                        if ($row['id']) {
                                          $id_adicional = '' . $row['id'] . '';
                                        }
                                        if ($row['valor_adicional']) {
                                          $valor_adicional = '' . $row['valor_adicional'] . '';
                                        }
                                        if ($row['adicional']) {
                                          $adicional = '' . $row['adicional'] . '';
                                        }
                                        echo "<tr>";
                                        echo '<form action="produtos-editar" method="POST">';
                                        echo "<td style='text-align: center; vertical-align:middle !important' width=50><font size='3'>R$ " . $valor_adicional . "</td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important' width=50><font size='3'>" . $adicional . "</td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important' width=70>";
                                        echo '<div align="center"><input type="hidden" name="id_adicional" id="id_adicional" value="' . $id_adicional . '" >';
                                        echo '&nbsp;<button type="submit" class="btn btn-sm btn-danger" title="Excluir" name="excluir_adicional"><i  class="icon-trash"></i> Excluir</button>';
                                        echo "</form>";
                                        echo "</td>";
                                      }
                                      echo "</tr>";
                                      //Banco::desconectar()
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br /><br /><br />

  <!-- CHAMA FOOTER -->
  <?php include("includes/footer.php"); ?>
  <!-- /CHAMA FOOTER -->