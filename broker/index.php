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
            <div class="row no-gutters height-self-center">
                <div class="col-sm-12 align-self-center">
                    <div class="row m-0">
                        <div class="col-md-12 bg-white sign-in-page-data">
                            <div class="sign-in-from">
                                <h1 class="mb-0 text-center"><img src="images/logo.png" alt="Cripto4You"></h1><br>
                                <p class="text-center text-dark">Seja bem vindo(a)!</p>
                                <form class="mt-4" action="senha" method="POST">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Entre com seu e-mail</label>
                                        <input type="email" class="form-control mb-0" id="email" name="email" placeholder="Ex.: jose.silva@gmail.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Entre com seu CPF</label>
                                        <input type="text" class="form-control mb-0 cpfOuCnpj" id="cpf" name="cpf" placeholder="Ex.: 999.999.999-99">
                                    </div>
                                    <!-- <div class="d-inline-block w-100">
                                        <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                        </div>
                                    </div> -->
                                    <div class="sign-info text-center">
                                        <button type="submit" class="btn btn-primary d-block w-100 mb-2">PROSSEGUIR</button>
                                        <!-- <span class="text-dark dark-color d-inline-block line-height-2">Don't have an account? <a href="#">Sign up</a></span> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- <div class="col-md-7 text-center sign-in-page-image">
                            <div class="sign-in-detail text-white">
                                <a class="sign-in-logo mb-5" href="#"><img src="images/logo-full.png" class="img-fluid" alt="logo"></a>
                                <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                                    <div class="item">
                                        <img src="images/login/1.png" class="img-fluid mb-4" alt="logo">
                                        <h4 class="mb-1 text-white">Find new friends</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                    </div>
                                    <div class="item">
                                        <img src="images/login/1.png" class="img-fluid mb-4" alt="logo">
                                        <h4 class="mb-1 text-white">Connect with the world</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                    </div>
                                    <div class="item">
                                        <img src="images/login/1.png" class="img-fluid mb-4" alt="logo">
                                        <h4 class="mb-1 text-white">Create new events</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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