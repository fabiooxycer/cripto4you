<?php

  session_start();

  date_default_timezone_set('America/Sao_Paulo');

  $nivel = 1;

  if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
      exit;
  }

  $idTicktet = trim($_REQUEST['ticket']);
  $idUsuario = $_SESSION['UsuarioID'];

  require_once("../../includes/database.php");
  $pdo = BancoCadastros::conectar();


  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $ticket_status = 1;

  $sql = "UPDATE tbl_suporte set `status` = ?, atendente = ? WHERE id = ?";
  $q = $pdo->prepare($sql);
  $query1 = $q->execute(array($ticket_status, $idUsuario, $idTicktet));

  $sql2 = "INSERT INTO tbl_suporte_historico (dt_criacao, hr_criacao, id_suporte, id_atendente, descricao) VALUES (?, ?, ?, ?, ?)";
  $q2 = $pdo->prepare($sql2);  
  $query2 = $q2->execute(array(date('Y-m-d'), date('H:i:s'), $idTicktet, $idUsuario, 'Atendimento iniciado.'));

  if($query1 and $query2){
    echo 1;
  }else{
    echo 0;
  }

?>