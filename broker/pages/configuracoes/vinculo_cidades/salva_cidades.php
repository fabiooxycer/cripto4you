<?php

if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

$id_agente = filter_input(INPUT_POST, 'id_agente', FILTER_SANITIZE_ENCODED);


require_once("../../../includes/database.php");
$pdo = BancoCadastros::conectar();

foreach ($_POST['cidades'] as $cidade)
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = [
        'id_agente' => $id_agente,
        'municipio_codigo_ibge' => $cidade,
        
    ];
    $sql = "INSERT INTO tbl_cadastros_cidades (id_agente, municipio_codigo_ibge) VALUES (:id_agente, :municipio_codigo_ibge)";
    $stmt= $pdo->prepare($sql);
    $stmt->execute($data);


}

die(header("Location: ../../../vincular-agentes"));



?>