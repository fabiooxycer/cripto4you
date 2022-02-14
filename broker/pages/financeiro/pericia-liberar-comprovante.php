<?php
session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

if($_POST){
    require_once("../../includes/databaseApps.php");
    $pdo = BancoApps::conectar();
    
    $idPericia      = trim($_REQUEST['comprovanteIdPericia']);
    $usuario      = trim($_REQUEST['comprovanteUsuario']);
    $data           = trim($_REQUEST['comprovanteData']);

    // Formatar data para gravar no banco
    $data = explode('/', $data);
    $dt_liberacao = $data[2].'-'.$data[1].'-'.$data[0];     

    $uploaddir = '/home/digitalinteluser/public_html/teste/assets/img/comprovantes/';
    
    $fileExtension = explode('.',$_FILES['comprovante']['name']);
    $fileExtension = strtolower($fileExtension[1]);

    $nomeArquivo = $idPericia . '.' . $fileExtension;
    
    if($fileExtension=='jpg' or $fileExtension=='jpeg' or $fileExtension=='png'){
        if(move_uploaded_file($_FILES['comprovante']['tmp_name'], $uploaddir . $nomeArquivo)) {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pericia_status    = 'pagamento_confirmado';
            $liberacao_interna = '0';
            
            $sql = "UPDATE tbl_cadastro_pericias set pericia_status = ?, liberacao_interna = ?, comprovante_pgto = ?, usuario_liberou = ?, data_liberacao = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            
            if($q->execute(array($pericia_status, $liberacao_interna, $nomeArquivo, $usuario, $dt_liberacao, $idPericia))){
              echo 1;
            }    
        }else{
            echo 0;
        }        
    }else{
        echo "formatoinvalido";
    }

}

?>