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

    $nome              = $_POST['nome'];
    $rg                = $_POST['rg'];
    $cpf               = $_POST['cpf'];
    $telefone          = $_POST['telefone'];
    $celular           = $_POST['celular'];
    $email             = $_POST['email'];
    $cep               = $_POST['cep'];
    $endereco          = $_POST['endereco'];
    $numero            = $_POST['numero'];
    $complemento       = $_POST['complemento'];
    $bairro            = $_POST['bairro'];
    $cidade            = $_POST['cidade'];
    $estado            = $_POST['estado'];
    $banco             = $_POST['banco'];
    $conta_tipo        = $_POST['conta_tipo'];
    $agencia           = $_POST['agencia'];
    $conta             = $_POST['conta'];
    $pix               = $_POST['pix'];
    $chave_pix         = $_POST['chave_pix'];
    
    $cep_exterior      = $_POST['cep_exterior'];
    $endereco_exterior = $_POST['endereco_exterior'];
    $cidade_exterior   = $_POST['cidade_exterior'];
    $estado_exterior   = $_POST['estado_exterior'];
    $pais_exterior     = $_POST['pais_exterior'];
    $atuacao           = $_POST['atuacao'];
    $empresa           = $_POST['empresa'];

    if ($complemento == '') {
        $complemento = '';
    }
    if ($cep_exterior == '') {
        $cep_exterior = '';
    }
    if ($endereco_exterior == '') {
        $endereco_exterior = '';
    }
    if ($cidade_exterior == '') {
        $cidade_exterior = '';
    }
    if ($estado_exterior == '') {
        $estado_exterior = '';
    }
    if ($pais_exterior == '') {
        $pais_exterior = '';
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
    $sql = "UPDATE tbl_cadastros set nome = ?, rg = ?, cpf = ?, telefone = ?, celular = ?, email = ?, cep = ?, endereco = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, cep_exterior = ?, endereco_exterior = ?, cidade_exterior = ?, estado_exterior = ?, pais_exterior = ?, banco = ?, conta_tipo = ?, agencia = ?, conta = ?, pix = ?,  chave_pix = ?, atuacao = ?, empresa = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($nome, $rg, $cpf, $telefone, $celular, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $cep_exterior, $endereco_exterior, $cidade_exterior, $estado_exterior, $pais_exterior, $banco, $conta_tipo, $agencia, $conta, $pix, $chave_pix, $atuacao, $empresa, $id));
    echo '<script>setTimeout(function () { 
      swal({
        title: "Parabéns!",
        text: "CFFE atualizado com sucesso!",
        type: "success",
        confirmButtonText: "OK"
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "estatistica-intelligenz";
        }
      }); }, 1000);</script>';
}
?>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">INTELLIGENZ BANCO DIGITAL</h4>
            <h6 class="m-0 font-weight-bold text-primary">EDITAR - CONSELHEIRO FINANCEIRO FAMILIAR E EMPRESARIAL - CÓD. <font color="blue"><?php echo $data['meu_id']; ?></font>
            </h6>
            <p class="mb-4">Favor conferir e preencher todos os campos.</p>
        </div>
        <div class="card-body">
            <form action="cadastros-banco-intelligenz-editar?id=<?php echo $id ?>" method="post">
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
                            <li>Residência no Exterior <font size="1">(Caso não resida no exterior, favor não preencher os dados abaixo).</font>
                                </p>
                            </li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CEP</font>
                                    </label>
                                    <input type="text" class="form-control" id="cep_exterior" name="cep_exterior" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['cep_exterior']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">ENDEREÇO</font>
                                    </label>
                                    <input type="text" class="form-control" id="endereco_exterior" name="endereco_exterior" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['endereco_exterior']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CIDADE</font>
                                    </label>
                                    <input type="text" class="form-control" id="cidade_exterior" name="cidade_exterior" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['cidade_exterior']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">ESTADO</font>
                                    </label>
                                    <input type="text" class="form-control" id="estado_exterior" name="estado_exterior" onChange="this.value=this.value.toUpperCase()" value="<?php echo $data['estado_exterior']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">PAÍS</font>
                                    </label>
                                    <select type="text" class="form-control" id="pais_exterior" name="pais_exterior" autocomplete="off">
                                        <?php if ($data['pais_exterior'] != '') { ?>
                                            <option value="<?php echo $data['pais_exterior']; ?>"><?php echo $data['pais_exterior']; ?></option>
                                        <?php }
                                        if ($data['pais_exterior'] == '') { ?>
                                            <option>Selecione...</option>
                                        <?php } ?>
                                        <option value="Afeganistão">Afeganistão</option>
                                        <option value="África do Sul">África do Sul</option>
                                        <option value="Albânia">Albânia</option>
                                        <option value="Alemanha">Alemanha</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Antiga e Barbuda">Antiga e Barbuda</option>
                                        <option value="Arábia Saudita">Arábia Saudita</option>
                                        <option value="Argélia">Argélia</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Arménia">Arménia</option>
                                        <option value="Austrália">Austrália</option>
                                        <option value="Áustria">Áustria</option>
                                        <option value="Azerbaijão">Azerbaijão</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bangladexe">Bangladexe</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Barém">Barém</option>
                                        <option value="Bélgica">Bélgica</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benim">Benim</option>
                                        <option value="Bielorrússia">Bielorrússia</option>
                                        <option value="Bolívia">Bolívia</option>
                                        <option value="Bósnia e Herzegovina">Bósnia e Herzegovina</option>
                                        <option value="Botsuana">Botsuana</option>
                                        <option value="Brasil">Brasil</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgária">Bulgária</option>
                                        <option value="Burquina Faso">Burquina Faso</option>
                                        <option value="Burúndi">Burúndi</option>
                                        <option value="Butão">Butão</option>
                                        <option value="Cabo Verde">Cabo Verde</option>
                                        <option value="Camarões">Camarões</option>
                                        <option value="Camboja">Camboja</option>
                                        <option value="Canadá">Canadá</option>
                                        <option value="Catar">Catar</option>
                                        <option value="Cazaquistão">Cazaquistão</option>
                                        <option value="Chade">Chade</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Chipre">Chipre</option>
                                        <option value="Colômbia">Colômbia</option>
                                        <option value="Comores">Comores</option>
                                        <option value="Congo-Brazzaville">Congo-Brazzaville</option>
                                        <option value="Coreia do Norte">Coreia do Norte</option>
                                        <option value="Coreia do Sul">Coreia do Sul</option>
                                        <option value="Cosovo">Cosovo</option>
                                        <option value="Costa do Marfim">Costa do Marfim</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Croácia">Croácia</option>
                                        <option value="Cuaite">Cuaite</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Dinamarca">Dinamarca</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Egito">Egito</option>
                                        <option value="Emirados Árabes Unidos">Emirados Árabes Unidos</option>
                                        <option value="Equador">Equador</option>
                                        <option value="Eritreia">Eritreia</option>
                                        <option value="Eslováquia">Eslováquia</option>
                                        <option value="Eslovénia">Eslovénia</option>
                                        <option value="Espanha">Espanha</option>
                                        <option value="Essuatíni">Essuatíni</option>
                                        <option value="Estado da Palestina">Estado da Palestina</option>
                                        <option value="Estados Unidos">Estados Unidos</option>
                                        <option value="Estónia">Estónia</option>
                                        <option value="Etiópia">Etiópia</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Filipinas">Filipinas</option>
                                        <option value="Finlândia">Finlândia</option>
                                        <option value="França">França</option>
                                        <option value="Gabão">Gabão</option>
                                        <option value="Gâmbia">Gâmbia</option>
                                        <option value="Gana">Gana</option>
                                        <option value="Geórgia">Geórgia</option>
                                        <option value="Granada">Granada</option>
                                        <option value="Grécia">Grécia</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guiana">Guiana</option>
                                        <option value="Guiné">Guiné</option>
                                        <option value="Guiné Equatorial">Guiné Equatorial</option>
                                        <option value="Guiné-Bissau">Guiné-Bissau</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hungria">Hungria</option>
                                        <option value="Iémen">Iémen</option>
                                        <option value="Ilhas Marechal">Ilhas Marechal</option>
                                        <option value="Índia">Índia</option>
                                        <option value="Indonésia">Indonésia</option>
                                        <option value="Irão">Irão</option>
                                        <option value="Iraque">Iraque</option>
                                        <option value="Irlanda">Irlanda</option>
                                        <option value="Islândia">Islândia</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Itália">Itália</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japão">Japão</option>
                                        <option value="Jibuti">Jibuti</option>
                                        <option value="Jordânia">Jordânia</option>
                                        <option value="Laus">Laus</option>
                                        <option value="Lesoto">Lesoto</option>
                                        <option value="Letónia">Letónia</option>
                                        <option value="Líbano">Líbano</option>
                                        <option value="Libéria">Libéria</option>
                                        <option value="Líbia">Líbia</option>
                                        <option value="Listenstaine">Listenstaine</option>
                                        <option value="Lituânia">Lituânia</option>
                                        <option value="Luxemburgo">Luxemburgo</option>
                                        <option value="Macedónia do Norte">Macedónia do Norte</option>
                                        <option value="Madagáscar">Madagáscar</option>
                                        <option value="Malásia">Malásia</option>
                                        <option value="Maláui">Maláui</option>
                                        <option value="Maldivas">Maldivas</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marrocos">Marrocos</option>
                                        <option value="Maurícia">Maurícia</option>
                                        <option value="Mauritânia">Mauritânia</option>
                                        <option value="México">México</option>
                                        <option value="Mianmar">Mianmar</option>
                                        <option value="Micronésia">Micronésia</option>
                                        <option value="Moçambique">Moçambique</option>
                                        <option value="Moldávia">Moldávia</option>
                                        <option value="Mónaco">Mónaco</option>
                                        <option value="Mongólia">Mongólia</option>
                                        <option value="Montenegro">Montenegro</option>
                                        <option value="Namíbia">Namíbia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Nicarágua">Nicarágua</option>
                                        <option value="Níger">Níger</option>
                                        <option value="Nigéria">Nigéria</option>
                                        <option value="Noruega">Noruega</option>
                                        <option value="Nova Zelândia">Nova Zelândia</option>
                                        <option value="Omã">Omã</option>
                                        <option value="Países Baixos">Países Baixos</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panamá">Panamá</option>
                                        <option value="Papua Nova Guiné">Papua Nova Guiné</option>
                                        <option value="Paquistão">Paquistão</option>
                                        <option value="Paraguai">Paraguai</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Polónia">Polónia</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Quénia">Quénia</option>
                                        <option value="Quirguistão">Quirguistão</option>
                                        <option value="Quiribáti">Quiribáti</option>
                                        <option value="Reino Unido">Reino Unido</option>
                                        <option value="República Centro-Africana">República Centro-Africana</option>
                                        <option value="República Checa">República Checa</option>
                                        <option value="República Democrática do Congo">República Democrática do Congo</option>
                                        <option value="República Dominicana">República Dominicana</option>
                                        <option value="Roménia">Roménia</option>
                                        <option value="Ruanda">Ruanda</option>
                                        <option value="Rússia">Rússia</option>
                                        <option value="Salomão">Salomão</option>
                                        <option value="Salvador">Salvador</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Santa Lúcia">Santa Lúcia</option>
                                        <option value="São Cristóvão e Neves">São Cristóvão e Neves</option>
                                        <option value="São Marinho">São Marinho</option>
                                        <option value="São Tomé e Príncipe">São Tomé e Príncipe</option>
                                        <option value="São Vicente e Granadinas">São Vicente e Granadinas</option>
                                        <option value="Seicheles">Seicheles</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serra Leoa">Serra Leoa</option>
                                        <option value="Sérvia">Sérvia</option>
                                        <option value="Singapura">Singapura</option>
                                        <option value="Síria">Síria</option>
                                        <option value="Somália">Somália</option>
                                        <option value="Sri Lanca">Sri Lanca</option>
                                        <option value="Sudão">Sudão</option>
                                        <option value="Sudão do Sul">Sudão do Sul</option>
                                        <option value="Suécia">Suécia</option>
                                        <option value="Suíça">Suíça</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Tailândia">Tailândia</option>
                                        <option value="Taiuã">Taiuã</option>
                                        <option value="Tajiquistão">Tajiquistão</option>
                                        <option value="Tanzânia">Tanzânia</option>
                                        <option value="Timor-Leste">Timor-Leste</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trindade e Tobago">Trindade e Tobago</option>
                                        <option value="Tunísia">Tunísia</option>
                                        <option value="Turcomenistão">Turcomenistão</option>
                                        <option value="Turquia">Turquia</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Ucrânia">Ucrânia</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Uruguai">Uruguai</option>
                                        <option value="Usbequistão">Usbequistão</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vaticano">Vaticano</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietname">Vietname</option>
                                        <option value="Zâmbia">Zâmbia</option>
                                        <option value="Zimbábue">Zimbábue</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br />
                        <h6 class="m-0 font-weight-bold text-primary">
                            <li>Atuação</li>
                        </h6><br />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">CATEGORIA DO AGENTE</font>
                                    </label>
                                    <select type="text" class="form-control" id="atuacao" name="atuacao" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                        <option value="<?php echo $data['atuacao']; ?>"><?php if ($data['atuacao'] == '1') {
                                                                                            echo 'CFFE-AEN';
                                                                                        }
                                                                                        if ($data['atuacao'] == '2') {
                                                                                            echo 'CFFE-AEM';
                                                                                        }
                                                                                        if ($data['atuacao'] == '3') {
                                                                                            echo 'CFFE-AOIO';
                                                                                        }
                                                                                        if ($data['atuacao'] == '4') {
                                                                                            echo 'CFFE-AOI';
                                                                                        }
                                                                                        if ($data['atuacao'] == '5') {
                                                                                            echo 'CFFE-AEE';
                                                                                        }
                                                                                        if ($data['atuacao'] == '6') {
                                                                                            echo 'CFFE-AEEM';
                                                                                        }  ?></option>
                                        <option> </option>
                                        <option value="1">CFFE-AEN</option>
                                        <option value="2">CFFE-AEM</option>
                                        <option value="3">CFFE-AOIO</option>
                                        <option value="4">CFFE-AOI</option>
                                        <option value="5">CFFE-AEE</option>
                                        <option value="6">CFFE-AEEM</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicInput">
                                        <font size="1">BANCO</font>
                                    </label>
                                    <select type="text" class="form-control" id="empresa" name="empresa" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                                        <option value="<?php echo $data['empresa']; ?>"><?php if ($data['empresa'] == '6') {
                                                                                            echo 'LAVVOR';
                                                                                        }
                                                                                        if ($data['empresa'] == '7') {
                                                                                            echo 'INTELLIGENZ';
                                                                                        }
                                                                                        if ($data['empresa'] == '8') {
                                                                                            echo 'CONSTELLATER';
                                                                                        } ?></option>
                                        <option> </option>
                                        <option value="6">LAVVOR</option>
                                        <option value="7">INTELLIGENZ</option>
                                        <option value="8">CONSTELLATER</option>
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