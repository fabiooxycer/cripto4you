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
    function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) $maskared. = $val[$k++];
            } else {
                if (isset($mask[$i])) $maskared. = $mask[$i];
            }
        }
        return $maskared;
    }
</script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [0, "desc"]
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
            <h4 class="m-0 font-weight-bold text-primary">PERÍCIAS GERADAS</h4>
            <p class="mb-4">Abaixo serão listadas todas as perícias geradas.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                            <th style='text-align: center; vertical-align:middle !important'>DATA</th>
                            <th style='text-align: center; vertical-align:middle !important'>APP</th>
                            <th style='text-align: center; vertical-align:middle !important'>USUÁRIO</th>
                            <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                            <th style='text-align: center; vertical-align:middle !important'>PERÍCIA</th>
                            <!-- <th style='text-align: center; vertical-align:middle !important' width='15%'>VALOR</th> -->
                            <th style='text-align: center; vertical-align:middle !important'>FORMA PGTO.</th>
                            <th style='text-align: center; vertical-align:middle !important'>STATUS</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("../../includes/databaseApps.php");
                        $pdo = BancoApps::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT DISTINCT cad_per.id,
                        cad_per.dt_criacao AS data_criacao,
                        aplic.titulo AS titulo_aplicativo,
                        usuario.nome AS nome_usuario,
                        usuario.cpf AS cpf_usuario,
                        pericia.titulo AS tipo_pericia,
                        pericia.valor AS valor_pericia,
                        pagamento.forma_pagamento AS tipo_pagamento,
                        cad_per.pericia_status AS pericia_status
                        FROM `tbl_cadastro_pericias` cad_per
                        LEFT JOIN tbl_aplicacoes aplic
                        ON cad_per.id_aplicacao = aplic.id
                        LEFT JOIN tbl_usuarios usuario
                        ON cad_per.id_usuario = usuario.id
                        LEFT JOIN tbl_cadastro_pericias_pagamento AS pagamento
                        ON cad_per.id_pagamento = pagamento.id
                        LEFT JOIN tbl_pericias AS pericia 
                        ON cad_per.id_pericia = pericia.id
                        WHERE cad_per.pericia_status IN ('pericia_processamento_pendente','pericia_processamento_iniciado','pagamento_pendente','pagamento_em_processamento','pagamento_falha_processamento','pagamento_negado','pagamento_confirmado','pericia_enviada')
                        AND usuario.nome IS NOT NULL AND pagamento.forma_pagamento IS NOT NULL ORDER BY id DESC";

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['id']) {
                                $id = '' . $row['id'] . '';
                            }
                            if ($row['data_criacao']) {
                                $data_pericia = '' . $row['data_criacao'] . '';
                                $timestamp = strtotime($data_pericia);
                                $timestamp2 = strtotime($data_pericia);
                                $data_criacao = '<font size="2">' . date('d/m/Y', $timestamp) . ' ' . date('H:i:s', $timestamp2) . ' </font>';
                            }
                            if ($row['titulo_aplicativo']) {
                                $titulo_aplicativo = '' . $row['titulo_aplicativo'] . '';
                            }
                            if ($row['nome_usuario']) {
                                $nome_usuario = '' . $row['nome_usuario'] . '';
                            }
                            if ($row['cpf_usuario']) {
                                $cpf_usuario = '' . $row['cpf_usuario'] . '';
                                $cpf = substr_replace(substr_replace(substr_replace($cpf_usuario, '-', 9, 0), '.', 6, 0), '.', 3, 0);
                            }
                            if ($row['tipo_pericia']) {
                                $tipo_pericia = '' . $row['tipo_pericia'] . '';
                            }
                            if ($row['valor_pericia']) {
                                $valor_pericia = '' . $row['valor_pericia'] . '';
                            }
                            if ($row['tipo_pagamento'] == 'boleto') {
                                $tipo_pagamento = '<font size="2"> BOLETO </font>';
                            }
                            if ($row['tipo_pagamento'] == 'cartao') {
                                $tipo_pagamento = '<font size="2"> CARTÃO </font>';
                            }
                            if ($row['tipo_pagamento'] == 'pix') {
                                $tipo_pagamento = '<font size="2"> PIX </font>';
                            }
                            if ($row['pericia_status'] == 'pagamento_pendente') {
                                $status_pagamento = '<font size="2"> PGTO. PENDENTE </font>';
                            }
                            if ($row['pericia_status'] == 'pericia_processamento_iniciado') {
                                $status_pagamento = '<font size="2"> PROCESSANDO </font>';
                            }
                            if ($row['pericia_status'] == 'pagamento_em_processamento') {
                                $status_pagamento = '<font size="2"> PGTO. EM PROCESSAMENTO </font>';
                            }
                            if ($row['pericia_status'] == 'pagamento_falha_processamento') {
                                $status_pagamento = '<font size="2"> PGTO. COM FALHA </font>';
                            }
                            if ($row['pericia_status'] == 'pagamento_negado') {
                                $status_pagamento = '<font size="2"> PGTO. NEGADO </font>';
                            }
                            if ($row['pericia_status'] == 'pagamento_confirmado') {
                                $status_pagamento = '<font size="2"> PGTO. CONFIRMADO </font>';
                            }
                            if ($row['pericia_status'] == 'pericia_enviada') {
                                $status_pagamento = '<font size="2"> PERÍCIA ENVIADA </font>';
                            }

                            echo "<tr>";

                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $id . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $data_criacao . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $titulo_aplicativo . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nome_usuario . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $cpf . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $tipo_pericia . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $tipo_pagamento . "<strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $status_pagamento . "<strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            echo '<a type="button" class="liberacaoInterna btn btn-sm btn-success" onclick="modalLiberar2(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO INTERNA"><i  class="fa fa-file-signature"></i></a>';
                            echo ' <a type="button" class="liberacaoComprovante btn btn-sm btn-warning" onclick="modalComprovante(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO COM COMPROVANTE DE PGTO."><i  class="fa fa-vote-yea"></i></a>';
                            if ($row['pericia_status'] == 'pericia_enviada') {
                                echo ' <a type="button" class="reprocessar btn btn-sm btn-primary" data-id="' . $row['id'] . '" title="REPROCESSAR"><i  class="fa fa-share"></i></a>';
                            }
                            echo ' <a type="button" class="btn btn-sm btn-info" href="pericia-visualizar?id=' . $row['id'] . '" title="VISUALIZAR"> <i class="fa fa-eye"></i></a>';
                            if ($row['tipo_pagamento'] == 'boleto') {
                                echo ' <a type="button" class="reenviarboleto btn btn-sm btn-secondary" data-id="' . $row['id'] . '" title="REENVIAR BOLETO"><i  class="fa fa-file-import"></i></a>';
                            }
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

