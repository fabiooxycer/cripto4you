<?php
// Chama Database Connect / Conversor de Data / Selects no BD
include("selects-db.php");
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
        })(window, document, 'script', 'dataLayer', '<?php echo $seo['tag_manager']; ?>');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $seo['analytics']; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '<?php echo $seo['analytics']; ?>');
    </script>
    <link href="assets/css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- Full calendar -->
    <link href='assets/fullcalendar/core/main.css' rel='stylesheet' />
    <link href='assets/fullcalendar/daygrid/main.css' rel='stylesheet' />
    <link href='assets/fullcalendar/timegrid/main.css' rel='stylesheet' />
    <link href='assets/fullcalendar/list/main.css' rel='stylesheet' />

    <link rel="stylesheet" href="assets/css/flatpickr.min.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- WYSIWYG Editor css -->
    <link href="assets/wysiwyag/richtext.css" rel="stylesheet" />

    <!--Summernote css-->
    <link rel="stylesheet" href="assets/summernote/summernote-bs4.css">

    <style>
        .faturamento {
            line-height: 35px;
        }

        .faturamento.hide {
            display: inline-block;
            background-color: #1C1C24;
            line-height: 99999999px;
            height: 27px;
            overflow: hidden;
        }

        .botao-faturamento {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $seo['tag_manager']; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Wrapper Start -->
    <div class="wrapper">