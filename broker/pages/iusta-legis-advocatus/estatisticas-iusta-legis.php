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
        <h1 class="h3 mb-0 text-gray-800">Estatísticas Iusta Legis Advocatus</h1>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Advocatus Corporate Estadual
                            </div>
                            <?php
                            $total = 0;
                            $n = 1;
                            $sql = 'SELECT count(*) as t FROM tbl_cadastros WHERE empresa = "1" AND atuacao = "1" AND status="1"';
                            $sql = $pdo->query($sql);
                            $sql = $sql->fetch();
                            $total_adv_estadual = $sql['t'];
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($total_adv_estadual == '') {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $total_adv_estadual;
                                                                                } ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-4x text-gray-300"></i>
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
                                Advocatus Corporate Municipal
                            </div>
                            <?php
                            $total = 0;
                            $n = 1;
                            $sql = 'SELECT count(*) as t FROM tbl_cadastros WHERE empresa = "1" AND atuacao = "2" AND status="1"';
                            $sql = $pdo->query($sql);
                            $sql = $sql->fetch();
                            $total_adv_municipal = $sql['t'];
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($total_adv_municipal == '') {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $total_adv_municipal;
                                                                                } ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends  fa-4x text-gray-300"></i>
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
                                Advocatus Corporate Municipal e Originário
                            </div>
                            <?php
                            $total = 0;
                            $n = 1;
                            $sql = 'SELECT count(*) as t FROM tbl_cadastros WHERE empresa = "1" AND atuacao = "3" AND status="1"';
                            $sql = $pdo->query($sql);
                            $sql = $sql->fetch();
                            $total_adv_municipal_originario = $sql['t'];
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if ($total_adv_municipal_originario == '') {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $total_adv_municipal_originario;
                                                                                } ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</div>

<?php include('../../includes/footer.php'); ?>