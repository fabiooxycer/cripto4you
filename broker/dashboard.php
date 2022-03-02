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

<?php if ($_SESSION['UsuarioContrato'] == 1) { ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#modalContrato').modal('show');
        });
    </script>

    <!-- Modal Contrato -->
    <div class="modal fade" id="modalContrato" tabindex="-1" role="dialog" aria-labelledby="modalContrato" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" ole="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">ACEITE DE CONTRATO</h5>
                </div>
                <form action="dashboard" method="post">
                    <div class="modal-body">
                        <div style="width: 100%; height:550px; overflow-y:scroll;">
                            <br>
                            <?php include('includes/contrato.php'); ?>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
                        <button type="submit" name="contrato" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> CONCORDO</button>
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
            $q->execute(array($contrato_aceito, $id_transacao));

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