<!-- MODAL LIBERAÇÃO INTERNA -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Liberação Interna de Perícia Técnica</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                <div class="modal-info-liberar1">
                    <h2><strong>
                            <font color="#FF4D4D">ATENÇÃO</font>
                        </strong></h2>
                    Tem certeza que deseja liberar internamente a perícia técnicao com o código:<br />
                    <h4><strong><span class="pericia"></span></strong></h4>
                </div>

                <div class="modal-info-liberar2">
                    <strong>Informe abaixo o motivo da liberação:</strong><br><br>

                    <input type="hidden" id="pericia">
                    <input type="hidden" id="usuario">
                    <input type="hidden" id="dt">

                    <textarea class="form-control" id="motivoLiberacao" rows="3" maxlength="200" required></textarea>
                    <br>
                    <small>
                        <span id="contadorCaracteres">200</span> caracteres restantes.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-info-liberar1">
                    <a type="button" class="btn btn-success liberar-yes"><i class="fa fa-check"></i> Sim</a>
                    <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
                </div>

                <div class="modal-info-liberar2">
                    <a type="button" class="btn btn-success liberar-confirma"><i class="fa fa-check"></i> Confirmar</a>
                    <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL LIBERAÇÃO COM COMPROVANTE -->
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Liberação de Perícia Técnica com Comprovante de Pagamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                <h2>
                    <strong>
                        <font color="#FF4D4D">ATENÇÃO</font>
                    </strong>
                </h2>

                <h4>Envio de comprovante da perícia <strong><span class="pericia"></span></strong></h4>

                <form id="form-comprovante" enctype="multipart/form-data">
                    <input type="hidden" name="comprovanteIdPericia" id="comprovanteIdPericia">
                    <input type="hidden" name="comprovanteUsuario" id="comprovanteUsuario">
                    <input type="hidden" name="comprovanteData" id="comprovanteData">

                    <strong>Realize o upload do comprovante de pagamento:</strong><br><br>
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

