<?php

if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

require_once("databaseApps.php");


function gerarBotao($idPericia, $status) {
    $retorno = array();

    if ($status == 'pagamento_pendente') {
        $retorno['status'] = '<font size="2" color="blue" ><strong> PENDENTE </strong></font>';
        $retorno['menu'] = '
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Alterar forma de pagamento</a>
            <a class="dropdown-item" href="#">Enviar comprovante</a>
            <>                
        </div>
        
        ';
    }
    if ($status == 'pagamento_confirmado') {
        $retorno['status'] = '<font size="2" color="green" ><strong> CONFIRMADO </strong></font>';
        $retorno['menu'] = '
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Reenviar Perícia</a>                
        </div>
        
        ';
    }
    if ($status == 'pagamento_negado') {
        $retorno['status'] = '<font size="2" color="red" ><strong> NEGADO </strong></font>';
        $retorno['menu'] = '
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Mudar forma de pagamento</a>
            <a class="dropdown-item" href="#">Enviar comprovante</a>                
        </div>
        
        ';
    }
    if ($status == 'pericia_enviada') {
        $retorno['status'] = '<font size="2" color="green" ><strong> CONFIRMADO </strong></font>';
        $retorno['menu'] = '
        <div class="dropdown-menu">
            <a class="dropdown-item" href="reprocessar-pericia/?idPericia=' . $idPericia . '&metodo=falha">Reenviar Perícia</a>                
        </div>

        ';
    }
    if ($status == 'pericia_processamento_pendente') {
        $retorno['status'] = '<font size="2" color="green" ><strong> PROCESSANDO </strong></font>';
        $retorno['menu'] = '
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Menu Processando</a>                
        </div>
        
        ';
    }
    if ($status == 'pericia_processamento_falhou') {
        $retorno['status'] = '<font size="2" color="green" ><strong> FALHA </strong></font>';
        $retorno['menu'] = '
        <div class="dropdown-menu">
            <a class="dropdown-item" href="reprocessar-pericia/?idPericia=' . $idPericia . '&metodo=falha">Reprocessar</a>                
        </div>
        
        ';
    }

    

    return $retorno;

}

function reprocessarPericia($idPericia)
{
    try {
        $pdo = BancoApps::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("UPDATE tbl_cadastro_pericias set pericia_status = 'pericia_processamento_pendente' WHERE id = :idPericia");
        $stmt->execute(array(
            ':idPericia'  => $idPericia
        ));
       
        $pdo = BancoApps::desconectar();
        
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

        return true;

}


function mudarFormaPagamento($idPericia, $novaForma)
{
    try {
        $pdo = BancoApps::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("UPDATE tbl_cadastro_pericias set pericia_status = 'pericia_processamento_pendente' WHERE id = :idPericia");
        $stmt->execute(array(
            ':idPericia'  => $idPericia
        ));
        
        $pdo = BancoApps::desconectar();
        
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

        return true;
}
  
?>