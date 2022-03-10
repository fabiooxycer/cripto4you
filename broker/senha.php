<?php
include("includes/selects-db.php");
include('includes/scripts.php');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$cpf   = isset($_POST['cpf']) ? $_POST['cpf'] : '';
if (empty($email) || empty($cpf)) {
    echo "<script>alert('OPS! INFORME O E-MAIL E CPF.');location.href='entrar';</script>";
    exit;
}
?>

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
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <script>
        var check = function() {
            if (document.getElementById('senha').value ==
                document.getElementById('senha2').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'AS SENHAS NÃO SÃO IGUAIS';
                document.getElementById('cadSenha').disabled = false;
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'AS SENHAS SÃO IGUAIS';
                document.getElementById('cadSenha').disabled = true;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#senha').on('input', function() {
                $('#acessar').prop('disabled', $(this).val().length < 5);
            });
        });
    </script>
</head>

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

        <?php
        $pdo = BancoCadastros::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM tbl_usuarios WHERE cpf = :cpf";

        $q = $pdo->prepare($sql);
        $q->bindParam(":cpf", $cpf, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);

        if ($data['senha'] != '' && $data['email'] == $email && $data['cpf'] == $cpf) {
        ?>
            <div class="container p-0">
                <div class="row no-gutters height-self-center">
                    <div class="col-sm-12 align-self-center">
                        <div class="row m-0">
                            <div class="col-md-12 bg-white sign-in-page-data">
                                <div class="sign-in-from">
                                    <h1 class="mb-0 text-center"><img src="images/logo.png" alt="Cripto4You"></h1><br>
                                    <p class="text-center text-dark">Olá <strong><?php echo $data['nome']; ?></strong>, entre com sua senha de acesso!</p>
                                    <form class="mt-4" action="valida" method="POST">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control mb-0" id="email" name="email" value="<?php echo $email; ?>" readonly>
                                            <input type="hidden" class="form-control mb-0" id="cpf" name="cpf" value="<?php echo $cpf; ?>" readonly>
                                            <input type="password" class="form-control mb-0" id="senha" name="senha" placeholder="Ex.: vOsrM0n&bIK&">
                                        </div>
                                        <div class="sign-info text-center">
                                            <button type="submit" class="btn btn-primary d-block w-100 mb-2" id="acessar" >ACESSAR</button>
                                            <button type="button" class="btn btn-secondary btn-user btn-block" style="background-color: #222222" onClick="history.go(-1)">
                                                <i class="icon-action-undo"></i> VOLTAR
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        if ($data['senha'] == '') { ?>
            <div class="container p-0">
                <div class="row no-gutters height-self-center">
                    <div class="col-sm-12 align-self-center">
                        <div class="row m-0">
                            <div class="col-md-12 bg-white sign-in-page-data">
                                <div class="sign-in-from">
                                    <h1 class="mb-0 text-center"><img src="images/logo.png" alt="Cripto4You"></h1><br>
                                    <p class="text-center text-dark">Atenção!</p>
                                    <p>
                                        <font size="3">Olá <strong><?php echo $data['nome']; ?></strong>, você não possui uma senha de acesso. Vamos definir?</font>
                                    </p>
                                    <form class="mt-4" action="senha" method="POST">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control mb-0" id="email" name="email" value="<?php echo $email; ?>" readonly>
                                            <input type="hidden" class="form-control mb-0" id="cpf" name="cpf" value="<?php echo $cpf; ?>" readonly>
                                            <input type="password" class="form-control mb-0" id="senha" name="senha" onkeyup='check();' placeholder="Sua senha">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control mb-0" id="senha2" name="senha2" onkeyup='check();' placeholder="Confirme sua senha" required>
                                        </div>
                                        <p align="right">
                                            <font size="1"><strong><span id='message'></span></strong></font>
                                        </p>
                                        <div class="sign-info text-center">
                                            <button type="submit" class="btn btn-primary d-block w-100 mb-2" name="cadastrar-senha" id="cadSenha">CADASTRAR</button>
                                            <button type="button" class="btn btn-secondary btn-user btn-block" style="background-color: #222222" onClick="history.go(-1)">
                                                <i class="icon-action-undo"></i> VOLTAR
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }

        if ($data['cpf'] != $cpf && $data['email'] != $email) {
            echo "<script>alert('OPS! DESCULPE, VOCÊ AINDA NÃO POSSUI UM CADASTRO VALIDADO EM NOSSA PLATAFORMA.');location.href='entrar';</script>";
        }
        if ($data['cpf'] != $cpf || $data['email'] != $email) {
            echo "<script>alert('OPS! DESCULPE, VOCÊ AINDA NÃO POSSUI UM CADASTRO VALIDADO EM NOSSA PLATAFORMA.');location.href='entrar';</script>";
        } ?>

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
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Appear JavaScript -->
    <script src="js/jquery.appear.js"></script>
    <!-- Countdown JavaScript -->
    <script src="js/countdown.min.js"></script>
    <!-- Counterup JavaScript -->
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <!-- Wow JavaScript -->
    <script src="js/wow.min.js"></script>
    <!-- Apexcharts JavaScript -->
    <script src="js/apexcharts.js"></script>
    <!-- lottie JavaScript -->
    <script src="js/lottie.js"></script>
    <!-- Slick JavaScript -->
    <script src="js/slick.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="js/select2.min.js"></script>
    <!-- Owl Carousel JavaScript -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- Magnific Popup JavaScript -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- Smooth Scrollbar JavaScript -->
    <script src="js/smooth-scrollbar.js"></script>
    <!-- Style Customizer -->
    <script src="js/style-customizer.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="js/chart-custom.js"></script>
    <!-- Custom JavaScript -->
    <script src="js/custom.js"></script>


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

// Verifica qual botao foi clicado
switch (get_post_action('cadastrar-senha')) {

    case 'cadastrar-senha':

        if (!empty($_POST)) {

            $email = $_POST['email'];
            $cpf   = $_POST['cpf'];
            $senha = $_POST['senha'];

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tbl_usuarios set senha = ? WHERE cpf = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($senha, $cpf));
            echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Senha definida com sucesso. Agora vamos efetuar o login novamente!",
                  type: "success",
                  confirmButtonText: "OK"
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "entrar";
                  }
                }); }, 1000);</script>';
        }

        break;

    default:
}

?>