<!-- MODAL REPROCESSA PERÍCIA -->
<script>
    $('.reprocessar').on('click', function() {
        var id = $(this).data('id');
        $('span.id').text(id);
        $('a.reprocessar-yes').attr('href', 'pericia-reprocessar?id=' + id);
        $('#myModalReprocessar').modal('show');
    });
</script>
<div id="myModalReprocessar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reprocessar Perícia Técnica</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                Tem certeza que deseja reprocessar a Perícia Técnica:<br />
                <h3><strong><span class="id"></span></strong></h3>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success reprocessar-yes"><i class="fa fa-check"></i> Sim</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REENVIAR LINK PAGAMENTO -->
<script>
    $('.reenviarboleto').on('click', function() {
        var id = $(this).data('id');
        $('span.id').text(id);
        $('a.reenviarboleto-yes').attr('href', 'pericia-reenviarboleto?id=' + id);
        $('#myModalreenviarboleto').modal('show');
    });
</script>
<div id="myModalreenviarboleto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Link de Pagamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                Tem certeza que deseja reenviar o link de pagamento para a Perícia Técnica:<br />
                <h3><strong><span class="id"></span></strong></h3>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success reenviarboleto-yes"><i class="fa fa-check"></i> Sim</a>
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
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
    function modalLiberar2(idPericia, usuario, data) {
        /* Reseta modal */
        $('#motivoLiberacao').val('');
        $('.modal-info-liberar1').show();
        $('.modal-info-liberar2').hide();
        /* ------------- */

        var pericia = idPericia;
        var usuarioLiberou = usuario;
        var dtLiberacao = data;
        $('span.pericia').text(idPericia);

        $('#myModal').modal('show');

        // Ao clicar em sim
        // abre o textarea para escrever o motivo da rescisão
        $('.liberar-yes').on('click', function() {
            $('.modal-info-liberar1').hide();
            $('.modal-info-liberar2').show();
        });

        // Ao confirmar a rescisão envia o CPF e o Motivo para a URL
        $('.liberar-confirma').on('click', function() {
            if ($('#motivoLiberacao').val().length >= 10) {
                var motivoLiberacao = encodeURI($('#motivoLiberacao').val());

                $.post('pages/financeiro/pericia-liberar.php', {
                    pericia: pericia,
                    motivo: motivoLiberacao,
                    usuario: usuarioLiberou,
                    dtLiberacao: dtLiberacao
                }, function(data) {
                    // console.log(data);

                    if (data == 1) {
                        $('#myModal').modal('hide');

                        swal({
                            title: "Parabéns!",
                            text: "Liberação realizada com sucesso! Em até 30 minutos a perícia técnica será enviada no e-mail de cadastro do usuário.",
                            type: "success",
                            confirmButtonText: "OK"
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        swal({
                            title: "Erro!",
                            text: "Ocorreu um erro ao tentar liberar a perícia.",
                            type: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
            } else {
                alert('Informe um motivo da liberação com pelo menos 10 caracteres.');
            }
        });
        $('#motivoLiberacao').keyup(function() {
            var maxChar = 200;
            var totalChar = $('#motivoLiberacao').val().length;
            $('#contadorCaracteres').text(maxChar - totalChar);
        });
    }

    function modalComprovante(idPericia, usuario, data) {
        $('#comprovanteIdPericia').val(idPericia);
        $('#comprovanteUsuario').val(usuario);
        $('#comprovanteData').val(data);

        $('span.pericia').text(idPericia);

        $('#myModal2').modal('show');
    }

    function salvarComprovante() {
        $('#loading').show();

        var formData = new FormData($('#form-comprovante')[0]);

        $.ajax({
            url: 'pages/financeiro/pericia-liberar-comprovante.php',
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#loading').hide();

                if (data == 1) {
                    $('#myModal2').modal('hide');

                    swal({
                        title: "Parabéns!",
                        text: "Liberação realizada com sucesso! Em até 30 minutos a perícia técnica será enviada no e-mail de cadastro do usuário.",
                        type: "success",
                        confirmButtonText: "OK"
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else if (data == 0) {
                    swal({
                        title: "Erro!",
                        text: "Ocorreu um erro ao tentar liberar a perícia.",
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