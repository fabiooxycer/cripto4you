<?php
include("includes/selects-db.php");
include("includes/scripts.php");
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
    <link href="assets/images/favicon.png" rel="icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" crossorigin="anonymous"></script>
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
        <div class="container p-0">
            <div class="row height-self-center">
                <div class="col-sm-12 align-self-center">
                    <div class="row m-0">
                        <div class="col-md-12 sign-in-page-data">
                            <div class="sign-in-from">
                                <h1 class="mb-0 text-center"><img src="assets/images/logo.png" alt="Cripto4You"></h1><br>
                                <p class="text-center text-dark">Seja bem vindo(a)!</p>
                                <div align="center">
                                    <form class="mt-4" action="senha" method="POST">
                                        <div class="form-group text-left">
                                            <label>Entre com seu e-mail</label>
                                            <input type="email" class="form-control mb-0" id="email" name="email" placeholder="Ex.: jose.silva@gmail.com" required>
                                        </div>
                                        <div class="form-group text-left">
                                            <label>Entre com seu CPF</label>
                                            <input type="text" class="form-control mb-0 cpfOuCnpj" id="cpf" name="cpf" placeholder="Ex.: 999.999.999-99" required>
                                        </div>
                                        <!-- <div class="d-inline-block w-100">
                                        <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                        </div>
                                    </div> -->
                                        <button type="submit" class="btn btn-primary w-100 mb-2">PROSSEGUIR</button>
                                        <!-- <span class="text-dark dark-color d-inline-block line-height-2">Don't have an account? <a href="#">Sign up</a></span> -->

                                    </form>
                                </div>
                            </div>
                            <br>
                            <!-- <div class="text-center">
                                <h4 class="mb-1 text-white">Top 10 Criptos</h4><br>
                                <p><iframe src="https://widget.coinlib.io/widget?type=full_v2&theme=dark&cnt=10&pref_coin_id=3315&graph=yes" width="100%" height="650" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe></p>
                            </div> -->
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