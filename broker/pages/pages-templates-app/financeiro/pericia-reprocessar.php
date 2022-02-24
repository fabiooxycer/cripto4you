<?php
session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
  echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
  exit;
}

include('../../includes/header.php');

$idPericia  = trim($_REQUEST['id']);
require_once("../../includes/databaseApps.php");
$pdo = BancoApps::conectar();


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pericia_status    = 'pagamento_confirmado';

$sql = "UPDATE tbl_cadastro_pericias set pericia_status = ? WHERE id = ?";
$q = $pdo->prepare($sql);

if ($q->execute(array($pericia_status, $idPericia))) {
  echo '<script>setTimeout(function () { 
    swal({
      title: "Parabéns!",
      text: "Iniciado reprocessamento da perícia técnica com sucesso!",
      type: "success",
      confirmButtonText: "OK"
    },
    function(isConfirm){
      if (isConfirm) {
        window.location.href = "financeiro-pericias";
      }
    }); }, 1000);</script>';
} else {
  echo 0;
}
