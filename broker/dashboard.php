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

        <?php if ($_SESSION['UsuarioNivel'] == '100') {
            include('includes/dados_geral.php');
        } else {
            include('includes/dados_usuario.php');
        }
        ?>

        <br><br>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">TOP 10 CRIPTOS</h1>
        </div>
        <div class="row">
            <iframe src="https://widget.coinlib.io/widget?type=full_v2&theme=light&cnt=10&pref_coin_id=3315&graph=yes" width="100%" height="655" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>