<?php
if (!isset($_SESSION)) session_start();

$nivel = 98;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "desc"]
            ]
        });
    });
</script>

<script>
    function verifica(value) {
        var input = document.getElementById("chave");

        if (value == 'Chave Aleatória') {
            input.disabled = false;
        }
        if (value == 'E-mail') {
            input.disabled = false;
        }
        if (value == 'CNPJ') {
            input.disabled = false;
        }
        if (value == 'CPF') {
            input.disabled = false;
        }
        if (value == 'Telefone') {
            input.disabled = false;
        } else if (value == 'Não Possuo') {
            input.disabled = true;
        }
    };
</script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="ml-auto" align="right">
                <div>
                    <button class="btn btn-primary mt-4 mt-sm-0" data-toggle="modal" data-target="#modalNovoUsuario"><i class="fa fa-plus mr-1 mt-1"></i> CADASTRAR</button>
                </div>
            </div>
            <h4 class="m-0 font-weight-bold text-primary">CLIENTES/USUÁRIOS</h4>
            <p class="mb-4">Abaixo serão listadas todos os clientes/usuários cadastrados em nossa plataforma.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>NOME</th>
                            <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                            <th style='text-align: center; vertical-align:middle !important'>TELEFONE</th>
                            <th style='text-align: center; vertical-align:middle !important'>E-MAIL</th>
                            <th style='text-align: center; vertical-align:middle !important'>CLIENTE DESDE</th>
                            <th style='text-align: center; vertical-align:middle !important'>STATUS</th>
                            <th style='text-align: center; vertical-align:middle !important'>NÍVEL</th>
                            <th style='text-align: center; vertical-align:middle !important' width="5%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pdo = BancoCadastros::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM tbl_usuarios ORDER BY nome ASC, status ASC";

                        foreach ($pdo->query($sql) as $row) {

                            if ($row['nome']) {
                                $nome = '' . $row['nome'] . '';
                            }
                            if ($row['cpf']) {
                                $cpf = '' . $row['cpf'] . '';
                            }
                            if ($row['telefone']) {
                                $telefone = '' . $row['telefone'] . '';
                            }
                            if ($row['email']) {
                                $email = '' . $row['email'] . '';
                            }
                            if ($row['dt_cadastro']) {
                                $data_cadastro = '' . $row['dt_cadastro'] . '';
                                $timestamp = strtotime($data_cadastro);
                                $dt_cadastro = '<font size="2">' . date('d/m/Y', $timestamp) . ' </font>';
                            }
                            if ($row['status'] == 1) {
                                $status = '<font size="3" color="green" ><strong> ATIVO </strong></font>';
                            }
                            if ($row['status'] == 2) {
                                $status = '<font size="3" color="red" ><strong> INATIVO </strong></font>';
                            }
                            if ($row['nivel'] == 1) {
                                $nivel = '<font size="3" color="blue" ><strong> CLIENTE </strong></font>';
                            }
                            if ($row['nivel'] == 99) {
                                $nivel = '<font size="3" color="orange" ><strong> OPERADOR </strong></font>';
                            }
                            if ($row['nivel'] == 100) {
                                $nivel = '<font size="3" color="orange" ><strong> green </strong></font>';
                            }

                            echo "<tr>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'><strong>" . $nome . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $cpf . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $telefone . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $email . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $dt_cadastro . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $status . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $id . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            //echo '<a type="button" class="liberacaoInterna btn btn-sm btn-success" onclick="modalLiberar2(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO INTERNA"><i  class="fa fa-file-signature"></i></a>';
                            //echo ' <a type="button" class="liberacaoComprovante btn btn-sm btn-warning" onclick="modalComprovante(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO COM COMPROVANTE DE PGTO."><i  class="fa fa-vote-yea"></i></a>';
                            //echo ' <a type="button" class="reprocessar btn btn-sm btn-primary" data-id="' . $row['id'] . '" title="REPROCESSAR"><i  class="fa fa-share"></i></a>';
                            echo '<form action="noticias" method="POST">';
                            echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                            echo '<a class="btn btn-sm btn-warning" title="EDITAR" href="clientes-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                            if ($row['status'] == 1) {
                                echo '&nbsp;<button type="submit" title="DESATIVAR" class="btn btn-sm btn-danger" name="desativar"><i  class="fa fa-thumbs-down"></i></button>';
                            } else {
                                echo '&nbsp;<button type="submit" title="ATIVAR" class="btn btn-sm btn-success" name="ativar"><i  class="fa fa-thumbs-up"></i></button>';
                            }
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
<div class="modal" id="modalNovoUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADICIONAR NOVO CLIENTE/USUÁRIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form action="clientes" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="basicInput">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" onkeyup="cpfCheck(this)" maxlength="18" onkeydown="javascript: fMasc( this, mCPF );" autocomplete="off" required><span id="cpfResponse"></span></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">Telefone</label>
                                    <input type="text" class="form-control phone" id="telefone" name="telefone" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="basicInput">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" onchange="pesquisacep(this.value);" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="basicInput">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">PIX</label>
                                    <select type="text" class="form-control" id="tipo_pix" name="tipo_pix" autocomplete="off" onchange="verifica(this.value)" required>
                                        <option value="">Selecione...</option>
                                        <option value="Chave Aleatória">Chave Aleatória</option>
                                        <option value="E-mail">E-mail</option>
                                        <option value="CNPJ">CNPJ</option>
                                        <option value="CPF">CPF</option>
                                        <option value="Telefone">Telefone</option>
                                        <option value="Não Possuo">Não Possuo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="basicInput">Chave PIX</label>
                                    <input type="text" class="form-control" id="chave" name="chave" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">Nível Acesso</label>
                                    <select type="text" class="form-control" id="nivel" name="nivel" autocomplete="off" required>
                                        <option value="">Selecione...</option>
                                        <option value="1">Cliente</option>
                                        <option value="98">Operador</option>
                                        <option value="100">Administrador</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
switch (get_post_action('desativar', 'ativar', 'adicionar')) {

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
                        move_uploaded_file($imagem['tmp_name'][$q], '../../assets/img/noticias/' . $tmpname);
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
        // ENVIA TELEGRAM    
        $apiToken = "5155649072:AAF466dIaOiGvEb9qCGavLXNHVXE06ZRPwo";
        $data = [
            "chat_id" => "-1001662279487",
            'parse_mode' => 'HTML',
            'text' => "\n<b>$titulo</b> \n\nConfira em: https://cripto4you.net/ver-noticia?id=" . $_SESSION['id'] . " \n ",
            //'text' => "\nABERTURA CHAMADO URGENTE \n\nChamado: <b>$chamadoID</b> \n\nDepartamento: $SolicitanteDepartamento\nSolicitante: $SolicitanteName\n\n<b>Equipamento:</b> $equipamentoReclamado \n<b>Obs:</b> $observacaoManutencao \n ",
        ];

        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));
        break;

    default:
}
?>

<?php include('../../includes/footer.php'); ?>