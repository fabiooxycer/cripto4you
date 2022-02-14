<?php
include("converte.php");
include("database.php");
$pdo = BancoCadastros::conectar();
include("selects-db.php");
require('phpmailer/hdw-phpmailer.php');
  
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $seo['descricao'];?>">
  <meta name="author" content="Cripto4You">
  <title><?php echo $seo['titulo'];?></title>
  <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Mascaras -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <style>
      .faturamento{
          line-height: 35px;
      }
      .faturamento.hide{
          display: inline-block;
          background-color: #f1f1f1;
          line-height: 99999999px;
          height: 27px;
          overflow: hidden;
      }
      .botao-faturamento{
        cursor: pointer;
      }
  </style>
</head>

<?php include("scripts.php"); ?>

<body id="page-top">

  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
        <div class="sidebar-brand-text mx-3"><img src="assets/img/logo.png" width="100%" alt="<?php echo $seo['titulo'];?>"></div>
      </a>

      <?php
      // CHAMA MENU E O HEADER CONTENDO PERFIL, NOTIFICAÇÕES E BUSCA
      include('menu.php');
      include('header_perfil.php');
      ?>