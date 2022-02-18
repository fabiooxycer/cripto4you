<?php
if ($_SERVER['HTTP_HOST'] != 'localhost') {
    if (!isset($_SESSION)) session_start();

    $nivel = 1;

    if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
        echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
        exit;
    }
} else {
    if (!isset($_SESSION)) session_start();
}
include('includes/header.php');
?>
<style>
    .faturamento {
        line-height: 35px;
    }

    .faturamento.hide {
        display: inline-block;
        background-color: #f1f1f1;
        line-height: 99999999px;
        height: 27px;
        overflow: hidden;
    }

    .botao-faturamento {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <section>
        <div align="right">
            <p>Olá <strong>
                    <font><?php echo $_SESSION['UsuarioNome']; ?></font>
                </strong>. Seja bem-vindo(a)!</p>
        </div>
    </section>
    <div class="container-fluid">


        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Lucro Total
                                </div>
                                <?php
                                $sql = $pdo->query('SELECT  sum(valor) FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 3 AND confirmado = 1');

                                $result = $sql->fetchAll();
                                
                                foreach ($result as $row) {
                                    $lucro = $row['sum(valor)'];
                                ?>
                                <!-- Total com exibir/esconder valor -->
                                <div class="h3 mb-0 font-weight-bold text-green-800">
                                    <span class="faturamento hide">R$ <?php echo number_format($lucro, 2, ',', '.'); ?></span>
                                    <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span>
                                </div>
                                <p>
                                    <font size="1">Valor movimentado desde <?php echo converte($_SESSION['UsuarioCadastro'], 2); ?></font>
                                </p>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-3x text-green-300"></i>
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
                                    Total de Retiradas
                                </div>
                                <?php
                                $sql = $pdo->query('SELECT  sum(valor) FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 2 AND confirmado = 1');

                                $result = $sql->fetchAll();
                                
                                foreach ($result as $row) {
                                    $retiradas = $row['sum(valor)'];
                                ?>
                                <!-- Total com exibir/esconder valor -->
                                <div class="h3 mb-0 font-weight-bold text-green-800">
                                    <span class="faturamento hide">R$ <?php echo number_format($retiradas, 2, ',', '.'); ?></span>
                                    <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span>
                                </div>
                                <p>
                                    <font size="1">Valor movimentado desde <?php echo converte($_SESSION['UsuarioCadastro'], 2); ?></font>
                                </p>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-3x text-green-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Saldo Atual
                                </div>
                                <?php
                                $sql = $pdo->query('SELECT  sum(valor) FROM tbl_investimentos WHERE id_usuario = "' . $_SESSION['UsuarioID'] . '" AND tipo = 1 AND confirmado = 1');

                                $result = $sql->fetchAll();

                                foreach ($result as $row) {
                                    $saldo = $row['sum(valor)'] + $lucro - $retiradas;

                                ?>
                                    <!-- Total com exibir/esconder valor -->
                                    <div class="h3 mb-0 font-weight-bold text-green-800">
                                        <span class="faturamento hide">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></span>
                                        <span class="botao-faturamento"><i class="far fa-eye-slash" style="font-size: 12px;"></i></span>
                                    </div>
                                    <p>
                                        <font size="1">Valor atualizado a cada 24h</font>
                                    </p>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-3x text-green-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">TOP 10 CRIPTOMOEDAS MAIS NEGOCIADAS</h1>
        </div>
        <div class="row">
            <iframe src="https://widget.coinlib.io/widget?type=full_v2&theme=light&cnt=10&pref_coin_id=3315&graph=yes" width="100%" height="655" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>