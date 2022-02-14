<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

require_once("../../includes/databaseApps.php");
$pdo = BancoApps::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_pericias WHERE id="' . $id . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

if (!empty($_POST)) {

    //$imagem = $_POST['imagem'];
    //$slug   = $_POST['slug'];
    $titulo = $_POST['titulo'];
    $valor  = $_POST['valor'];


    /* ATUALIZA INFORMAÇÕES NO BANCO DE DADOS */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE tbl_pericias set titulo = ?, valor = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($titulo, $valor, $id));
    echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "Perícia Técnica atualizada com sucesso!",
        type: "success",
        confirmButtonText: "OK"
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "apps-pericias";
        }
      }); }, 1000);</script>';
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">APPS - PLATAFORMAS DE RECÁLCULO DE DÍVIDAS E FINANCIAMENTOS</h4>
            <h6 class="m-0 font-weight-bold text-primary">EDITAR PERÍCIA TÉCNICA - <font color="blue"><?php echo $data['titulo']; ?></font>
            </h6>
            <p class="mb-4">Favor conferir e preencher todos os campos.</p>
        </div>
        <div class="card-body">
            <form action="apps-pericias-editar?id=<?php echo $id ?>" method="post">
                <div class="px-3">
                    <div class="form-body">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <li>Informações da Perícia Técnica</li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">TÍTULO</font>
                                    </label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $data['titulo']; ?>" onchange="slug()" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">VALOR DA PERÍCIA</font>
                                    </label>
                                    <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(moeda(this,'.',',',event))" value="<?php echo $data['valor']; ?>" required>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" id="slug" name="slug" onChange="this.value=this.value.toLowerCase()" value="<?php echo $data['slug']; ?>" autocomplete="off" readonly>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title-wrap bar-danger">
                                        <h5 class="card-title mb-0">Está perícia técnica está utilizando a seguinte imagem:</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <fieldset class="form-group">
                                                        <input type="file" class="form-control-file" name="imagem[]" id="imagem" autocomplete="off" value="<?php echo $data['imagem']; ?>">
                                                        <p>
                                                            <font size="1">Enviar nova imagem.</font>
                                                        </p>
                                                    </fieldset>
                                                </div>
                                                <figure class="col-xl-12 col-lg-4 col-sm-12 col-12" align="center">
                                                    <p>
                                                        <font size="1"><strong></strong></font>
                                                    </p>
                                                    <img class="img-thumbnail img-fluid" src="https://app.debtools.com.br/assets/imagens/pericias/<?php echo $data['imagem']; ?>" alt="<?php echo $data['titulo']; ?>" width="640" />
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br /><br />
                <div class="form-actions" align="center">
                    <button type="button" class="btn btn-dark mr-1" onClick="history.go(-1)">
                        <i class="icon-action-undo"></i> VOLTAR
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="icon-note"></i> ATUALIZAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function slug(txt) {
        //Transforma espaço em underline
        txt = txt.replace(/[\s]/gi, '_');

        // Tira acentuação e hífen
        txt = txt.replace(new RegExp('[-]', 'gi'), '');
        txt = txt.replace(new RegExp('[ÁÀÂÃ]', 'gi'), 'A');
        txt = txt.replace(new RegExp('[ÉÈÊ]', 'gi'), 'E');
        txt = txt.replace(new RegExp('[ÍÌÎ]', 'gi'), 'I');
        txt = txt.replace(new RegExp('[ÓÒÔÕ]', 'gi'), 'O');
        txt = txt.replace(new RegExp('[ÚÙÛ]', 'gi'), 'U');
        txt = txt.replace(new RegExp('[Ç]', 'gi'), 'C');

        // Remove caracteres especiais
        txt = txt.replace(/[^a-z0-9-_]/gi, '');

        // Transforma em minúsculo
        txt = txt.toLowerCase();

        return txt;
    }

    $('#titulo').keyup(function() {
        $('#slug').val(slug($('#titulo').val()));
    });
</script>



<?php include('../../includes/footer.php'); ?>