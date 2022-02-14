<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
?>

<script>
    function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) $maskared. = $val[$k++];
            } else {
                if (isset($mask[$i])) $maskared. = $mask[$i];
            }
        }
        return $maskared;
    }
</script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="ml-auto" align="right">
                <div>
                    <button class="btn btn-primary mt-4 mt-sm-0" data-toggle="modal" data-target="#modalNovaNoticia"><i class="fa fa-plus mr-1 mt-1"></i> CADASTRAR</button>
                </div>
            </div>
            <h4 class="m-0 font-weight-bold text-primary">NOTÍCIAS</h4>
            <p class="mb-4">Abaixo serão listadas todas as noticias exbidas no site.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">IMAGEM</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">DATA</th>
                            <th style='text-align: center; vertical-align:middle !important'>TÍTULO</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pdo = BancoCadastros::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM tbl_noticias ORDER BY dt_postagem,hr_postagem DESC";

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['imagem']) {
                                $imagem = '<img src="https://cripto4you.net/assets/images/blog/grid/' . $row['imagem'] . '" width="25%">';
                            }
                            if ($row['dt_postagem']) {
                                $data_postagem = '' . $row['dt_postagem'] . '';
                                $timestamp = strtotime($data_postagem);
                                $dt_postagem = '<font size="2">' . date('d/m/Y', $timestamp) . ' </font>';
                            }
                            if ($row['hr_postagem']) {
                                $hora_postagem = '' . $row['hr_postagem'] . '';
                                $timestamp2 = strtotime($hora_postagem);
                                $hr_postagem = '<font size="2">' . date('H:i:s', $timestamp2) . ' </font>';
                            }

                            if ($row['titulo']) {
                                $titulo = '' . $row['titulo'] . '';
                            }

                            echo "<tr>";
                            echo "<td width=250>" . $imagem . "</td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_postagem . " às " . $hr_postagem . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'><strong>" . $titulo . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            //echo '<a type="button" class="liberacaoInterna btn btn-sm btn-success" onclick="modalLiberar2(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO INTERNA"><i  class="fa fa-file-signature"></i></a>';
                            //echo ' <a type="button" class="liberacaoComprovante btn btn-sm btn-warning" onclick="modalComprovante(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO COM COMPROVANTE DE PGTO."><i  class="fa fa-vote-yea"></i></a>';
                            //echo ' <a type="button" class="reprocessar btn btn-sm btn-primary" data-id="' . $row['id'] . '" title="REPROCESSAR"><i  class="fa fa-share"></i></a>';
                            echo '<form action="noticias" method="POST">';
                            echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                            echo '<a class="btn btn-sm btn-warning" title="EDITAR" href="noticia-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                            echo '&nbsp;<button type="submit" title="EXCLUIR" class="btn btn-sm btn-danger" name="excluir"><i  class="fa fa-trash"></i></button>';
                            echo "</form>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        BancoCadastros::desconectar()
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Exibe o Modal para inserção dos Cliente -->
<div class="modal" id="modalNovaNoticia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
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
                                    <input type="file" class="form-control" id="imagem" name="imagem[]" multiple="multiple" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição sobre a notícia" required></textarea>
                                </div>
                            </div>
                        </div>
                        <strong>
                            <font size="2" color="#2CABE3">Sua imagem será redefinida para:</font>
                        </strong>
                        <font size="2"> 839 x 630 px </font>
                        <br><br>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="adicionar" class="btn btn-primary"><i class="fa fa-check"></i> CADASTRAR</button>
                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<?php
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

                        //nome gerado para a imagem a cada loop
                        $tmpname = md5(time() . rand(0, 999)) . '.jpeg';

                        //aqui a imagem ja é movida (upload) para a pasta (assets/img/anuncios/) com seu novo name ($tmpname)
                        move_uploaded_file($imagem['tmp_name'][$q], 'https://cripto4you.net/assets/images/blog/grid/' . $tmpname);

                        //daqui pra baixo é um brinde kkk, apenas para criarmos uma nova imagem com largura, altura desejados
                        list($larg_orig, $alt_orig) = getimagesize('https://cripto4you.net/assets/images/blog/grid/' . $tmpname);
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
                            $original = imagecreatefromjpeg('https://cripto4you.net/assets/images/blog/grid/' . $tmpname);
                        } elseif ($tipo == 'image/png') {
                            $original = imagecreatefrompng('https://cripto4you.net/assets/images/blog/grid/' . $tmpname);
                        }
                        imagecopyresampled($img, $original, 0, 0, 0, 0, $largura, $altura, $larg_orig, $alt_orig);

                        imagejpeg($img, 'https://cripto4you.net/assets/images/blog/grid/' . $tmpname, 80);

                        // aqui ja faço a inserção de cada novo name da imagem no banco de dados
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql3 = "UPDATE tbl_noticias set imagem = ? WHERE id = ?";
                        $q = $pdo->prepare($sql3);
                        $q->execute(array($tmpname, $_SESSION['id']));
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
?>

<?php include('../../includes/footer.php'); ?>