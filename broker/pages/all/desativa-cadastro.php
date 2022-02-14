<?php
include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();

if (!isset($_SESSION)) session_start();

$status = 1;

if (!isset($_SESSION['UsuarioID']) && ($_SESSION['UsuarioStatus'] > $status) && ($_SESSION['UsuarioBancos'] == 'NÃO')) {
  echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
  exit;
}



$id = null;
if (!empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$status = "2";
$sql = "UPDATE tbl_cadastros set status = ? WHERE id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($status, $id));
echo '<script>setTimeout(function () { 
        swal({
          title: "Parabéns!",
          text: "Cadastro desativado com sucesso!",
          type: "success",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "dashboard";
          }
        }); }, 1000);</script>';
BancoCadastros::desconectar();
