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
include('includes/scripts.php');
?>

<!-- <style>
    .faturamento {
        line-height: 100%;
    }

    .faturamento.hide {
        display: inline-block;
        background: #FFFFFF;
        line-height: 100%;
        height: 100%;
        overflow: hidden;
    }

    .botao-faturamento {
        cursor: pointer;
    }
</style> -->

<script>
    function removeMaskMoney(x) {
        x = "" + x;
        if ((x.replace(",", ".") != x)) {
            if (x.replace(".", "") != x) {
                aux = x;
                x = x.replace(".", "");
            } else {
                aux = x;
            }
            if (x.replace(",", ".") != x) {
                x = x.replace(",", ".")
            } else {
                x = aux;
            }
        }
        if (isNaN(parseFloat(x))) {
            x = 0;
        } else {
            x = parseFloat(x)
        }
        return x;
    }

    function tiraMascara(e) {
        value = removeMaskMoney($(e).val());
        $("[name=n1]").val(value)
    }
</script>

<script>
    $(document).on('keyup', '#valor', function() {
        $('#valor2').val($(this).val());
    });
</script>
<script>
    function calcular() {
        var n1 = parseInt(document.getElementById('n1').value);
        var n2 = parseInt(document.getElementById('n2').value);
        document.getElementById('diario').innerHTML = n1 / 100 * n2;
        document.getElementById('mensal').innerHTML = n1 / 100 * n2 * 30;
        document.getElementById('anual').innerHTML = n1 / 100 * n2 * 30 * 12;
    }
</script>


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
                                <!-- <span class="faturamento hide"> -->
                                    <h3><b><?php echo $totalUsuarios; ?></b></h3>
                                <!-- </span> -->
                                <h6>ativo(s)</h6>
                                <!-- <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span> -->
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
                                <!-- <span class="faturamento hide"> -->
                                    <h3><b>R$ <?php echo number_format($lucroGerado, 2, ',', '.'); ?></b></h3>
                                <!-- </span>
                                <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span> -->
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
                                <!-- <span class="faturamento hide"> -->
                                    <h3><b>R$ <?php echo number_format($totalRetiradas, 2, ',', '.'); ?></b></h3>
                                <!-- </span>
                                <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span> -->
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
                                <!-- <span class="faturamento hide"> -->
                                    <h3><b>R$ <?php echo number_format($saldoAtualInvestido, 2, ',', '.'); ?></b></h3>
                                <!-- </span>
                                <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span> -->
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

            <div class="col-lg-6">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Top 10</h4>
                        </div>
                    </div>
                    <iframe id="tvc_frame_40cefa9bdd4d8727d43d6bd622e371cc" seamless="seamless" src="https://broker.cripto4you.net/init.php?family_prefix=tvc4&amp;carrier=1d323e09469caa62c5025568c7d84696&amp;time=1647005107&amp;domain_ID=30&amp;lang_ID=12&amp;timezone_ID=12&amp;pair_ID=1057391&amp;interval=86400&amp;refresh=8&amp;session=session&amp;client=&amp;user=guest&amp;width=100%&amp;height=800&amp;init_page=live-charts&amp;m_pids=&amp;watchlist=1057391,1175058,1170319,1070908,1058142,1024807,1173182,1172743,1155577,1061443,1178905,1062537,1178235,1183115,1163457,1158892,1163454,1178582,1057392,1177183,1186007,1060628,1156338&amp;site=https://broker.cripto4you.net" width="100%" height="800" style="width: 100%; height: 750px; display: inline;"></iframe>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Top 10</h4>
                        </div>
                    </div>
                    <iframe src="https://widget.coinlib.io/widget?type=full_v2&theme=dark&cnt=10&pref_coin_id=3315&graph=yes" width="100%" height="380" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">
                                <li>CALCULADORA DE GANHOS</li>
                            </h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <p>Abaixo você pode calcular o lucro diário, mensal e anual de acordo com o valor de aporte pretendido</p>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="valor" name="valor" placeholder="Informe o Valor do Aporte. Ex.: 50.000,00" onblur="tiraMascara(this)" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" required>
                                        <input type="hidden" class="form-control" id="valor2" name="valor2" readonly>
                                        <input type="hidden" class="form-control" id="n1" name="n1" readonly>
                                        <input type="hidden" class="form-control" id="n2" name="n2" value="1" readonly>
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
                        <li>
                            <font size="4"><strong>R$ <i id="diario"></i><i>,00</strong></font> &nbsp;diário</i>
                        <li>
                            <font size="4"><strong>R$ <i id="mensal"></i><i>,00</strong></font> &nbsp;mensal</i>
                        </li>
                        <li>
                            <font size="4"><strong>R$ <i id="anual"></i><i>,00</strong></font> &nbsp;anual</i>
                        </li><br>
                        <p>
                            <strong>Obs.:</strong> <br><i>Taxa de transação 10%.<br><strong>Cálculo:</strong> R$ 200,00 <font size="1">(Lucro Bruto)</font> - 10% <font size="1">(Taxa)</font> = R$ 180,00 <font size="1">(Lucro Líquido)</font></i>
                        </p>
                    </div>
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