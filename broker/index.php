<?php include('includes/scripts.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Digital Intelligentia">
    <title>Plataforma de Gestão Broker | Cripto4You</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').on('input', function() {
                $('#prosseguir').prop('disabled', $(this).val().length < 8);
            });
        });
    </script>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="assets/img/logo-color-big.png" width="100%"><br /><br />
                                    </div>
                                    <form class="user" action="senha" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" onChange="this.value=this.value.toLowerCase()" placeholder="INFORME SEU E-MAIL" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="cpf" name="cpf" placeholder="INFORME SEU CPF" required>
                                        </div>
                                        <!--
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        -->
                                        <button type="submit" id="prosseguir" class="btn btn-primary btn-user btn-block" disabled>
                                            PROSSEGUIR
                                        </button>
                                        <hr>
                                    </form>
                                    <!-- <div class="text-center">
                                        <a class="small" href="recupera-codigo">Recuperar meu código!</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>