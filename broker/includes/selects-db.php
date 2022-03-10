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

// ------------------------------------------------------------------------
// Cálculo Dashboard Administrador
// ------------------------------------------------------------------------
// TOTAL DE CLIENTES ATIVOS
$sql = "SELECT count(*) as t FROM tbl_usuarios WHERE status = 1 AND id != 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalUsuarios = $sql['t'];

//LUCRO GERADO TOTAL
$sql = "SELECT sum(valor) as t FROM tbl_investimentos WHERE confirmado = 1 AND reinvestir = 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$lucroGerado = $sql['t'];

// TOTAL DE RETIRADAS
$sql = "SELECT sum(valor) as t FROM tbl_investimentos WHERE tipo = 2 AND confirmado = 1 AND reinvestir = 2";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalRetiradas = $sql['t'];

// SALDO ATUAL INVESTIDO
$sql = "SELECT sum(valor) as t FROM tbl_investimentos WHERE tipo IN ('1,3') AND confirmado = 1";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalInvestido = $sql['t'];

// CÁLCULO ATUAL DO INVESTIMENTO TOTAL
$saldoAtualInvestido = $totalInvestido + $lucroGerado - $totalRetiradas;

// ------------------------------------------------------------------------
// Cálculo Dashboard Usuários
// ------------------------------------------------------------------------
// SQL RETIRADAS
$sql = 'SELECT sum(valor) as t FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 2 AND confirmado = 1 AND reinvestir = 2';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalRetiradasUsuarios = $sql['t'];

// SQL LUCRO
$sql = 'SELECT sum(valor) as t FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND confirmado = 1 AND reinvestir = 1';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$lucroGeradoUsuarios = $sql['t'];

// SQL INVESTIMENTO
$sql = 'SELECT sum(valor) as t FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 1 AND confirmado = 1';
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$totalInvestidoUsuarios = $sql['t'];

// CÁLCULO DO INVESTIMENTO ATUAL
$somaInvestimentoLucroUsuarios = $totalInvestidoUsuarios + $lucroGeradoUsuarios;
$totalAporteUsuarios = $somaInvestimentoLucroUsuarios - $totalRetiradasUsuarios;

// ------------------------------------------------------------------------
// 
// ------------------------------------------------------------------------