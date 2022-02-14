<?php

  session_start();

  $nivel = 1;

  if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
      exit;
  }

  $departamento = trim($_REQUEST['departamento']);

  require_once("../../includes/database.php");
  $pdo = BancoCadastros::conectar();


  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql1 = "SELECT * FROM tbl_suporte_departamentos WHERE departamento = '$departamento'";
  $q1 = $pdo->prepare($sql1);
  $q1->execute();
  $data1 = $q1->fetch(PDO::FETCH_ASSOC);
 
  $sql = "SELECT * FROM tbl_usuarios WHERE departamento = '".$data1['id']."'";
  $q = $pdo->prepare($sql);
  $q->execute();
  $data = $q->fetchAll(PDO::FETCH_ASSOC);

  $atendentes = '<option value="">Selecione um atendente</option>';
  foreach($data as $key => $val){
    $atendentes .= "<option value='$val[id]'>$val[nome]</option>";
  }

  echo $atendentes;

?>