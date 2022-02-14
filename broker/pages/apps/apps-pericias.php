<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
?>


<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">APPS - PLATAFORMAS DE RECÁLCULO DE DÍVIDAS E FINANCIAMENTOS</h4>
            <h6 class="m-0 font-weight-bold text-primary">CADASTROS - PERÍCIAS TÉCNICAS</h6>
            <p class="mb-4">Abaixo serão listadas todas as perícias técnicas cadastradas no sistema.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important' width="5%">CÓD.</th>
                            <th style='text-align: center; vertical-align:middle !important' width="75%">TÍTULO</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">VALOR</th>
                            <th style='text-align: center; vertical-align:middle !important' width="5%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("../../includes/databaseApps.php");
                        $pdo = BancoApps::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_pericias WHERE ativo IN (0,1) ORDER BY ordem ASC';

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['ordem']) {
                                $ordem = '' . $row['ordem'] . '';
                            }
                            if ($row['titulo']) {
                                $titulo = '' . $row['titulo'] . '';
                            }
                            if ($row['valor']) {
                                $valor = '' . $row['valor'] . '';
                            }
                            echo "<tr>";
                            //echo '<form action="apps-pericias" method="POST">';
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $ordem . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'>" . $titulo . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>R$ " . $valor . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            //echo '<div align="center"><input type="hidden" name="id_pericia" id="id_pericia" value="' . $row['id'] . '" >';
                            if ($row['ativo'] == '0') {
                                //echo '<button type="submit" class="btn btn-sm btn-success" title="ATIVAR" name="ativar"><i  class="fa fa-play-circle"></i></button>';
                                echo '<a type="button" class="ativa btn btn-sm btn-success" data-titulo="' . $row['titulo'] . '" data-id="' . $row['id'] . '" title="ATIVAR"><i  class="fa fa-play-circle"></i></a>';
                            }
                            if ($row['ativo'] == '1') {
                                //echo '<button type="submit" class="btn btn-sm btn-danger" title="DESATIVAR" name="desativar"><i  class="fa fa-stop-circle"></i></button>';
                                echo '<a type="button" class="desativa btn btn-sm btn-danger" data-titulo="' . $row['titulo']  . '" data-id="' . $row['id'] . '" title="DESATIVAR"><i  class="fa fa-stop-circle"></i></a>';
                            }
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="apps-pericias-editar?id=' . $row['id'] . '"><i class="fa fa-pen-square"></i></a>';
                            //echo "</form>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        BancoApps::desconectar()
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DESATIVA -->
<script>
    $('.desativa').on('click', function() {
        var titulo = $(this).data('titulo'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
        var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
        //$('span.nome').text(nome + ' (id = ' + id + ')'); // inserir na o nome na pergunta de confirmação dentro da modal
        $('span.titulo').text(titulo); // inserir na o nome na pergunta de confirmação dentro da modal
        $('a.desativa-yes').attr('href', 'desativa-pericia?id=' + id); // mudar dinamicamente o link, href do botão confirmar da modal
        $('#myModal').modal('show'); // modal aparece
    });
</script>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Desativar Perícia Técnica</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                <h2><strong>
                        <font color="#FF4D4D">ATENÇÃO</font>
                    </strong></h2>
                Tem certeza que deseja desativar a Perícia Técnica:<br />
                <h4><strong><span class="titulo"></span></strong></h4>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-danger desativa-yes"><i class="fa fa-check"></i> Sim</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- ATIVA -->
<script>
    $('.ativa').on('click', function() {
        var titulo = $(this).data('titulo'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
        var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
        //$('span.nome').text(nome + ' (id = ' + id + ')'); // inserir na o nome na pergunta de confirmação dentro da modal
        $('span.titulo').text(titulo); // inserir na o nome na pergunta de confirmação dentro da modal
        $('a.ativa-yes').attr('href', 'ativa-pericia?id=' + id); // mudar dinamicamente o link, href do botão confirmar da modal
        $('#myModal2').modal('show'); // modal aparece
    });
</script>
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ativar Perícia Técnica</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                Tem certeza que deseja ativar a Perícia Técnica:<br />
                <h3><strong><span class="titulo"></span></strong></h3>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success ativa-yes"><i class="fa fa-check"></i> Sim</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>

<?php
function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

switch (get_post_action('desativar')) {
    case 'desativar':

        if (!empty($_POST)) {

            $id = $_POST['id_pericia'];

            $validacao = true;
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $status = "2";
        $sql = "UPDATE tbl_pericias set status = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($status, $id));
        echo '<script>setTimeout(function () { 
        swal({
          title: "Parabéns!",
          text: "Perícia Técnica desativada com sucesso!",
          type: "success",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "apps-pericias";
          }
        }); }, 1000);</script>';
        BancoApps::desconectar();
        break;

    default:
}
?>