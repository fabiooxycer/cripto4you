<?php
session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

$pericia      = trim($_REQUEST['pericia']);
$motivo       = trim($_REQUEST['motivo']);
$usuario      = trim($_REQUEST['usuario']);
$dt_liberacao = trim($_REQUEST['dtLiberacao']);

// Formatar data para gravar no banco
$data = explode('/', $dt_liberacao);
$dt_liberacao = $data[2].'-'.$data[1].'-'.$data[0]; 

require_once("../../includes/databaseApps.php");
$pdo = BancoApps::conectar();


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pericia_status    = 'pagamento_confirmado';
$liberacao_interna = '1';

$sql = "UPDATE tbl_cadastro_pericias set pericia_status = ?, liberacao_interna = ?, motivo_liberacao = ?, usuario_liberou = ?, data_liberacao = ? WHERE id = ?";
$q = $pdo->prepare($sql);

if($q->execute(array($pericia_status, $liberacao_interna, $motivo, $usuario, $dt_liberacao, $pericia))){
  echo 1;
}else{
  echo 0;
}

?>