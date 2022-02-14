<?php
// ----------------------------------------------------------------------
// Developer by: CREEATOR SOFTWARE DESIGN
// Site: https://www.creeator.com.br | Email: contato@creeator.com.br
// Phone and WhatsApp: +55 41 9 9282-3979
// Developer: Fábio Vieira
// Email: fabio.vieira@creeator.com.br
// ----------------------------------------------------------------------

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = 1;

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
  // Redireciona o visitante de volta pro login
  echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
  exit;
}
?>

<?php
include("includes/header.php");

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
switch (get_post_action('atualizar', 'adicionar_adicional', 'excluir_adicional')) {



  case 'atualizar':

    if (!empty($_POST)) {

      // Dados sobre o produto
      $produto             = $_POST['produto'];
      $descricao           = $_POST['descricao'];
      $categoria           = $_POST['categoria'];
      $tipo                = $_POST['tipo'];
      $preco_unit          = $_POST['preco_unit'];
      $preco_caixa         = $_POST['preco_caixa'];
      $promocao            = $_POST['promocao'];
      $percentual_promocao = $_POST['percentual_promocao'];
      $valor_promocao      = $_POST['valor_promocao'];

      if ($preco_unit == '') {
        $preco_unit = '';
      }
      if ($preco_caixa == '') {
        $preco_caixa = '';
      }
      if ($percentual_promocao == '') {
        $percentual_promocao = '';
      }
      if ($valor_promocao == '') {
        $valor_promocao = '';
      }

      //Validaçao dos campos:
      $validacao = true;

      // update data
      if ($validacao) {

        /* ATUALIZA INFORMAÇÕES NO BANCO DE DADOS */
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tbl_produtos set produto = ?, descricao = ?, categoria = ?, tipo = ?, preco_unit = ?, preco_caixa = ?, promocao = ?, percentual_promocao = ?, valor_promocao = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($produto, $descricao, $categoria, $tipo, $preco_unit, $preco_caixa, $promocao, $percentual_promocao, $valor_promocao, $id));

        $img = $_FILES['img'];

        /* Verifica se a logo foi aterada na loja */
        if ($img != '' || $img != $_FILES['img']) {

          $sql2 = 'SELECT * FROM tbl_produtos WHERE id="' . $id . '"';
          foreach ($pdo->query($sql2) as $row) {

            $_SESSION['id'] = $row['id'];

            /* INICIA INSERÇÃO DAS IMAGENS NA PASTA */
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $img = $_FILES['img'];

            //aqui eu verifico se o array de fotos é maior que zero e começo a fazer o loop
            if (count($img) > 0) {
              for ($q = 0; $q < count($img['tmp_name']); $q++) {
                $tipo = $img['type'][$q];
                if (in_array($tipo, array('image/jpeg', 'image/png'))) {

                  //nome gerado para a imagem a cada loop
                  $tmpname = md5(time() . rand(0, 999)) . '.jpeg';

                  //aqui a imagem ja é movida (upload) para a pasta (assets/img/anuncios/) com seu novo name ($tmpname)
                  move_uploaded_file($img['tmp_name'][$q], '../images/produtos/' . $tmpname);

                  //daqui pra baixo é um brinde kkk, apenas para criarmos uma nova imagem com largura, altura desejados
                  list($larg_orig, $alt_orig) = getimagesize('../images/produtos/' . $tmpname);
                  $tamanho = $larg_orig / $alt_orig;

                  $largura = 350;
                  $altura = 350;

                  if ($largura / $altura > $tamanho) {
                    $largura = $altura * $tamanho;
                  } else {
                    $altura = $largura / $tamanho;
                  }
                  $img = imagecreatetruecolor($largura, $altura);
                  if ($tipo == 'image/jpeg') {
                    $original = imagecreatefromjpeg('../images/produtos/' . $tmpname);
                  } elseif ($tipo == 'image/png') {
                    $original = imagecreatefrompng('../images/produtos/' . $tmpname);
                  }
                  imagecopyresampled($img, $original, 0, 0, 0, 0, $largura, $altura, $larg_orig, $alt_orig);

                  imagejpeg($img, '../images/produtos/' . $tmpname, 80);

                  // aqui ja faço a inserção de cada novo name da imagem no banco de dados
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sql3 = "UPDATE tbl_produtos set img = ? WHERE id = ?";
                  $q = $pdo->prepare($sql3);
                  $q->execute(array($tmpname, $_SESSION['id']));
                  //echo "<script>alert('Cadastro realizado com sucesso!');location.href='produtos';</script>";
                  echo '<script>setTimeout(function () { 
                    swal({
                      title: "Parabéns!",
                      text: "Produto atualizado com sucesso!",
                      type: "success",
                      confirmButtonText: "OK"
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        window.location.href = "produtos";
                      }
                    }); }, 1000);</script>';
                }
              }
            }
          }
        }
        if ($img == $_FILES['img']) {
          //echo "<script>alert('Cadastro realizado com sucesso!');location.href='produtos';</script>";
          echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Produto atualizado com sucesso!",
              type: "success",
              confirmButtonText: "OK"
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "produtos";
              }
            }); }, 1000);</script>';
        }
      }
    }
    break;


  case 'adicionar_adicional':

    if (!empty($_POST)) {

      // Dados do adicional
      $id_produto      = $_POST['id_produto'];
      $valor_adicional = $_POST['valor_adicional'];
      $adicional       = $_POST['adicional'];

      //Validaçao dos campos:
      $validacao = true;

      //Insere adicional no banco:
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql_adicional = "INSERT INTO tbl_adicionais (id_produto, valor_adicional, adicional) VALUES (?,?,?)";
      $q = $pdo->prepare($sql_adicional);
      $q->execute(array($id_produto, $valor_adicional, $adicional));
      //echo "<script>alert('Adicional inserido com sucesso!');location.href='produtos';</script>";
      echo '<script>setTimeout(function () { 
        swal({
          title: "Parabéns!",
          text: "Adicional inserido com sucesso!",
          type: "success",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "produtos";
          }
        }); }, 1000);</script>';
      Banco::desconectar();
    }
    break;

  case 'excluir_adicional':

    if (!empty($_POST)) {

      $id_adicional = $_POST['id_adicional'];

      //Validaçao dos campos:
      $validacao = true;

      //Delete do banco:
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "DELETE FROM tbl_adicionais where id = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($id_adicional));
      //echo "<script>alert('Exclusão realizada com sucesso!');location.href='produtos';</script>";
      echo '<script>setTimeout(function () { 
        swal({
          title: "Parabéns!",
          text: "Adicional excluído com sucesso!",
          type: "success",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "produtos";
          }
        }); }, 1000);</script>';
      Banco::desconectar();
    }
    break;

  default:
}

