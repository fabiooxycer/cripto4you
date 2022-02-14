<?php

  session_start();

  date_default_timezone_set('America/Sao_Paulo');

  $nivel = 1;

  if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
      exit;
  }

  require_once("../../includes/database.php");
  $pdo = BancoCadastros::conectar();

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dt_criacao = date('Y-m-d');
  $hr_criacao = date('H:i:s');
  $idChamado = trim($_REQUEST['idChamado']);
  $idAtendente = trim($_REQUEST['idAtendente']);
  $resposta = trim($_REQUEST['resposta']);

  $sql = "INSERT INTO tbl_suporte_historico (dt_criacao, hr_criacao, id_suporte, id_atendente, descricao) VALUES (?, ?, ?, ?, ?)";
  $q = $pdo->prepare($sql);
  $query1 = $q->execute(array($dt_criacao, $hr_criacao, $idChamado, $idAtendente, $resposta));

  $sql2 = "UPDATE tbl_suporte SET `status`=2 WHERE id=$idChamado";
  $q2 = $pdo->prepare($sql2);
  $query2 = $q2->execute();
  
  if($query1 and $query2){
    echo 1;
  }else{
    echo 0;
  }        
?>