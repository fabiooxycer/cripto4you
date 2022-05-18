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
$sql = 'SELECT * FROM tbl_seo WHERE id = "' . $id_selects . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id_selects));
$seo = $q->fetch(PDO::FETCH_ASSOC);

// CONTATO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_contato WHERE id = "' . $id_selects . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id_selects));
$contato = $q->fetch(PDO::FETCH_ASSOC);

// SMTP
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_smtp WHERE id = "' . $id_selects . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id_selects));
$smtp = $q->fetch(PDO::FETCH_ASSOC);

// CONFIGURAÇÕES
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_configuracoes WHERE id = "' . $id_selects . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id_selects));
$configuracoes = $q->fetch(PDO::FETCH_ASSOC);


// ------------------------------------------------------------------------
// Cálculo Dashboard Administrador
// ------------------------------------------------------------------------
// TOTAL DE CLIENTES ATIVOS
$sql = "SELECT count(*) as t FROM tbl_usuarios WHERE status = 1 AND id != 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalUsuarios = $sql['t'];

// TOTAL DE TRANSAÇÕES
$sql = "SELECT count(*) as t FROM tbl_investimentos";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalTransacoes = $sql['t'];

//LUCRO GERADO TOTAL
$sql = "SELECT sum(valor) as t FROM tbl_investimentos WHERE tipo = 3 AND confirmado = 1 AND reinvestir = 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$lucroGerado = $sql['t'];

// TOTAL DE RETIRADAS
$sql = "SELECT sum(valor) as t FROM tbl_investimentos WHERE tipo = 2 AND confirmado = 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalRetiradas = $sql['t'];

// SALDO APORTE
$sql = "SELECT sum(valor) as t FROM tbl_investimentos WHERE tipo = 1 AND confirmado = 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalAporteInvestido = $sql['t'];

// CÁLCULO ATUAL DO INVESTIMENTO TOTAL
$totalAporteLucro = $totalAporteInvestido + $lucroGerado - $totalRetiradas;

// ------------------------------------------------------------------------
// Cálculo Dashboard Usuários
// ------------------------------------------------------------------------
// SQL RETIRADAS
$sql = 'SELECT sum(valor) as t FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 2 AND confirmado = 1';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalRetiradasUsuarios = $sql['t'];

// SQL LUCRO
$sql = 'SELECT sum(valor) as t FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 3 AND confirmado = 1 AND reinvestir = 1';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$lucroGeradoUsuarios = $sql['t'];

// APORTE
$sql = 'SELECT sum(valor) as t FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 1 AND confirmado = 1';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalAporteUsuarios = $sql['t'];

// CÁLCULO APORTE + LUCRO REINVESTIDO
$totalInvestido = $totalAporteUsuarios + $lucroGeradoUsuarios - $totalRetiradasUsuarios;

// ------------------------------------------------------------------------
// 
// ------------------------------------------------------------------------