$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_produtos where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
?>

<!-- Máscara para Moeda -->
<script language="javascript">
  function moeda(a, e, r, t) {
    let n = "",
      h = j = 0,
      u = tamanho2 = 0,
      l = ajd2 = "",
      o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
      return !0;
    if (n = String.fromCharCode(o),
      -1 == "0123456789".indexOf(n))
      return !1;
    for (u = a.value.length,
      h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
    ;
    for (l = ""; h < u; h++)
      -
      1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
      0 == (u = l.length) && (a.value = ""),
      1 == u && (a.value = "0" + r + "0" + l),
      2 == u && (a.value = "0" + r + l),
      u > 2) {
      for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
        3 == j && (ajd2 += e,
          j = 0),
        ajd2 += l.charAt(h),
        j++;
      for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
        a.value += ajd2.charAt(h);
      a.value += r + l.substr(u - 2, u)
    }
    return !1
  }
</script>

<!-- Define percentual para promoções -->
<script>
  $('#percentual_promocao').mask('P', {
    translation: {
      'P': {
        pattern: /[\d\.,]/,
        recursive: true
      }
    },
    onKeyPress: function(val, e, field, options) {
      var old_value = $(field).data('oldValue') || '';

      val = val.trim();
      val = val.replace(',', '.');
      val = val.length > 0 ? val : '0';

      // Transformando múltiplos pontos em um único ponto
      val = val.replace(/[\.]+/, '.');

      // Verificando se o valor contém mais de uma ocorrência de ponto
      var dot_occurrences = (val.match(/\./g) || []).length > 1;

      // Verificando se o valor está de acordo com a sintaxe do float
      var is_float = /[-+]?[\d]*\.?[\d]+/.test(val);

      if (dot_occurrences || !is_float) {
        val = old_value;
      }

      // Força o valor a ficar no intervalo de 0 à 100
      val = parseFloat(val) >= 100 ? '100' : val;
      val = parseFloat(val) < 0 ? '0' : val;

      $(field)
        .val(val)
        .data('oldValue', val);
    }
  });
</script>

<!-- Habilita ou desabilita Inputs e Selects -->
<script>
  function validaTipo() {
    var optionSelect = document.getElementById("tipo").value;

    if (optionSelect == "CAIXA") {
      document.getElementById("preco_caixa").disabled = false;
      document.getElementById("preco_unit").disabled = true;
    } else {
      if (optionSelect == "UNIDADE") {
        document.getElementById("preco_unit").disabled = false;
        document.getElementById("preco_caixa").disabled = true;
      }
      if (optionSelect == "CAIXA-UNIDADE") {
        document.getElementById("preco_caixa").disabled = false;
        document.getElementById("preco_unit").disabled = false;
      }
      if (optionSelect == "") {
        document.getElementById("preco_caixa").disabled = true;
        document.getElementById("preco_unit").disabled = true;
      }
    }
  }
</script>
<script>
  function validaPromocao() {
    var optionSelect = document.getElementById("promocao").value;

    if (optionSelect == "PERCENTUAL") {
      document.getElementById("percentual_promocao").disabled = false;
      document.getElementById("valor_promocao").disabled = true;
    } else {
      if (optionSelect == "VALOR") {
        document.getElementById("valor_promocao").disabled = false;
        document.getElementById("percentual_promocao").disabled = true;
      }
      if (optionSelect == "NÃO") {
        document.getElementById("valor_promocao").disabled = true;
        document.getElementById("percentual_promocao").disabled = true;
      }
      if (optionSelect == "") {
        document.getElementById("valor_promocao").disabled = true;
        document.getElementById("percentual_promocao").disabled = true;
      }
    }
  }
</script>

<!-- Adição de linhas dinamicamente -->
<script type="text/javascript">
  $(function() {
    function removeCampo() {
      $(".removerCampo").unbind("click");
      $(".removerCampo").bind("click", function() {
        if ($("tr.linhas").length > 1) {
          $(this).parent().parent().remove();
        }
      });
    }

    $(".adicionarCampo").click(function() {
      novoCampo = $("tr.linhas:first").clone();
      novoCampo.find("input").val("");
      novoCampo.insertAfter("tr.linhas:last");
      removeCampo();
    });
  });
</script>


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