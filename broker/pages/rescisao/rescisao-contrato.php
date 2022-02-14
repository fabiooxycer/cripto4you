<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');
require_once("../../includes/database.php");
$pdo = BancoCadastros::conectar();
?>

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">RESCISÃO CONTRATUAL</h4>
            <p class="mb-4">Abaixo serão listadas todos o agentes cadastrados no sistema.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important' width="25%">NOME</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">RG</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">CPF</th>
                            <th style='text-align: center; vertical-align:middle !important' width="20%">TELEFONES</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">CIDADE</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">UF</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">ATUAÇÃO</th>
                            <th style='text-align: center; vertical-align:middle !important' width="10%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_cadastros WHERE empresa IN (3,4,6,7,8) AND atuacao IN (1,2,3,4,5,6) AND status="1" GROUP BY cpf ORDER BY nome ASC';

                        foreach ($pdo->query($sql) as $row) {
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
                            if($row['telefone'] == ''){
                                $telefone = '-';
                            }
                            if($row['celular'] == ''){
                                $celular = '-';
                            }
                            if ($row['cidade']) {
                                $cidade = '' . $row['cidade'] . '';
                            }
                            if ($row['estado']) {
                                $estado = '' . $row['estado'] . '';
                            }

                            if ($row['atuacao'] == '1') {
                                $atuacao = '<font size="2"><strong> AEN </strong></font>';
                            }
                            if ($row['atuacao'] == '2') {
                                $atuacao = '<font size="2"><strong> AEM </strong></font>';
                            }
                            if ($row['atuacao'] == '3') {
                                $atuacao = '<font size="2"><strong> AOIO </strong></font>';
                            }
                            if ($row['atuacao'] == '4') {
                                $atuacao = '<font size="2"><strong> AOI </strong></font>';
                            }
                            if ($row['atuacao'] == '5') {
                                $atuacao = '<font size="2"><strong> AEE </strong></font>';
                            }
                            if ($row['atuacao'] == '6') {
                                $atuacao = '<font size="2"><strong> AEEM </strong></font>';
                            }

                            echo "<tr>";

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
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $cidade . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $estado . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $atuacao . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'>";
                            echo '<form action="rescisao-contrato" method="POST">';
                            echo '<input type="hidden" name="id_agente" id="id_agente" value="' . $row['cpf'] . '" >';
                            echo '<a type="button" class="rescindir btn btn-sm btn-danger" data-nome="' . $nome . '" data-cpf="' . $row['cpf'] . '" title="RESCINDIR CONTRATO"><i  class="fa fa-file-signature"></i></a>';
                            echo "</form>";
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

<style type="text/css">
    .modal-info-rescindir2 {
        display: none;
    }
</style>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rescindir Contrato</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">
                <div class="modal-info-rescindir1">
                    <h2><strong>
                            <font color="#FF4D4D">ATENÇÃO</font>
                        </strong></h2>
                    Tem certeza que deseja rescindir o contato com o agente:<br />
                    <h4><strong><span class="nome"></span></strong></h4>
                </div>

                <div class="modal-info-rescindir2">
                    <strong>Informe abaixo o motivo da Rescisão:</strong><br>
                    <input type="hidden" id="cpfRescisao">
                    <textarea class="form-control" id="motivoRescisao" rows="3" maxlength="200" required></textarea>
                    <br>
                    <small>
                        <span id="contadorCaracteres">200</span> caracteres restantes.
                    </small>
                    <br>
                    <br>
                    <strong>Informe as cláusulas do contrato:</strong><br>
                    <input class="form-control" id="clausulaRescisao" required>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-info-rescindir1">
                    <a type="button" class="btn btn-danger rescindir-yes"><i class="fa fa-check"></i> Sim</a>
                    <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
                </div>

                <div class="modal-info-rescindir2">
                    <a type="button" class="btn btn-danger rescindir-confirma"><i class="fa fa-check"></i> Confirmar</a>
                    <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Ao clicar em rescindir reseta o modal
        // Pega o nome e o CPF e abre o modal
        $('.rescindir').on('click', function() {
            /* Reseta modal */
            $('#motivoRescisao').val('');
            $('#clausulaRescisao').val('');
            $('.modal-info-rescindir1').show();
            $('.modal-info-rescindir2').hide();
            /* ------------- */

            var nome = $(this).data('nome');
            $('span.nome').text(nome);

            var cpf = $(this).data('cpf');
            $('#cpfRescisao').val(cpf);

            $('#myModal').modal('show');
        });

        // Ao clicar em sim
        // abre o textarea para escrever o motivo da rescisão
        $('.rescindir-yes').on('click', function() {
            $('.modal-info-rescindir1').hide();
            $('.modal-info-rescindir2').show();
        });

        // Ao confirmar a rescisão envia o CPF e o Motivo para a URL
        $('.rescindir-confirma').on('click', function() {
            if ($('#motivoRescisao').val().length >= 10) {
                var cpf = $('#cpfRescisao').val();
                var motivoRescisao = encodeURI($('#motivoRescisao').val());
                var clausula = $('#clausulaRescisao').val();
                window.location.href = 'template-rescindir-contrato?cpf=' + cpf + '&motivo=' + motivoRescisao + '&clausulas=' + clausula;

                setTimeout(function() {
                    $('#myModal').modal('hide');

                    swal({
                        title: "Parabéns!",
                        text: "Rescisão de contrato realizada com sucesso!",
                        type: "success",
                        confirmButtonText: "OK"
                    });
                }, 1000);
            } else {
                alert('Informe um motivo de rescisao com pelo menos 10 caracteres.');
            }
        });
        $('#motivoRescisao').keyup(function() {
            var maxChar = 200;
            var totalChar = $('#motivoRescisao').val().length;
            $('#contadorCaracteres').text(maxChar - totalChar);
        });
    });
</script>

<?php
include('../../includes/footer.php');
?>