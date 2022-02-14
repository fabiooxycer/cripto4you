<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Estatísticas Franquias</h1>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                LEADS
                            </div>
                            <?php
                            $total = 0;
                            $n = 1;
                            $sql = 'SELECT count(*) as t FROM tbl_cadastros_lojas WHERE status="1"';
                            $sql = $pdo->query($sql);
                            $sql = $sql->fetch();
                            $total_leads = $sql['t'];
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($total_leads == '') {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $total_leads;
                                                                                } ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                PROSPECTORS
                            </div>
                            <?php
                            $total = 0;
                            $n = 1;
                            $sql = 'SELECT count(*) as t FROM tbl_cadastros_lojas WHERE status="2"';
                            $sql = $pdo->query($sql);
                            $sql = $sql->fetch();
                            $total_prospector = $sql['t'];
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($tototal_prospectortal_aem == '') {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $total_prospector;
                                                                                } ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store  fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                FRANQUEADOS
                            </div>
                            <?php
                            $total = 0;
                            $n = 1;
                            $sql = 'SELECT count(*) as t FROM tbl_cadastros_lojas WHERE status="3"';
                            $sql = $pdo->query($sql);
                            $sql = $sql->fetch();
                            $total_franqueados = $sql['t'];
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($total_franqueados == '') {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $total_franqueados;
                                                                                } ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>