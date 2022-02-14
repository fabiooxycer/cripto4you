<?php

  session_start();

  $nivel = 1;

  if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
      exit;
  }

  $idTicktet = trim($_REQUEST['ticket']);
  $atendente = trim($_REQUEST['atendente']);

  require_once("../../includes/database.php");
  $pdo = BancoCadastros::conectar();


  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $ticket_status = 1;

  $sql = "UPDATE tbl_suporte set `status` = ?, atendente = ? WHERE id = ?";
  $q = $pdo->prepare($sql);

  if($q->execute(array($ticket_status, $atendente, $idTicktet))){
    echo 1;
  }else{
    echo 0;
  }

?>