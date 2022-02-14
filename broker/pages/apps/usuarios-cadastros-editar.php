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
$sql = 'SELECT
usuario.id,
usuario.id_aplicacao AS id_aplicacao,
aplicacao.titulo AS titulo_app,
usuario.nome,
usuario.telefone1,
usuario.email,
usuario.cod_indicacao,
usuario.rg,
usuario.cpf,
usuario.id_plano,
plano.titulo
FROM tbl_usuarios AS usuario
LEFT JOIN tbl_aplicacoes AS aplicacao
ON usuario.id_aplicacao = aplicacao.id
LEFT JOIN tbl_planos_debtools as plano
ON usuario.id_plano = plano.id WHERE usuario.id="' . $id . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

if (!empty($_POST)) {

    $aplicacao      = $_POST['id_aplicacao'];
    $nome           = $_POST['nome'];
    $telefone       = $_POST['telefone'];
    $email          = $_POST['email'];
    $cod_indicacao  = $_POST['cod_indicacao'];
    $rg             = $_POST['rg'];
    $cpf            = $_POST['cpf'];

    if ($cod_indicacao = null) {
        $cod_indicacao = '';
    }


    /* ATUALIZA INFORMAÇÕES NO BANCO DE DADOS */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE tbl_usuarios set id_aplicacao = ?, nome = ?, telefone1 = ?, email = ?, cod_indicacao = ?, rg = ?, cpf = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($aplicacao, $nome, $telefone, $email, $cod_indicacao, $rg, $cpf, $id));
    echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "Cadastro atualizado com sucesso!",
        type: "success",
        confirmButtonText: "OK"
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "usuarios-cadastros";
        }
      }); }, 1000);</script>';
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">APPS - PLATAFORMAS DE RECÁLCULO DE DÍVIDAS E FINANCIAMENTOS</h4>
            <h6 class="m-0 font-weight-bold text-primary">EDITAR USUARIO - <font color="blue"><?php echo $data['nome']; ?></font>
            </h6>
            <p class="mb-4">Favor conferir e preencher todos os campos.</p>
        </div>
        <div class="card-body">
            <form action="usuarios-cadastros-editar?id=<?php echo $id ?>" method="post">
                <div class="px-3">
                    <div class="form-body">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <li>Informações do Usuário</li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">APP</font>
                                    </label>
                                    <select class=" form-control custom-select" type="text" name="id_aplicacao" id="id_aplicacao" required>
                                        <option value="<?php echo $data['id_aplicacao']; ?>"><?php echo $data['titulo_app']; ?></option>
                                        <?php
                                        $sql1 = "SELECT * FROM tbl_aplicacoes ORDER By titulo ASC";

                                        foreach ($pdo->query($sql1) as $row) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['titulo'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">NOME</font>
                                    </label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $data['nome']; ?>" onChange="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">TELEFONE</font>
                                    </label>
                                    <input type="text" class="form-control phone" id="telefone" name="telefone" value="<?php echo $data['telefone1']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">E-MAIL</font>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>" onChange="this.value=this.value.toLowerCase()" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">RG</font>
                                    </label>
                                    <input type="text" class="form-control" id="rg" name="rg" value="<?php echo $data['rg']; ?>" onChange="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CPF</font>
                                    </label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $data['cpf']; ?>" onChange="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CÓD. INDICAÇÃO</font>
                                    </label>
                                    <input type="text" class="form-control" id="cod_indicacao" name="cod_indicacao" value="<?php echo $data['cod_indicacao']; ?>" onChange="this.value=this.value.toLowerCase()">
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

<?php include('../../includes/footer.php'); ?>