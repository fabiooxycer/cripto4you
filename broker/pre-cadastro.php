<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $seo['titulo']; ?></title>
    <meta name="description" content="<?php echo $seo['descricao']; ?>" />
    <link rel="icon" type="image/x-icon" href="assets/images/seo/<?php echo $seo['icone']; ?>">
    <link rel="canonical" href="https://<?php echo $seo['dominio']; ?>" />
    <meta name="generator" content="<?php echo $seo['titulo']; ?>" />
    <meta property="og:url" content="https://cripto4you.net" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo $seo['titulo']; ?>" />
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:title" content="<?php echo $seo['titulo']; ?>" />
    <meta property="og:description" content="<?php echo $seo['descricao']; ?>" />
    <meta property="og:image" content="assets/images/seo/avatar.jpg" />
    <meta name="description" content="<?php echo $seo['descricao']; ?>">
    <meta name="keywords" content="<?php echo $seo['keywords']; ?>" />
    <meta name="robots" content="index, follow" />

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" crossorigin="anonymous"></script>
</head>

<?php
include("includes/selects-db.php");
include("includes/scripts.php");

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
?>

<body>
    <!-- Sign in Start -->
    <section class="sign-in-page">
        <div id="container-inside">
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
        </div>
        <div class="container p-0">
            <div class="row no-gutters height-self-center">
                <div class="col-sm-12 align-self-center">
                    <div class="row m-0">
                        <div class="col-md-12 bg-white sign-in-page-data">
                            <div class="sign-in-from">
                                <h1 class="mb-0 text-center"><img src="assets/images/logo.png" alt="Cripto4You"></h1><br>
                                <p class="text-center text-dark">Preencha todos os campos abaixo corretamente</p>
                                <form class="mt-4" action="pre-cadastro" method="POST">
                                    <input type="hidden" class="form-control mb-0" id="id_indicacao" name="id_indicacao" value="<?php echo $id; ?>" readonly>

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
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="basicInput">Chave PIX</label>
                                                <input type="text" class="form-control" id="chave" name="chave" autocomplete="off">
                                            </div>
                                        </div>
                                        <div id="t_contrato_lbl" for="t_contrato_tipo" style="display: none" class="col-md-3">
                                            <div class="form-group">
                                                <label for="basicInput">Data para Saque:</label>
                                                <input type="date" class="form-control" id="dt_saque" name="dt_saque" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions" align="center">
                                        <button type="submit" name="adicionar" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> CADASTRAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sign in END -->

    <script>
        var options = {
            onKeyPress: function(cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Appear JavaScript -->
    <script src="assets/js/jquery.appear.js"></script>
    <!-- Countdown JavaScript -->
    <script src="assets/js/countdown.min.js"></script>
    <!-- Counterup JavaScript -->
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <!-- Wow JavaScript -->
    <script src="assets/js/wow.min.js"></script>
    <!-- Apexcharts JavaScript -->
    <script src="assets/js/apexcharts.js"></script>
    <!-- lottie JavaScript -->
    <script src="assets/js/lottie.js"></script>
    <!-- Slick JavaScript -->
    <script src="assets/js/slick.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="assets/js/select2.min.js"></script>
    <!-- Owl Carousel JavaScript -->
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- Magnific Popup JavaScript -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Smooth Scrollbar JavaScript -->
    <script src="assets/js/smooth-scrollbar.js"></script>
    <!-- Style Customizer -->
    <script src="assets/js/style-customizer.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="assets/js/chart-custom.js"></script>
    <!-- Custom JavaScript -->
    <script src="assets/js/custom.js"></script>


</body>

</html>

<?php
function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

switch (get_post_action('adicionar')) {

    case 'adicionar':

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
            $tipo_contrato = '2';
            $dt_saque      = $_POST['dt_saque'];
            $status        = '1';
            $nivel         = '1';
            $dt_cadastro   = date("Y-m-d");
            $id_indicacao  = $_POST['id_indicacao'];

            if ($complemento == '') {
                $complemento = '-';
            }
            if ($chave == '') {
                $chave = '-';
            }
            if ($dt_saque == '') {
                $dt_saque = '0000-00-00';
            }
            if ($tipo_contrato == '1') {
                $percentual = '1';
            }
            if ($tipo_contrato == '2') {
                $percentual = '1';
            }
            if ($tipo_contrato == '3') {
                $percentual = '7';
            }
            if ($tipo_contrato == '4') {
                $percentual = '15';
            }
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM tbl_usuarios WHERE cpf = "' . $_POST['cpf'] . '"';
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['cpf']));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        if ($data['cpf'] != $_POST['cpf']) {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tbl_usuarios (nome, rg, cpf, telefone, email, cep, endereco, numero, complemento, bairro, cidade, estado, tipo_pix, chave, tipo_contrato, percentual, dt_saque, status, nivel, id_indicacao, dt_cadastro) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome, $rg, $cpf, $telefone, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $tipo_pix, $chave, $tipo_contrato, $percentual, $dt_saque, $status, $nivel, $id_indicacao, $dt_cadastro));


            $sql2 = 'SELECT * FROM tbl_usuarios ORDER BY id DESC limit 1';
            foreach ($pdo->query($sql2) as $usuario) {

                $usuario_nome = $usuario['nome'];
                if ($usuario['tipo_contrato'] == 1) {
                    $tipo_contrato = 'DIÁRIO';
                }
                if ($usuario['tipo_contrato'] == 2) {
                    $tipo_contrato = 'MENSAL';
                }
                if ($usuario['tipo_contrato'] == 3) {
                    $tipo_contrato = 'QUINZENAL';
                }
                if ($usuario['tipo_contrato'] == 4) {
                    $tipo_contrato = 'MENSAL';
                }
            }

            require('includes/phpmailer/hdw-phpmailer.php');


            $emailAssunto  = 'Cadastro | Cripto4You';
            $emailMensagem = "
            <style type='text/css'>
            <!--
            .style1 {
                font-family: Geneva, Arial, Helvetica, sans-serif;
                color: #333333;
                font-size: 18px;
            }
            a:link {
                color: #CC9900;
                text-decoration: none;
            }
            a:visited {
                text-decoration: none;
                color: #333333;
            }
            a:hover {
                text-decoration: none;
                color: #333333;
            }
            a:active {
                text-decoration: none;
                color: #333333;
            }
            -->
            </style>
            <p align='center'>&nbsp;</p>
            <p align='center'><img src='https://cripto4you.net/assets/images/email/header_email.png' width='980' height='150'></p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center' class='style1'>Ol&aacute; {$usuario_nome},</p>
            <p align='center' class='style1'>Seu cadastro foi realizado com sucesso em nossa plataforma.</p>
            <p align='center' class='style1'>Para acesso, clique no link abaixo, entre com seu e-mail e CPF, ap&oacute;s ser&aacute; solicitado o cadastro da sua senha de acesso. N&atilde;o utilize uma senha f&aacute;cil, tente mesclar em letras (mai&uacute;sculas e min&uacute;sculas), n&uacute;meros e caracteres especiais.</p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center' class='style1'><a href='htttps://broker.cripto4you.net' target='_blank'>https://broker.cripto4you.net </a></p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center' class='style1'>Obrigado,</p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center'><img src='https://cripto4you.net/assets/images/email/footer_email.png' width='350' height='130'></p>
            <br />
