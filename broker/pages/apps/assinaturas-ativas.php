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
                [7, "desc"]
            ]
        });
    });
</script>


<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">ASSINATURAS ATIVAS</h4>
            <p class="mb-4">Abaixo serão listadas todos os usuários cadastrados no sistema com assinatura ativa.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>ID</th>
                            <th style='text-align: center; vertical-align:middle !important'>NOME</th>
                            <th style='text-align: center; vertical-align:middle !important'>TELEFONE</th>
                            <th style='text-align: center; vertical-align:middle !important'>E-MAIL</th>
                            <th style='text-align: center; vertical-align:middle !important'>RG</th>
                            <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                            <th style='text-align: center; vertical-align:middle !important'>OAB</th>
                            <th style='text-align: center; vertical-align:middle !important'>APP</th>
                            <th style='text-align: center; vertical-align:middle !important'>DT. INICIO</th>
                            <th style='text-align: center; vertical-align:middle !important'>DT. FIM</th>
                            <th style='text-align: center; vertical-align:middle !important'>STATUS</th>
                            <th style='text-align: center; vertical-align:middle !important'>AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("../../includes/databaseApps.php");
                        $pdo = BancoApps::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM tbl_usuarios WHERE id_aplicacao IN (14) AND perfil_verificado IN (1) AND id_plano = '1' ORDER BY id_aplicacao,perfil_verificado DESC";

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['id_aplicacao'] == '1') {
                                $app = '<font size="2"><strong> DEBTOOLS </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '2') {
                                $app = '<font size="2"><strong> AGRIMMER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '3') {
                                $app = '<font size="2"><strong> CALCMAGISTTER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '4') {
                                $app = '<font size="2"><strong> CALCULISTTER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '5') {
                                $app = '<font size="2"><strong> COLECTTER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '6') {
                                $app = '<font size="2"><strong> CONNSIER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '7') {
                                $app = '<font size="2"><strong> DEEPERS </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '8') {
                                $app = '<font size="2"><strong> EXPERTTD </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '9') {
                                $app = '<font size="2"><strong> FINANCISTTER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '10') {
                                $app = '<font size="2"><strong> PROFFYTER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '11') {
                                $app = '<font size="2"><strong> SAIA DAS DÍVIDAS </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '12') {
                                $app = '<font size="2"><strong> SECURITEER </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '13') {
                                $app = '<font size="2"><strong> RURALEXPERTTD </strong></font>';
                            }
                            if ($row['id_aplicacao'] == '14') {
                                $app = '<font size="2"><strong> DEBTOOLS ADV </strong></font>';
                            }

                            if ($row['dt_assinatura_plano']) {
                                $dt_assinatura_plano = '' . $row['dt_assinatura_plano'] . '';
                                $timestamp = strtotime($dt_assinatura_plano);
                                $dt_inicio = date('d/m/Y', $timestamp);
                            }
                            if ($row['dt_vencimento_plano']) {
                                $dt_vencimento_plano = '' . $row['dt_vencimento_plano'] . '';
                                $timestamp2 = strtotime($dt_vencimento_plano);
                                $dt_fim = date('d/m/Y', $timestamp2);
                            }

                            if ($row['perfil_verificado'] == '0') {
                                $perfil_verificado = '<font size="2" color="#FF0000"><strong> NÃO VERIFICADO </strong></font>';
                            }
                            if ($row['perfil_verificado'] == '1') {
                                $perfil_verificado = '<font size="2" color="#00B200"><strong> VERIFICADO </strong></font>';
                            }
                            echo "<tr>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $row['id'] . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'>" . $row['nome'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $row['telefone1'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $row['email'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $row['rg'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $row['cpf'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $row['oab_numero'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $app . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_inicio . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_fim . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $perfil_verificado . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            echo ' <a type="button" class="liberacaoComprovante btn btn-sm btn-warning" onclick="modalComprovante(\'' . $row["id"] . '\', \'' . $row["nome"] . '\', \'' . $row["id_aplicacao"] . '\', \'' . $row["id_plano"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO COM COMPROVANTE DE PGTO."><i  class="fa fa-vote-yea"></i></a>';

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

<!-- MODAL LIBERAÇÃO COM COMPROVANTE -->
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Renovação da Assinatura de Plano com Comprovante de Pagamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                <h2>
                    <strong>
                        <font color="#FF4D4D">ATENÇÃO</font>
                    </strong>
                </h2>

                <h4>Envio de comprovante da assinatura de plano <strong><span class="pericia"></span></strong></h4>

                <form id="form-comprovante" enctype="multipart/form-data">
                    <input type="hidden" name="comprovanteIdUsuario" id="comprovanteIdUsuario">
                    <input type="hidden" name="comprovanteUsuario" id="comprovanteUsuario">
                    <input type="hidden" name="comprovanteIdAplicacao" id="comprovanteIdAplicacao">
                    <input type="hidden" name="comprovanteIdPlano" id="comprovanteIdPlano">
                    <input type="hidden" name="comprovanteData" id="comprovanteData">

                    <strong>Realize o upload do comprovante de pagamento via PIX:</strong><br><br>
                    <input type="file" class="form-control-file" name="comprovante" id="comprovante" required>
                </form>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success comprovante-confirma" onclick="salvarComprovante()"><i class="fa fa-check"></i> Salvar</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<style>
    #loading {
        display: none;

        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .8);
        text-align: center;

        z-index: 99999999;
    }

    .fa-spinner {
        position: absolute;
        color: #fff;
        top: 50%;
        left: 50%;
        font-size: 40px;
    }
</style>
<div id="loading">
    <i class="fas fa-spinner fa-spin"></i>
</div>

<script>
    function modalComprovante(idUsuario, usuario, idAplicacao, idPlano, data) {
        $('#comprovanteIdUsuario').val(idUsuario);
        $('#comprovanteUsuario').val(usuario);
        $('#comprovanteIdAplicacao').val(idAplicacao);
        $('#comprovanteIdPlano').val(idPlano);
        $('#comprovanteData').val(data);

        $('span.usuario').text(comprovanteUsuario);

        $('#myModal2').modal('show');
    }

    function salvarComprovante() {
        $('#loading').show();

        var formData = new FormData($('#form-comprovante')[0]);

        $.ajax({
            url: 'pages/apps/assinaturas-ativas.php',
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#loading').hide();

                if (data == 1) {
                    $('#myModal2').modal('hide');

                    swal({
                        title: "Parabéns!",
                        text: "Renovação realizada com sucesso! O plano de perícias já está ativo parar o usuário selecionado.",
                        type: "success",
                        confirmButtonText: "OK"
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else if (data == 0) {
                    swal({
                        title: "Erro!",
                        text: "Ocorreu um erro ao tentar renovar o plano de perícias.",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                } else if (data == 'formatoinvalido') {
                    swal({
                        title: "Erro!",
                        text: "O comprovante precisa ser uma imagem jpg.",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>

<?php include('../../includes/footer.php'); ?>