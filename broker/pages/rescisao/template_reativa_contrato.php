<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();


$cpf    = trim($_REQUEST['cpf']);
$motivo = trim($_REQUEST['motivo']);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare("SELECT * FROM tbl_cadastros WHERE cpf =  :cpf");
$stmt->execute(array(
    ':cpf'  => $cpf
));
$cadastros = $stmt->fetchAll();


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$status = "1";
$stmt = $pdo->prepare("UPDATE tbl_cadastros set status = :status WHERE cpf = :cpf");
$stmt->execute(array(
    ':status'  => $status,
    ':cpf'      => $cpf
));

/*
foreach ($cadastros as $cadastro)
{
    

    $nome  = $cadastro['nome'];
    $email = $cadastro['email'];
    $data  = date('d/m/Y');
    $motivo = $motivo;

   if ($cadastro['empresa'] == '3') {
        $empresa = 'DIGITAL INTELLIGENTIA';
        if ($cadastro['atuacao'] == '1') {
            $atuacaoAgente  = 'AEN';
            $atuacaoAgente2 = 'Agente Executivo Nacional';
        }
        if ($cadastro['atuacao'] == '2') {
            $atuacaoAgente  = 'AEM';
            $atuacaoAgente2 = 'Agente Executivo Municipal';
        }
        if ($cadastro['atuacao'] == '3') {
            $atuacaoAgente  = 'AOIO';
            $atuacaoAgente2 = 'Agente Operacional de Inteligência Originário';
        }
        if ($cadastro['atuacao'] == '4') {
            $atuacaoAgente  = 'AOI';
            $atuacaoAgente2 = 'Agente Operacional de Inteligência';
        }
        if ($cadastro['atuacao'] == '5') {
            $atuacaoAgente  = 'AEE';
            $atuacaoAgente2 = 'Agente Executivo de Expansão';
        }
        if ($cadastro['atuacao'] == '6') {
            $atuacaoAgente  = 'AEEM';
            $atuacaoAgente2 = 'Agente Executivo de Expansão Meritum';
        }
        
        enviaContratoIntelligentia($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2);
    }

    if ($cadastro['empresa'] == '4') {
        $empresa = 'DIGITALALLOCATE';
        if ($cadastro['atuacao'] == '1') {
            $atuacaoAgente  = 'AEN';
            $atuacaoAgente2 = 'Agente Executivo Nacional';
        }
        if ($cadastro['atuacao'] == '2') {
            $atuacaoAgente  = 'AEM';
            $atuacaoAgente2 = 'Agente Executivo Municipal';
        }
        if ($cadastro['atuacao'] == '3') {
            $atuacaoAgente  = 'AOIO';
            $atuacaoAgente2 = 'Agente Operacional de Inteligência Originário';
        }
        if ($cadastro['atuacao'] == '4') {
            $atuacaoAgente  = 'AOI';
            $atuacaoAgente2 = 'Agente Operacional de Inteligência';
        }
        if ($cadastro['atuacao'] == '5') {
            $atuacaoAgente  = 'AEE';
            $atuacaoAgente2 = 'Agente Executivo de Expansão';
        }
        if ($cadastro['atuacao'] == '6') {
            $atuacaoAgente  = 'AEEM';
            $atuacaoAgente2 = 'Agente Executivo de Expansão Meritum';
        }
        enviaContratoAllocate($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2);
    }

    if ($cadastro['empresa'] == '6' || $cadastro['empresa'] == '7' || $cadastro['empresa'] == '8') {
        if (!isset($passou))
        {
            $empresa = 'BANCOS - LAVVOR, INTELLIGENZ e CONSTELLATER';
            if ($cadastro['atuacao'] == '1') {
                $atuacaoAgente  = 'CFFE-AEN';
                $atuacaoAgente2 = 'Agente Executivo Nacional';
            }
            if ($cadastro['atuacao'] == '2') {
                $atuacaoAgente  = 'CFFE-AEM';
                $atuacaoAgente2 = 'Agente Executivo Municipal';
            }
            if ($cadastro['atuacao'] == '3') {
                $atuacaoAgente  = 'CFFE-AOIO';
                $atuacaoAgente2 = 'Agente Operacional de Inteligência Originário';
            }
            if ($cadastro['atuacao'] == '4') {
                $atuacaoAgente  = 'CFFE-AOI';
                $atuacaoAgente2 = 'Agente Operacional de Inteligência';
            }
            if ($cadastro['atuacao'] == '5') {
                $atuacaoAgente  = 'CFFE-AEE';
                $atuacaoAgente2 = 'Agente Executivo de Expansão';
            }
            if ($cadastro['atuacao'] == '6') {
                $atuacaoAgente  = 'CFFE-AEEM';
                $atuacaoAgente2 = 'Agente Executivo de Expansão Meritum';
            }

            enviaContratoBancos($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2);
        }
        
        $passou = true;
    }

}
*/
die(header("Location: reativa-contratos"));
