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
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tbl_usuarios set nome = ?, rg = ?, cpf = ?, telefone = ?, email = ?, cep = ?, endereco = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, tipo_pix = ?, chave = ?, tipo_contrato = ?, dt_saque = ?, nivel = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $rg, $cpf, $telefone, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $tipo_pix, $chave, $tipo_contrato, $dt_saque, $nivel, $id));
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

$id = '1';
$pdo = BancoCadastros::conectar();
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
                        <h6 class="m-0 font-weight-bold text-primary">DADOS DE CONTATO DO SITE</h6>
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
                        <h6 class="m-0 font-weight-bold text-primary">DADOS DE SEO DO SITE</h6>
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
                    <button type="submit" class="btn btn-primary" name="atualizar">
                        <i class="icon-note"></i> ATUALIZAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>