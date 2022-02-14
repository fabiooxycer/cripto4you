<?php
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();
$cod_estado = $_GET['cod_estado'];

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare(
    "SELECT * 
    FROM tbl_municipios_ibge
    WHERE estado_codigo_ibge = :cod_estado
    ORDER BY municipio ASC");
$stmt->execute(array(
    ":cod_estado" => $cod_estado
));
$cidades = $stmt->fetchAll();


echo( json_encode( $cidades ) );

?>