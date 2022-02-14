<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once("../../includes/database.php");
require_once("functions.php");
$pdo = BancoCadastros::conectar();


$cpf       = trim($_REQUEST['cpf']);
$motivo    = trim($_REQUEST['motivo']);
$clausulas = trim($_REQUEST['clausulas']);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare("SELECT * FROM tbl_cadastros WHERE cpf =  :cpf");
$stmt->execute(array(
    ':cpf'  => $cpf
));
$cadastros = $stmt->fetchAll();


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$status = "2";
$stmt = $pdo->prepare("UPDATE tbl_cadastros set status = :status WHERE cpf = :cpf");
$stmt->execute(array(
    ':status'  => $status,
    ':cpf'      => $cpf
));

foreach ($cadastros as $cadastro) {


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

        // MÊS DO ANO
        $mes_ano = date('m');
        if ($mes_ano == '01') {
            $mes = 'janeiro';
        }
        if ($mes_ano == '02') {
            $mes = 'fevereiro';
        }
        if ($mes_ano == '03') {
            $mes = 'março';
        }
        if ($mes_ano == '04') {
            $mes = 'abril';
        }
        if ($mes_ano == '05') {
            $mes = 'maio';
        }
        if ($mes_ano == '06') {
            $mes = 'junho';
        }
        if ($mes_ano == '07') {
            $mes = 'julho';
        }
        if ($mes_ano == '08') {
            $mes = 'agosto';
        }
        if ($mes_ano == '09') {
            $mes = 'setembro';
        }
        if ($mes_ano == '10') {
            $mes = 'outubro';
        }
        if ($mes_ano == '11') {
            $mes = 'novembro';
        }
        if ($mes_ano == '12') {
            $mes = 'dezembro';
        }


        enviaContratoIntelligentia($nome, $email, $data, $motivo, $empresa, $atuacaoAgente, $atuacaoAgente2);
        enviaDeclaracaoIntelligentia($nome, $email, $data, $motivo, $clausulas, $mes);
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
        if (!isset($passou)) {
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

die(header("Location: rescisao-contrato"));
