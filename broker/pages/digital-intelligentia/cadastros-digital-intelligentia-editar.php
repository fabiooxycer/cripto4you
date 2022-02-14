<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_cadastros WHERE id="' . $id . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

if (!empty($_POST)) {

    $nome        = $_POST['nome'];
    $rg          = $_POST['rg'];
    $cpf         = $_POST['cpf'];
    $telefone    = $_POST['telefone'];
    $celular     = $_POST['celular'];
    $email       = $_POST['email'];
    $cep         = $_POST['cep'];
    $endereco    = $_POST['endereco'];
    $numero      = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro      = $_POST['bairro'];
    $cidade      = $_POST['cidade'];
    $estado      = $_POST['estado'];
    $banco       = $_POST['banco'];
    $conta_tipo  = $_POST['conta_tipo'];
    $agencia     = $_POST['agencia'];
    $conta       = $_POST['conta'];
    $pix         = $_POST['pix'];
    $chave_pix   = $_POST['chave_pix'];
    $atuacao     = $_POST['atuacao'];
    $empresa     = '3'; // DIGITAL INTELLIGENTIA

    if ($complemento == '') {
        $complemento = '';
    }
    if ($telefone == '') {
        $telefone = '';
    }
    if ($celular == '') {
        $celular = '';
    }
    if ($chave_pix == '') {
        $celular = '';
    }


    /* ATUALIZA INFORMAÇÕES NO BANCO DE DADOS */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE tbl_cadastros set nome = ?, rg = ?, cpf = ?, telefone = ?, celular = ?, email = ?, cep = ?, endereco = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, banco = ?, conta_tipo = ?, agencia = ?, conta = ?, pix = ?,  chave_pix = ?, atuacao = ?, empresa = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($nome, $rg, $cpf, $telefone, $celular, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $banco, $conta_tipo, $agencia, $conta, $pix, $chave_pix, $atuacao, $empresa, $id));
    echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "Agente Executivo atualizado com sucesso!",
        type: "success",
        confirmButtonText: "OK"
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "estatisticas-digital-intelligentia";
        }
      }); }, 1000);</script>';
}
?>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DIGITAL INTELLIGENTIA</h6>
            <h6 class="m-0 font-weight-bold text-primary">EDITAR - AGENTE EXECUTIVO - CÓD. <font color="blue"><?php echo $data['meu_id']; ?></font>
            </h6>
            <p class="mb-4">Favor conferir e preencher todos os campos.</p>
        </div>
        <div class="card-body">
            <form action="cadastros-digital-intelligentia-editar?id=<?php echo $id ?>" method="post">
                <div class="px-3">
                    <div class="form-body">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <li>Dados Pessoais</li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CÓD.</font>
                                    </label>
                                    <input type="text" class="form-control" id="meu_id" name="meu_id" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['meu_id']; ?>" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">NOME</font>
                                    </label>
                                    <input type="text" class="form-control" id="nome" name="nome" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['nome']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">RG</font>
                                    </label>
                                    <input type="text" class="form-control" id="rg" name="rg" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['rg']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CPF</font>
                                    </label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" onkeyup="cpfCheck(this)" maxlength="18" onkeydown="javascript: fMasc( this, mCPF );" value="<?php echo $data['cpf']; ?>" required> <span id="cpfResponse"></span></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">TELEFONE</font>
                                    </label>
                                    <input type="text" class="form-control phone" id="telefone" name="telefone" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['telefone']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CELULAR</font>
                                    </label>
                                    <input type="text" class="form-control phone" id="celular" name="celular" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['celular']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">E-MAIL</font>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" onChange="this.value=this.value.toLowerCase()" value="<?php echo $data['email']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CEP</font>
                                    </label>
                                    <input type="text" class="form-control" id="cep" name="cep" onChange="this.value=this.value.toUpperCase()" onchange="pesquisacep(this.value);" value="<?php echo $data['cep']; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">ENDEREÇO</font>
                                    </label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['endereco']; ?>" autocomplete="off" require>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">NÚMERO</font>
                                    </label>
                                    <input type="text" class="form-control" id="numero" name="numero" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['numero']; ?>" autocomplete="off" require>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">COMPLEMENTO</font>
                                    </label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['complemento']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">BAIRRO</font>
                                    </label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['bairro']; ?>" autocomplete="off" require>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CIDADE</font>
                                    </label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['cidade']; ?>" autocomplete="off" require>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">ESTADO</font>
                                    </label>
                                    <input type="text" class="form-control" id="estado" name="estado" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['estado']; ?>" autocomplete="off" require>
                                </div>
                            </div>
                        </div>
                        <br />
                        <h6 class="m-0 font-weight-bold text-primary">
                            <li>Atuação</li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CATEGORIA DO AGENTE</font>
                                    </label>
                                    <select type="text" class="form-control" id="atuacao" name="atuacao" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                        <option value="<?php echo $data['atuacao']; ?>"><?php if ($data['atuacao'] == '1') {
                                                                                            echo 'Agente Executivo Nacional';
                                                                                        }
                                                                                        if ($data['atuacao'] == '2') {
                                                                                            echo 'Agente Executivo Municipal';
                                                                                        }
                                                                                        if ($data['atuacao'] == '3') {
                                                                                            echo 'Agente Operacionail de Inteligência Originário';
                                                                                        }
                                                                                        if ($data['atuacao'] == '4') {
                                                                                            echo 'Agente Operacional de Inteligência';
                                                                                        }
                                                                                        if ($data['atuacao'] == '5') {
                                                                                            echo 'Agente Executivo de Expansão';
                                                                                        }
                                                                                        if ($data['atuacao'] == '6') {
                                                                                            echo 'Agente Executivo de Expansão Meritum';
                                                                                        } ?></option>
                                        <option> </option>
                                        <option value="1">Agente Executivo Nacional</option>
                                        <option value="2">Agente Executivo Municipal</option>
                                        <option value="3">Agente Operacionail de Inteligência Originário</option>
                                        <option value="4">Agente Operacional de Inteligência</option>
                                        <option value="5">Agente Executivo de Expansão</option>
                                        <option value="6">Agente Executivo de Expansão Meritum</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <br />
                        <h6 class="m-0 font-weight-bold text-primary">
                            <li>Dados Bancários</li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">BANCO</font>
                                    </label>
                                    <input type="text" class="form-control" id="banco" name="banco" onChange="this.value=this.value.toUpperCase()" autocomplete="off" value="<?php echo $data['banco']; ?>" require>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">TIPO DE CONTA</font>
                                    </label>
                                    <select type="text" class="form-control" id="conta_tipo" name="conta_tipo" autocomplete="off" required>
                                        <option value="<?php echo $data['conta_tipo']; ?>"><?php echo $data['conta_tipo']; ?></option>
                                        <option value="Pessoa Física">Pessoa Física</option>
                                        <option value="Pessoa Jurídica">Pessoa Jurídica</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">AGÊNCIA</font>
                                    </label>
                                    <input type="text" class="form-control" id="agencia" name="agencia" onChange="this.value=this.value.toUpperCase()" autocomplete="off" value="<?php echo $data['agencia']; ?>" require>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CONTA</font>
                                    </label>
                                    <input type="text" class="form-control" id="conta" name="conta" onChange="this.value=this.value.toUpperCase()" autocomplete="off" value="<?php echo $data['conta']; ?>" require>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">PIX</font>
                                    </label>
                                    <select type="text" class="form-control" id="pix" name="pix" autocomplete="off" onchange="verifica(this.value)" required>
                                        <option value="<?php echo $data['pix']; ?>"><?php echo $data['pix']; ?></option>
                                        <option value="Chave Aleatória">Chave Aleatória</option>
                                        <option value="E-mail">E-mail</option>
                                        <option value="CNPJ">CNPJ</option>
                                        <option value="CPF">CPF</option>
                                        <option value="Telefone">Telefone</option>
                                        <option value="Não Possuo">Não Possuo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CHAVE PIX</font>
                                    </label>
                                    <input type="text" class="form-control" id="chave_pix" name="chave_pix" onChange="this.value=this.value.toUpperCase()" autocomplete="off" value="<?php echo $data['chave_pix']; ?>">
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