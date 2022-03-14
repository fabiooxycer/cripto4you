<?php

header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'database.php';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$cpf   = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
if (empty($email) || empty($cpf) || empty($senha)) {
    echo "<script>alert('OPS! INFORME O E-MAIL, CPF E SENHA.');location.href='entrar';</script>";
    exit;
}

$pdo = BancoCadastros::conectar();
$sql = "SELECT * FROM tbl_usuarios WHERE email = :email AND cpf = :cpf AND senha = :senha AND status = 1 LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':senha', $senha);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($users) != 1) {
    echo "<script>alert('OPS! E-MAIL, CPF OU SENHA INVÁLIDOS!');location.href='entrar';</script>";
    exit;
} else {

    $resultado = $users[0];

    if (!isset($_SESSION)) session_start();
    $_SESSION['UsuarioID']             = $resultado['id'];
    $_SESSION['UsuarioNome']           = $resultado['nome'];
    $_SESSION['UsuarioEmail']          = $resultado['email'];
    $_SESSION['UsuarioTelefone']       = $resultado['telefone'];
    $_SESSION['UsuarioRG']             = $resultado['rg'];
    $_SESSION['UsuarioCPF']            = $resultado['cpf'];
    $_SESSION['UsuarioStatus']         = $resultado['status'];
    $_SESSION['UsuarioNivel']          = $resultado['nivel'];
    $_SESSION['UsuarioCadastro']       = $resultado['dt_cadastro'];
    $_SESSION['UsuarioTipoContrato']   = $resultado['tipo_contrato'];
    $_SESSION['UsuarioContrato']       = $resultado['contrato_aceito'];
    $_SESSION['UsuarioPercentual']     = $resultado['percentual'];

    header("Location: dashboard");
    exit;
}
