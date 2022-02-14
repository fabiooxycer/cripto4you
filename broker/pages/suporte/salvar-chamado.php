<?php

  session_start();

  $nivel = 1;

  if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
      exit;
  } 

  require_once("../../includes/database.php");
  $pdo = BancoCadastros::conectar();

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $nomeArquivo = '';
  /* Upload anexo */
  if($_FILES['anexoChamado']['name']){
    $uploaddir = '/home/digitalinteluser/public_html/teste/assets/img/anexo-chamado/';
    
    $fileExtension = explode('.',$_FILES['anexoChamado']['name']);
    $fileExtension = strtolower($fileExtension[1]);
  
    $nomeArquivo = uniqid() . '.' . $fileExtension;

    if($fileExtension=='jpg' or $fileExtension=='jpeg' or $fileExtension=='png'){
      move_uploaded_file($_FILES['anexoChamado']['tmp_name'], $uploaddir . $nomeArquivo);
    }else{
      echo "formatoinvalido";
      exit();
    }
  
  }
  
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Dados recebidos do form
  $dt_criacao = date('Y-m-d');
  $hr_criacao = date('H:m:s');
  $id_departamento = trim($_REQUEST['departamentoChamado']);
  $assunto = trim($_REQUEST['assuntoChamado']);
  $descricao = trim($_REQUEST['descricaoChamado']);

  $nomeCliente = trim($_REQUEST['nomeCliente']);
  $cpfCliente = trim($_REQUEST['cpfCliente']);
  $telefoneCliente = trim($_REQUEST['telefoneCliente']);
  $emailCliente = trim($_REQUEST['emailCliente']);

  $ticket_status = 0;          

  $sql = "INSERT INTO tbl_suporte (dt_criacao, hr_criacao, id_departamento, assunto, nome, cpf, email, telefone, descricao, anexo, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $q = $pdo->prepare($sql);
  
  if($q->execute(array($dt_criacao, $hr_criacao, $id_departamento, $assunto, $nomeCliente, $cpfCliente, $emailCliente, $telefoneCliente, $descricao, $nomeArquivo, $ticket_status))){
    echo 1;
  }else{
    echo 0;
  }  

?>