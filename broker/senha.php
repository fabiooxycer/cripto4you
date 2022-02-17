<?php include('includes/scripts.php');

require 'includes/database.php';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$cpf   = isset($_POST['cpf']) ? $_POST['cpf'] : '';
if (empty($email) || empty($cpf)) {
    echo "<script>alert('OPS! INFORME O E-MAIL E CPF.');location.href='entrar';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Cripto4You">
    <title>Plataforma de Gestão Broker | Cripto4You</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
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

<body class="bg-gradient-primary">

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

        <!-- Exibe se o usuário já tem senha cadastrada -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <img src="assets/img/logo-color-big.png" width="50%"><br /><br />
                                            <p>
                                                <font size="3">Olá <strong><?php echo $data['nome']; ?></strong>, entre com sua senha de acesso!</font>
                                            </p>
                                        </div>
                                        <form class="user" action="valida" method="post">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-user" id="email" name="email" value="<?php echo $email; ?>" readonly>
                                                <input type="hidden" class="form-control form-control-user" id="cpf" name="cpf" value="<?php echo $cpf; ?>" readonly>
                                                <input type="password" class="form-control form-control-user" id="senha" name="senha" placeholder="ENTRE COM SUA SENHA" required>
                                            </div>
                                            <button type="submit" id="acessar" class="btn btn-primary btn-user btn-block" disabled>
                                                ACESSAR
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-user btn-block" style="background-color: #222222" onClick="history.go(-1)">
                                                <i class="icon-action-undo"></i> VOLTAR
                                            </button>
                                            <hr>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php }
    if ($data['senha'] == '') { ?>

        <!-- Exibe se o usuário já tem senha cadastrada -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <img src="assets/img/logo-color-big.png" width="50%"><br /><br />
                                            <h4><strong>Atenção!</strong></h4>
                                            <p>
                                                <font size="3">Olá <strong><?php echo $data['nome']; ?></strong>, você não possui uma senha de acesso. Vamos definir?</font>
                                            </p>
                                        </div>
                                        <form class="user" action="senha" method="post" name="f1">
                                            <input type="hidden" class="form-control form-control-user" id="email" name="email" value="<?php echo $email; ?>" readonly>
                                            <input type="hidden" class="form-control form-control-user" id="cpf" name="cpf" value="<?php echo $cpf; ?>" readonly>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="senha" name="senha" onkeyup='check();' placeholder="CADASTRE SUA SENHA" required><br>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-user" id="senha2" name="senha2" onkeyup='check();' placeholder="CONFIRME SUA SENHA" required> <br>
                                                    <div align="right">
                                                        <font size="1"><strong><span id='message'></span></strong></font>
                                                    </div>
                                                </div>
                                                <button type="submit" name="cadastrar-senha" id="cadSenha" class="btn btn-primary btn-user btn-block" disabled>
                                                    CADASTRAR
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-user btn-block" style="background-color: #222222" onClick="history.go(-1)">
                                                    <i class="icon-action-undo"></i> VOLTAR
                                                </button>
                                                <hr>
                                        </form>
                                    </div>
                                </div>
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

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
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