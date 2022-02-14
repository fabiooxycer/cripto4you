<?php
// Chama Database Connect / Conversor de Data / Selects no BD
include("selects-db.php");
?>

<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="<?php echo $seo['descricao'];?>">
    <link href="assets/images/favicon/favicon.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:300i,400,400i,500,500i,600,600i,700%7CRoboto:300i,400,400i,500,500i,700" rel="stylesheet" type="text/css">
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/revolution/css/settings.css">
    <link rel="stylesheet" type="text/css" href="assets/revolution/css/layers.css">
    <link rel="stylesheet" type="text/css" href="assets/revolution/css/navigation.css">
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <title><?php echo $seo['titulo'];?></title>
    <meta name="description" content="<?php echo $seo['descricao'];?>" />
    <link rel="icon" type="image/x-icon" href="assets/images/seo/<?php echo $seo['icone'];?>">
    <link rel="canonical" href="https://<?php echo $seo['dominio'];?>" />
    <meta name="generator" content="<?php echo $seo['titulo'];?>" />
    <meta property="og:url" content="https://cripto4you.net" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo $seo['titulo'];?>" />
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:title" content="<?php echo $seo['titulo'];?>" />
    <meta property="og:description" content="<?php echo $seo['descricao'];?>" />
    <meta property="og:image" content="assets/images/seo/avatar.jpg" />
    <meta name="description" content="<?php echo $seo['descricao'];?>">
    <meta name="keywords" content="<?php echo $seo['keywords'];?>" />
    <meta name="robots" content="index, follow" />

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '<?php echo $seo['tag_manager'];?>');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $seo['analytics'];?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '<?php echo $seo['analytics'];?>');
    </script>

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $seo['tag_manager'];?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="preloader">
        <div class="signal"></div>
    </div>
    <div id="wrapper" class="wrapper clearfix">
        <header id="navbar-spy" class="header header-1 header-transparent header-bordered header-fixed">
            <nav id="primary-menu" class="navbar navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="logo" href="./inicio">
                            <img class="logo-light" src="assets/images/logo/logo-light.png" alt="Cripto4You">
                            <img class="logo-dark" src="assets/images/logo/logo-dark.png" alt="Cripto4You">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse pull-right" id="navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left nav-pos-right">
                            <li><a href="./inicio" class="menu-item">Início</a></li>
                            <li><a href="./sobre" class="menu-item">Sobre</a></li>
                            <li><a href="./#servicos" class="menu-item">Serviços</a></li>
                            <li><a href="./noticias" class="menu-item">Notícias</a></li>
                            <li><a href="./#contato" class="menu-item">Contato</a></li>
                            <div class="module module-consultation pull-left">
                                <a href="./#quero-investir" class="btn btn--primary btn--bordered btn--rounded">Quero
                                    Investir</a>
                            </div>
                            <li><a href="https://broker.cripto4you.net/" class="menu-item">Restrito</a></li>
                            <!-- <div class="module module-signup pull-left">
                                <a class="btn-popup" data-toggle="modal" data-target="#signupModule"><i class="fa fa-lock"></i></a>
                                <div class="modal fade signup-popup" tabindex="-1" role="dialog" id="signupModule">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="signup-form-container text-center">
                                                        <form id="signupPopupForm" action="senha" method="POST" class="signupform">
                                                            <div align="center">
                                                                <img src="assets/images/logo/logo-dark.png" alt="Cripto4You">
                                                            </div>
                                                            <hr>
                                                            <input type="email" class="form-control" name="email" id="email" placeholder="Seu E-mail" required>
                                                            <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Seu CPF" required>
                                                            <input type="password" class="form-control" name="senha" id="senha" placeholder="Sua Senha" required>
                                                            <input type="submit" value="Acessar" name="submit" class="btn btn--primary btn--block">
                                                        </form>
                                                        <div class="signin">
                                                            Ainda não é nosso cliente?<br>
                                                            <a href="#">Quero Investir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                    </div>
                </div>
            </nav>
        </header>