<br />
";

            $id_smtp =  '1';
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM tbl_smtp';
            $q = $pdo->prepare($sql);
            $q->execute(array($id_smtp));
            $contato = $q->fetch(PDO::FETCH_ASSOC);

            $email_de        = $contato['email_de'];
            $email_para      = $usuario['email'];
            $email_para_nome = $usuario['nome'];
            $host_smtp       = $contato['host_smtp'];
            $porta_smtp      = $contato['porta_smtp'];
            $encrypt_smtp    = $contato['encrypt_smtp'];
            $email_login     = $contato['email_login'];
            $email_senha     = $contato['email_senha'];
            $emailDe          = array();

            $emailDe['from']        = $email_de;
            $emailDe['fromName']    = $contato['email_para_nome'];
            $emailDe['replyTo']     = $email;
            $emailDe['returnPath']  = $email_de;
            $emailDe['confirmTo']   = '';
            $emailPara              = array();
            $emailPara[1]['to']     = $email_para;
            $emailPara[1]['toName'] = $email_para_nome;
            // #2
            //$emailPara[2]['to']		= 'seuemail2@seudominio.com.br';
            //$emailPara[2]['toName']	= 'Seu Nome2';

            $SMTP             = array();
            $SMTP['host']     = $host_smtp;
            $SMTP['port']     = $porta_smtp;
            $SMTP['encrypt']  = $encrypt_smtp;
            $SMTP['username'] = $email_login;
            $SMTP['password'] = $email_senha;
            $SMTP['charset']  = 'utf-8';
            $SMTP['priority'] = 1;
            $SMTP['debug']    = FALSE;

            $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);

            if ($mail !== TRUE) {
                echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
                exit;
            }


            echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Cliente/Usuário cadastrado com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "https://cripto4you.net";
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
                    window.location.href = "pre-cadastro";
                  }
                }); }, 1000);</script>';
        }
        break;

    default:
}
?>