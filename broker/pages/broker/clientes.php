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
            <div class="ml-auto" align="left">
                <div>
                    <button class="btn btn-primary mt-4 mt-sm-0" data-toggle="modal" data-target="#modalNovoUsuario"><i class="fa fa-plus mr-1 mt-1"></i> CADASTRAR</button>
                </div>
            </div><br>
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
                            <th style='text-align: center; vertical-align:middle !important' width="11%">AÇÃO</th>
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
                                $dt_cadastro = date('d/m/Y', $timestamp);
                            }
                            if ($row['status'] == 1) {
                                $status = '<font color="green"> ATIVO </font>';
                            }
                            if ($row['status'] == 2) {
                                $status = '<font color="red"> INATIVO </font>';
                            }
                            if ($row['nivel'] == 1) {
                                $nivel = '<font color="blue"> CLIENTE </font>';
                            }
                            if ($row['nivel'] == 99) {
                                $nivel = '<font color="orange"> OPERADOR </font>';
                            }
                            if ($row['nivel'] == 100) {
                                $nivel = '<font color="#666666"> ADMINISTRADOR </font>';
                            }

                            echo "<tr>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $cpf . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $telefone . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $email . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $dt_cadastro . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $status . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nivel . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            echo '<form action="clientes" method="POST">';
                            echo '<a class="btn btn-sm btn-info" title="MOVIMENTAÇÕES" href="clientes-movimentacao?id=' . $row['id'] . '"><i class="fa fa-eye"></i></a>';
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="clientes-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                            echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                            if ($row['status'] == 1) {
                                echo '&nbsp;<button type="submit" title="DESATIVAR" class="btn btn-sm btn-danger" name="desativar"><i  class="fa fa-thumbs-down"></i></button>';
                            } else {
                                echo '&nbsp;<button type="submit" title="ATIVAR" class="btn btn-sm btn-success" name="ativar"><i  class="fa fa-thumbs-up"></i></button>';
                            }
                            echo '&nbsp;<button type="submit" title="REDEFINIR SENHA" class="btn btn-sm btn-secondary" name="redefinir"><i  class="fa fa-key"></i></button>';
                            echo "</form>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        // BancoCadastros::desconectar()
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Exibe o Modal para inserção dos Cliente -->
<div class="modal fade" id="modalNovoUsuario" tabindex="-1" role="dialog" aria-labelledby="modalNovoUsuario" aria-hidden="true" >
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
                                    <input type="text" class="form-control" id="nome" name="nome" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
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
                                    <input type="text" class="form-control" id="endereco" name="endereco" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
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
                                    <input type="text" class="form-control" id="complemento" name="complemento" onChange="this.value=this.value.toUpperCase()" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicInput">Chave PIX</label>
                                    <input type="text" class="form-control" id="chave" name="chave" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">Nível Acesso</label>
                                    <select type="text" class="form-control" id="nivel" name="nivel" autocomplete="off" required>
                                        <option value="">Selecione...</option>
                                        <option value="1">Cliente</option>
                                        <option value="99">Operador</option>
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
switch (get_post_action('desativar', 'ativar', 'adicionar', 'redefinir')) {

    case 'desativar':

        if (!empty($_POST)) {

            $id          = $_POST['id'];
            $status_down = '2';

            //Validaçao dos campos:
            $validacao = true;
        }

        //Delete do banco:
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_usuarios SET status = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($status_down, $id));
        echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Cliente/Usuário desativado com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes";
              }
            }); }, 1000);</script>';
        break;

    case 'ativar':

        if (!empty($_POST)) {

            $id          = $_POST['id'];
            $status_up = '1';

            //Validaçao dos campos:
            $validacao = true;
        }

        //Delete do banco:
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_usuarios SET status = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($status_up, $id));
        echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Cliente/Usuário ativado com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes";
                  }
                }); }, 1000);</script>';
        break;

    case 'adicionar':

        if (!empty($_POST)) {

            $nome        = $_POST['nome'];
            $rg          = $_POST['rg'];
            $cpf         = $_POST['cpf'];
            $telefone    = $_POST['telefone'];
            $email       = $_POST['email'];
            $cep         = $_POST['cep'];
            $endereco    = $_POST['endereco'];
            $numero      = $_POST['numero'];
            $complemento = $_POST['complemento'];
            $bairro      = $_POST['bairro'];
            $cidade      = $_POST['cidade'];
            $estado      = $_POST['estado'];
            $tipo_pix    = $_POST['tipo_pix'];
            $chave       = $_POST['chave'];
            $status      = '1';
            $nivel       = $_POST['nivel'];
            $dt_cadastro = date("Y-m-d");

            if ($complemento == '') {
                $complemento = '-';
            }
            if ($chave == '') {
                $chave = '-';
            }
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM tbl_usuarios WHERE cpf = "' . $_POST['cpf'] . '"';
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['cpf']));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        if ($data['cpf'] != $_POST['cpf']) {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tbl_usuarios (nome, rg, cpf, telefone, email, cep, endereco, numero, complemento, bairro, cidade, estado, tipo_pix, chave, status, nivel, dt_cadastro) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome, $rg, $cpf, $telefone, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $tipo_pix, $chave, $status, $nivel, $dt_cadastro));
            echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Cliente/Usuário cadastrado com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes";
              }
            }); }, 1000);</script>';
        }
        if ($data['cpf'] == $_POST['cpf']) {
            echo '<script>setTimeout(function () { 
                swal({
                  title: "Atenção!",
                  text: "Cliente/Usuário já possui cadastro!",
                  type: "warning",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes";
                  }
                }); }, 1000);</script>';
        }
        break;

    case 'redefinir':

        if (!empty($_POST)) {

            $id    = $_POST['id'];
            $senha = '';

            //Validaçao dos campos:
            $validacao = true;
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE tbl_usuarios SET senha = ? WHERE id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($senha, $id));
        echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Redefinição de senha realizada com sucesso!",
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
?>

<?php include('../../includes/footer.php'); ?>