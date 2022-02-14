<?php
include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();

if (!isset($_SESSION)) session_start();

$status = 1;

if (!isset($_SESSION['UsuarioID']) && ($_SESSION['UsuarioStatus'] > $status) && ($_SESSION['UsuarioBancos'] == 'NÃO')) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}
?>


<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">CADASTROS DESATIVADOS</h4>
            <h6 class="m-0 font-weight-bold text-primary">CONSELHEIROS FINANCEIROS FAMILIARES E EMPRESARIAIS</h6>
            <p class="mb-4">Abaixo serão listadas todos os CFFE desativados no sistema.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                            <th style='text-align: center; vertical-align:middle !important' width="25%">NOME</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">RG</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">CPF</th>
                            <th style='text-align: center; vertical-align:middle !important' width="20%">TELEFONES</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">CIDADE / UF</th>
                            <th style='text-align: center; vertical-align:middle !important'>ATUAÇÃO</th>
                            <th style='text-align: center; vertical-align:middle !important'>BANCO</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_cadastros WHERE empresa IN (6,7,8) AND status = "2" ORDER BY nome ASC';

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['meu_id']) {
                                $meu_id = '' . $row['meu_id'] . '';
                            }
                            if ($row['nome']) {
                                $nome = '' . $row['nome'] . '';
                            }
                            if ($row['rg']) {
                                $rg = '' . $row['rg'] . '';
                            }
                            if ($row['cpf']) {
                                $cpf = '' . $row['cpf'] . '';
                            }
                            if ($row['telefone']) {
                                $telefone = '' . $row['telefone'] . '';
                            }
                            if ($row['celular']) {
                                $celular = '' . $row['celular'] . '';
                            }
                            if ($row['cidade']) {
                                $cidade = '' . $row['cidade'] . '';
                            }
                            if ($row['estado']) {
                                $estado = '' . $row['estado'] . '';
                            }
                            if ($row['atuacao'] == 1) {
                                $atuacao = '<font size="3" color="blue" ><strong> CFFE AEN </strong></font>';
                            }
                            if ($row['atuacao'] == 2) {
                                $atuacao = '<font size="3" color="blue" ><strong> CFFE AEM </strong></font>';
                            }
                            if ($row['atuacao'] == 3) {
                                $atuacao = '<font size="3" color="blue" ><strong> CFFE AOIO </strong></font>';
                            }
                            if ($row['atuacao'] == 4) {
                                $atuacao = '<font size="3" color="blue" ><strong> CFFE AOI </strong></font>';
                            }
                            if ($row['empresa'] == 6) {
                                $empresa = '<font size="3" color="blue" ><strong> LAVVOR </strong></font>';
                            }
                            if ($row['empresa'] == 7) {
                                $empresa = '<font size="3" color="blue" ><strong> INTELLIGENZ </strong></font>';
                            }
                            if ($row['empresa'] == 8) {
                                $empresa = '<font size="3" color="blue" ><strong> CONSTELLATER </strong></font>';
                            }

                            echo "<tr>";
                            //echo '<form action="cadastros-bancos-desativados" method="POST">';
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $meu_id . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'>" . $nome . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $rg . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $cpf . "</font></td>";
                            if ($telefone != '' && $celular == '') {
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $telefone . "</font></td>";
                            }
                            if ($telefone == '' && $celular != '') {
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $celular . "</font></td>";
                            }
                            if ($telefone != '' && $celular != '') {
                                echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $telefone . " / " . $celular . "</font></td>";
                            }
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $cidade . " / " . $estado . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $atuacao . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $empresa . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            //echo '<div align="center"><input type="hidden" name="id_agente" id="id_agente" value="' . $row['id'] . '" >';
                            //echo '&nbsp;<button type="submit" class="btn btn-sm btn-success" title="ATIVAR" name="ativar"><i  class="fa fa-thumbs-up"></i></button>';
                            echo '<a type="button" class="ativa btn btn-sm btn-success" data-nome="' . $nome . '" data-id="' . $row['id'] . '" title="ATIVAR"><i  class="fa fa-thumbs-up"></i></a>';
                            //echo "</form>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        BancoCadastros::desconectar()
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('.ativa').on('click', function() {
        var nome = $(this).data('nome'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
        var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
        //$('span.nome').text(nome + ' (id = ' + id + ')'); // inserir na o nome na pergunta de confirmação dentro da modal
        $('span.nome').text(nome); // inserir na o nome na pergunta de confirmação dentro da modal
        $('a.ativa-yes').attr('href', 'ativa-cadastro?id=' + id); // mudar dinamicamente o link, href do botão confirmar da modal
        $('#myModal').modal('show'); // modal aparece
    });
</script>



<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ativar cadastro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                Tem certeza que deseja ativar o CFFE:<br />
                <h3><strong><span class="nome"></span></strong></h3>
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

switch (get_post_action('ativar')) {
    case 'ativar':

        if (!empty($_POST)) {

            $id = $_POST['id_agente'];

            $validacao = true;
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $status = "1";
        $sql = "UPDATE tbl_cadastros set status = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($status, $id));
        echo '<script>setTimeout(function () { 
        swal({
          title: "Parabéns!",
          text: "CFFE ativado com sucesso!",
          type: "success",
          confirmButtonText: "OK"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "cadastros-bancos-desativados";
          }
        }); }, 1000);</script>';
        BancoCadastros::desconectar();
        break;

    default:
}
?>