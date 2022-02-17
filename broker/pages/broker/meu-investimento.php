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
                [2, "desc"]
            ]
        });
    });
</script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="ml-auto" align="right">
                <div>
                    <button class="btn btn-danger mt-4 mt-sm-0" data-toggle="modal" data-target="#modalSaque"><i class="fa fa-minus mr-1 mt-1"></i> SAQUE</button>

                    <button class="btn btn-success mt-4 mt-sm-0" data-toggle="modal" data-target="#modalDeposito"><i class="fa fa-plus mr-1 mt-1"></i> DEPÓSITO</button>
                </div>
            </div>
            <h4 class="m-0 font-weight-bold text-primary">MEU INVESTIMENTO</h4>
            <p class="mb-4">Abaixo serão listadas todas movimentações realizadas em sua conta.</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='text-align: center; vertical-align:middle !important'>DESCRIÇÃO</th>
                                <th style='text-align: center; vertical-align:middle !important'>TIPO</th>
                                <th style='text-align: center; vertical-align:middle !important'>DATA/HORÁRIO</th>
                                <th style='text-align: center; vertical-align:middle !important'>VALOR</th>
                                <th style='text-align: center; vertical-align:middle !important' width="5%">AÇÃO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pdo = BancoCadastros::conectar();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT * FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" ORDER BY dt_criacao DESC, hr_criacao DESC';

                            foreach ($pdo->query($sql) as $row) {

                                if ($row['descricao']) {
                                    $descricao = '' . $row['descricao'] . '';
                                }
                                if ($row['tipo'] == 1) {
                                    $tipo = '<font size="3" color="green" ><strong> CRÉDITO </strong></font>';
                                }
                                if ($row['tipo'] == 2) {
                                    $tipo = '<font size="3" color="red" ><strong> DÉBITO </strong></font>';
                                }
                                if ($row['dt_criacao']) {
                                    $data_criacao = '' . $row['dt_criacao'] . '';
                                    $timestamp = strtotime($data_criacao);
                                    $dt_criacao = '<font size="3">' . date('d/m/Y', $timestamp) . ' </font>';
                                }
                                if ($row['hr_criacao']) {
                                    $hora_criacao = '' . $row['hr_criacao'] . '';
                                    $timestamp2 = strtotime($hora_criacao);
                                    $hr_criacao = '<font size="3">' . date('H:i:s', $timestamp2) . ' </font>';
                                }
                                if ($row['valor']) {
                                    $valor = '' . $row['valor'] . '';
                                }

                                echo "<tr>";
                                echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'><strong>" . $descricao . "</strong></font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $tipo . "</strong></font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_criacao . " às " . $hr_criacao . "</font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'><strong>" . $valor . "</strong></font></td>";
                                echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                                // echo '<a type="button" class="liberacaoInterna btn btn-sm btn-success" onclick="modalLiberar2(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO INTERNA"><i  class="fa fa-file-signature"></i></a>';
                                // echo ' <a type="button" class="liberacaoComprovante btn btn-sm btn-warning" onclick="modalComprovante(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO COM COMPROVANTE DE PGTO."><i  class="fa fa-vote-yea"></i></a>';
                                // echo ' <a type="button" class="reprocessar btn btn-sm btn-primary" data-id="' . $row['id'] . '" title="REPROCESSAR"><i  class="fa fa-share"></i></a>';
                                echo '<form action="meu-investimento" method="POST">';
                                echo '<a class="btn btn-sm btn-warning" title="EDITAR" href="clientes-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                                echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                                if ($row['status'] == 1) {
                                    echo '&nbsp;<button type="submit" title="DESATIVAR" class="btn btn-sm btn-danger" name="desativar"><i  class="fa fa-thumbs-down"></i></button>';
                                } else {
                                    echo '&nbsp;<button type="submit" title="ATIVAR" class="btn btn-sm btn-success" name="ativar"><i  class="fa fa-thumbs-up"></i></button>';
                                }
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
    switch (get_post_action('desativar', 'ativar', 'adicionar')) {

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

        default:
    }
    ?>

    <?php include('../../includes/footer.php'); ?>