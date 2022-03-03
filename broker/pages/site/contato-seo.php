<?php
if ($_SERVER['HTTP_HOST'] != 'localhost') {
    if (!isset($_SESSION)) session_start();

    $nivel = 98;

    if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
        echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
        exit;
    }
}

include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();
$id = '1';

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
                window.location.href = "contato-seo";
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


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">EDITAR CONTATO & SEO</h6>
            <p class="mb-4">Preencha todos os campos corretamente.</p>
        </div>
        <div class="card-body">
            <form action="contato-seo?id=<?php echo $id ?>" method="post">
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
                <br /><br />
                <div class="form-actions" align="center">
                    <button type="button" class="btn btn-dark mr-1" onClick="history.go(-1)">
                        <i class="icon-action-undo"></i> VOLTAR
                    </button>
                    <button type="submit" class="btn btn-success" name="atualizar">
                        <i class="icon-note"></i> ATUALIZAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>