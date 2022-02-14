<?php
// ------------------------------------------------------------------------
// Função: Realiza SELECTS no banco de dados para exibição das informações
// ------------------------------------------------------------------------

// SEO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_seo';

foreach ($pdo->query($sql) as $seo) {
}
?>