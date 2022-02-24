<?php

  session_start();

  $nivel = 1;

  if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
      exit;
  }

  require_once("../../includes/databaseApps.php");
  $pdo = BancoApps::conectar();


  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $cpf = trim($_REQUEST['cpf']);
  $cpf = str_replace('.', '', str_replace('-', '', $cpf));

  $sql = "SELECT * FROM tbl_usuarios WHERE cpf = '$cpf'";
  $q = $pdo->prepare($sql);
  $q->execute();
  $data = $q->fetch(PDO::FETCH_ASSOC);  

  if($data!=NULL){
    $dados_cliente = array('nome' => $data['nome'], 'telefone' => $data['telefone1'], 'email' => $data['email']);
    echo json_encode($dados_cliente);  
  }else{
    echo 'erro';
  }

?>