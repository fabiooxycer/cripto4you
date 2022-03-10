<?php
if ($_SERVER['HTTP_HOST'] != 'localhost') {
    if (!isset($_SESSION)) session_start();

    $nivel = 1;

    if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
        echo '<script>setTimeout(function () { 
            swal({
              title: "Oopss!",
              text: "Você não possui permissão para exibir esta tela!",
              type: "warning",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "entrar";
              }
            }); }, 1000);</script>';

        exit;
    }
} else {
    if (!isset($_SESSION)) session_start();
}

include('includes/header.php');
include('includes/menu.php');
include('includes/topnavbar.php');

?>

<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">

            <?php
            //Informações para Administradores
            if ($_SESSION['UsuarioNivel'] == 100) {
            ?>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-primary">
                                <i class="fa fa-users"></i>
                            </div>
                            <p class="text-secondary">Total de Clientes</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b><?php echo $totalUsuarios; ?></b></h3>
                                <h6>ativo(s)</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-success">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Lucro Gerado</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($lucroGerado, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-danger">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Total Retiradas</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($totalRetiradas, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-info">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Total Investido</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($saldoAtualInvestido, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else {
                // Informações para Usuários
            ?>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-success">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Lucro Gerado</p>
                            <div class="d-flex align-items-center justify-content-between">

                                <h3><b>R$ <?php echo number_format($lucroGeradoUsuarios, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-danger">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Total Retiradas</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($totalRetiradasUsuarios, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-info">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Saldo Atual Investido</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($totalAporteUsuarios, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-lg-12">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Top 10</h4>
                        </div>
                    </div>
                    <iframe src="https://widget.coinlib.io/widget?type=full_v2&theme=dark&cnt=10&pref_coin_id=3315&graph=yes" width="100%" height="655" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$sql = "SELECT * FROM tbl_usuarios WHERE id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['UsuarioID']));
$data = $q->fetch(PDO::FETCH_ASSOC);

if ($data['contrato_aceito'] == '1') {
?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#modalContrato').modal('show');
        });
    </script>

    <!-- Modal Contrato -->
    <div class="modal fade" id="modalContrato" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" ole="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">ACEITE DE CONTRATO</h5>
                </div>
                <form action="dashboard" method="post">
                    <div class="modal-body">
                        <div style="width: 100%; height:400px; overflow-y:scroll;">
                            <br>
                            <?php include('includes/contrato.php'); ?>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> DEIXAR PARA DEPOIS</button> -->
                        <button type="submit" name="contrato" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Li e aceito os termos deste contrato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    // Chama função para pegar o POST de cada FORM
    function get_post_action($name)
    {
        $params = func_get_args();

        foreach ($params as $name) {
            if (isset($_POST[$name])) {
                return $name;
            }
        }
    }

    // Verifica qual botao foi clicado
    switch (get_post_action('contrato')) {

        case 'contrato':

            if (!empty($_POST)) {

                $id_usuario       = $_SESSION['UsuarioID'];
                $contrato_aceito  = 2;
            }

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'UPDATE tbl_usuarios SET contrato_aceito = ? WHERE id = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($contrato_aceito, $id_usuario));

            echo '<script>setTimeout(function () { 
                    swal({
                      title: "Parabéns!",
                      text: "Contrato aceito com sucesso!",
                      type: "success",
                      confirmButtonText: "OK" 
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        window.location.href = "dashboard";
                      }
                    }); }, 1000);</script>';

            break;

        default:
    }
}
?>

<?php include('includes/footer.php'); ?>