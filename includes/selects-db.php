<?php
// ----------------------------------------------------------------------
// Company: CREEATOR SOFTWARE DESIGN
// Site: https://www.creeator.com.br | Email: contato@creeator.com.br
// Phone and WhatsApp: +55 41 9 9282-3979
// Developer: Fábio Vieira
// Email: fabio.vieira@creeator.com.br
// ----------------------------------------------------------------------

// Chama conexão com o banco de dados
include("converte.php");
include("database.php");
$pdo = BancoCadastros::conectar();

// ------------------------------------------------------------------------
// Função: Realiza SELECTS no banco de dados para exibição das informações
// ------------------------------------------------------------------------

$id_selects = '1';

// SEO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_seo';
$q = $pdo->prepare($sql);
$q->execute(array($id_selects));
$seo = $q->fetch(PDO::FETCH_ASSOC);

// CONTATO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_contato';
$q = $pdo->prepare($sql);
$q->execute(array($id_selects));
$contato = $q->fetch(PDO::FETCH_ASSOC);