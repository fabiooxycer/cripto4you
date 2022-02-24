<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [2, "asc"]
            ]
        });
    });
</script>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">APPS - PLATAFORMAS DE RECÁLCULO DE DÍVIDAS E FINANCIAMENTOS</h4>
            <h6 class="m-0 font-weight-bold text-primary">CADASTROS - USUÁRIOS</h6>
            <p class="mb-4">Abaixo serão listadas todas os usuários cadastrados no sistema.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                            <th style='text-align: center; vertical-align:middle !important'>APP</th>
                            <th style='text-align: center; vertical-align:middle !important'>NOME</th>
                            <th style='text-align: center; vertical-align:middle !important'>TELEFONE</th>
                            <th style='text-align: center; vertical-align:middle !important'>E-MAIL</th>
                            <th style='text-align: center; vertical-align:middle !important'>CÓD. IND.</th>
                            <th style='text-align: center; vertical-align:middle !important'>RG</th>
                            <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                            <th style='text-align: center; vertical-align:middle !important'>PLANO?</th>
                            <th style='text-align: center; vertical-align:middle !important'>AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("../../includes/databaseApps.php");
                        $pdo = BancoApps::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT
                        usuario.id,
                        usuario.id_aplicacao,
                        aplicacao.titulo AS titulo_app,
                        usuario.nome,
                        usuario.telefone1,
                        usuario.email,
                        usuario.cod_indicacao,
                        usuario.rg,
                        usuario.cpf,
                        usuario.id_plano,
                        plano.titulo
                        FROM tbl_usuarios AS usuario
                        LEFT JOIN tbl_aplicacoes AS aplicacao
                        ON usuario.id_aplicacao = aplicacao.id
                        LEFT JOIN tbl_planos_debtools as plano
                        ON usuario.id_plano = plano.id
                         ORDER BY usuario.nome ASC';

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['id']) {
                                $usuario_id = '' . $row['id'] . '';
                            }
                            if ($row['titulo_app']) {
                                $aplicacao_titulo = '' . $row['titulo_app'] . '';
                            }
                            if ($row['nome']) {
                                $usuario_nome = '' . $row['nome'] . '';
                            }
                            if ($row['telefone1']) {
                                $usuario_telefone1 = '' . $row['telefone1'] . '';
                            }
                            if ($row['email']) {
                                $usuario_email = '' . $row['email'] . '';
                            }
                            if ($row['cod_indicacao']) {
                                $usuario_cod_indicacao = '' . $row['cod_indicacao'] . '';
                            }
                            if ($row['cod_indicacao'] == '') {
                                $usuario_cod_indicacao = '<font size="2"><strong> - </strong></font>';
                            }
                            if ($row['cod_indicacao'] == null) {
                                $usuario_cod_indicacao = '<font size="2"><strong> - </strong></font>';
                            }
                            if ($row['rg']) {
                                $usuario_rg = '' . $row['rg'] . '';
                            }
                            if ($row['cpf']) {
                                $usuario_cpf = '' . $row['cpf'] . '';
                            }

                            if ($row['id_plano'] == '99') {
                                $plano = '<font size="2"><strong> NÃO </strong></font>';
                            }
                            if ($row['id_plano'] == '1') {
                                $plano = '<font size="2"><strong> SIM </strong></font>';
                            }
                            echo "<tr>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_id . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'>" . $aplicacao_titulo . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_nome . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_telefone1 . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_email . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_cod_indicacao . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_rg . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $usuario_cpf . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $plano . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="usuarios-cadastros-editar?id=' . $row['id'] . '"><i class="fa fa-pen-square"></i></a>';
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