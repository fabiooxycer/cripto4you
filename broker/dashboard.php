<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
} else {
    if (!isset($_SESSION)) session_start();
}

include('includes/header.php');
include('includes/menu.php');
include('includes/topnavbar.php');
include('includes/scripts.php');
?>

<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <p>
                    <font color="#FF0000" size="3"><strong>ATENÇÃO!</strong> Fução saque desativada devido a queda do mercado cripto. Estamos aguardando recuperação do mesmo para finalizar as operações realizadas em 11/05/2022, onde até o momento estamos com -36% negativo. Precisamos desta recuperação para finalizarmos as operações e retomarmos a inserção de lucros em nossa plataforma.</font>
                </p>
            </div>

            <?php include('includes/slide_criptos.php');

            //Informações para Administradores
            if ($_SESSION['UsuarioNivel'] == 100) {
            ?>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-primary">
                                <i class="fa fa-users"></i>
                            </div>
                            <p class="text-secondary">Total de Clientes</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b><?php echo $totalUsuarios; ?></b></h3>
                                <!-- <h6>ativo(s)</h6> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-secondary">
                                <i class="fa fa-exchange"></i>
                            </div>
                            <p class="text-secondary">Total de Transações</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b><?php echo $totalTransacoes; ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-warning">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Lucro Gerado</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($lucroGerado, 2, ',', '.'); ?></b></h3>
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
                                <h3><b>R$ <?php echo number_format($totalRetiradas, 2, ',', '.'); ?></b></h3>
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
                            <p class="text-secondary">Total Aporte</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($totalAporteInvestido, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-success">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Total Aporte + Lucro Reinvestido</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h3><b>R$ <?php echo number_format($totalAporteLucro, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else {
                // Informações para Usuários
            ?>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-body iq-box-relative">
                            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-warning">
                                <i class="fa fa-money"></i>
                            </div>
                            <p class="text-secondary">Lucro Gerado</p>
                            <div class="d-flex align-items-center justify-content-between">

                                <h3><b>R$ <?php echo number_format($lucroGeradoUsuarios, 2, ',', '.'); ?></b></h3>
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
                                <h3><b>R$ <?php echo number_format($totalRetiradasUsuarios, 2, ',', '.'); ?></b></h3>
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
                            <p class="text-secondary">Saldo Aporte</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <?php

                                ?>
                                <h3><b>R$ <?php echo number_format($totalAporteUsuarios, 2, ',', '.'); ?></b></h3>
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
                            <p class="text-secondary">Saldo Atual Investido</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <?php

                                ?>
                                <h3><b>R$ <?php echo number_format($totalInvestido, 2, ',', '.'); ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!--             
            <div class="col-lg-12">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"><i class="fas fa-user-plus"></i> &nbsp;Link de Indicação</h4>
                        </div>
                    </div><br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input class="form-control" type="text" id="id_indicacao" value='https://broker.cripto4you.net/pre-cadastro?id=<?php echo $_SESSION['UsuarioID']; ?>' readonly><br>
                            <i class="btn btn-outline-success fa fa-copy" id="link" title="COPIAR LINK DE INDICAÇÃO"></i>
                            &nbsp;&nbsp;Faça indicações de novos clientes e lucre até 10% ao mês sobre o investimento da indicação.
                        </div>
                    </div>
                </div>
            </div> -->


            <?php include('includes/grafico.php'); ?>

            <div class="col-lg-12">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"><i class="fas fa-rocket"></i> &nbsp;Top 10</h4>
                        </div>
                    </div>
                    <iframe src="https://widget.coinlib.io/widget?type=full_v2&theme=dark&cnt=10&pref_coin_id=3315&graph=yes" width="100%" height="430" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
                </div>
            </div>
            <!-- <div class="col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">
                                <i class="fa fa-calculator"></i> &nbsp;Calculadora de Lucro
                            </h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <p>Abaixo você pode calcular o lucro de acordo com o valor de aporte pretendido</p>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="valor" name="valor" placeholder="Informe o Valor do Aporte. Ex.: 50.000,00" onblur="tiraMascara(this)" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" required>
                                        <input type="hidden" class="form-control" id="valor2" name="valor2" readonly>
                                        <input type="hidden" class="form-control" id="n1" name="n1" readonly>
                                        <input type="hidden" class="form-control" id="n2" name="n2" value="<?php echo $_SESSION['UsuarioPercentual']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-outline-success" onclick="calcular()"><i class="fas fa-calculator"></i> Calcular</button><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                            <font size="4"><strong>Com o valor de aporte informado acima, seu lucro será de:</strong></font>
                        </p><br>
                        <?php if ($_SESSION['UsuarioTipoContrato'] == '1') { ?>
                            <li>
                                <font size="4"><strong>R$ <i id="diario"></i><i>,00</strong></font> &nbsp;diário</i>
                            </li>
                        <?php }
                        if ($_SESSION['UsuarioTipoContrato'] == '2') { ?>
                            <li>
                                <font size="4"><strong>R$ <i id="mensal_d"></i><i>,00</strong></font> &nbsp;diário</i>
                            </li>
                        <?php }
                        if ($_SESSION['UsuarioTipoContrato'] == '3') { ?>
                            <li>
                                <font size="4"><strong>R$ <i id="quinzenal"></i><i>,00</strong></font> &nbsp;a cada 15 dias</i>
                            </li>
                        <?php }
                        if ($_SESSION['UsuarioTipoContrato'] == '4') { ?>
                            <li>
                                <font size="4"><strong>R$ <i id="mensal"></i><i>,00</strong></font> &nbsp;mesal</i>
                            </li>
                        <?php } ?><br>
                        <p>
                            <?php if ($_SESSION['UsuarioIndicacao'] != null) { ?>
                                <strong>Obs.:</strong> <br><i>Taxa de transação 20%.<br><strong>Cálculo:</strong> (Lucro Bruto) - 20% <font size="1">(Taxa)</font> = (Lucro Líquido)</i>
                            <?php }
                            if ($_SESSION['UsuarioIndicacao'] == null) { ?>
                                <strong>Obs.:</strong> <br><i>Taxa de transação 10%.<br><strong>Cálculo:</strong> (Lucro Bruto) - 10% <font size="1">(Taxa)</font> = (Lucro Líquido)</i>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div> -->
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


<script>
    document.getElementById("link").addEventListener("click", function() {

        document.getElementById("id_indicacao").select();

        document.execCommand('copy');

    });
</script>