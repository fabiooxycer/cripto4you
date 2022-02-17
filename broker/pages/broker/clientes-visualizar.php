<?php
if ($_SERVER['HTTP_HOST'] != 'localhost') {
    if (!isset($_SESSION)) session_start();

    $nivel = 98;

    if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
        echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
        exit;
    }
}

include_once('../../includes/funcoes_pericias.php');
include('../../includes/header.php');
?>

<?php
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: pericia-visualizar");
} else {
    require_once("../../includes/databaseApps.php");
    $pdo = BancoApps::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$sql = "SELECT * FROM tbl_cadastro_pericias where id = ?";
    $sql = "SELECT DISTINCT cad_per.id,
    cad_per.dt_criacao AS data_criacao,
    aplic.titulo AS titulo_aplicativo,
    usuario.nome AS nome_usuario,
    usuario.cpf AS cpf_usuario,
    pericia.titulo AS tipo_pericia,
    pericia.valor AS valor_pericia,
    pagamento.forma_pagamento AS tipo_pagamento,
    cad_per.pericia_status AS pericia_status,
    cad_per.comprovante_pgto AS comprovante,
    cad_per.data_liberacao AS dt_liberacao,
    cad_per.liberacao_interna AS liberacao_interna,
    cad_per.motivo_liberacao AS motivo_liberacao
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
    AND usuario.nome IS NOT NULL AND pagamento.forma_pagamento IS NOT NULL AND cad_per.id = ? ORDER BY id DESC";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">VISUALIZAR INFORMAÇÕES SOBRE A PERÍCIA <?php echo $id; ?></h4>
            <p class="mb-4">Abaixo serão listadas todas as informações da perícia técnica.</p>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary text-white" onClick="history.go(-1)">VOLTAR</button>
            <div class="table-responsive m-t-40"><br />
                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td width=75>Cód:</td>
                            <td><?php echo $data['id']; ?></td>
                        </tr>
                        <tr>
                            <td width=75>Data:</td>
                            <td><?php
                                $data_pericia = '' . $data['data_criacao'] . '';
                                $timestamp = strtotime($data_pericia);
                                $timestamp2 = strtotime($data_pericia);
                                echo $data_criacao = date('d/m/Y', $timestamp) . ' ' . date('H:i:s', $timestamp2); ?></td>
                        </tr>
                        <tr>
                            <td width=75>APP:</td>
                            <td><?php echo $data['titulo_aplicativo']; ?></td>
                        </tr>
                        <tr>
                            <td width=75>Nome:</td>
                            <td><?php echo $data['nome_usuario']; ?></td>
                        </tr>
                        <tr>
                            <td width=75>CPF:</td>
                            <td><?php
                                $cpf = $data['cpf_usuario'];
                                echo $cpf = substr_replace(substr_replace(substr_replace($cpf, '-', 9, 0), '.', 6, 0), '.', 3, 0); ?></td>
                        </tr>
                        <tr>
                            <td width=75>Perícia:</td>
                            <td><?php echo $data['tipo_pericia']; ?></td>
                        </tr>
                        <tr>
                            <td width=75>Forma Pagamento:</td>
                            <td><?php
                                if ($data['tipo_pagamento'] == 'cartao') {
                                    echo $tipo_pagamento = '<font size="2"> CARTÃO </font>';
                                }
                                if ($data['tipo_pagamento'] == 'boleto') {
                                    echo $tipo_pagamento = '<font size="2"> BOLETO </font>';
                                } ?></td>
                        </tr>
                        <tr>
                            <td width=75>Status:</td>
                            <td><?php
                                if ($data['pericia_status'] == 'pericia_processamento_iniciado') {
                                    echo $status_pagamento = '<font size="2"> PROCESSANDO </font>';
                                }
                                if ($data['pericia_status'] == 'pagamento_em_processamento') {
                                    echo $status_pagamento = '<font size="2"> PGTO. EM PROCESSAMENTO </font>';
                                }
                                if ($data['pericia_status'] == 'pagamento_falha_processamento') {
                                    echo $status_pagamento = '<font size="2"> PGTO. COM FALHA </font>';
                                }
                                if ($data['pericia_status'] == 'pagamento_negado') {
                                    echo $status_pagamento = '<font size="2"> PGTO. NEGADO </font>';
                                }
                                if ($data['pericia_status'] == 'pagamento_confirmado') {
                                    echo $status_pagamento = '<font size="2"> PGTO. CONFIRMADO </font>';
                                }
                                if ($data['pericia_status'] == 'pericia_enviada') {
                                    echo $status_pagamento = '<font size="2"> PERÍCIA ENVIADA </font>';
                                } ?>

                            </td>
                        </tr>


                        <?php if ($data['liberacao_interna'] == '1') { ?>
                            <tr>
                                <td width=75>Liberação Interna?:</td>
                                <td><?php
                                    if ($data['liberacao_interna'] == '1') {
                                        echo $liberacao_interna = '<font size="2"> SIM </font>';
                                    }
                                    if ($data['liberacao_interna'] == '0') {
                                        echo $liberacao_interna = '<font size="2"> NÃO </font>';
                                    } ?></td>
                            </tr>
                            <tr>
                                <td width=75>Motivo:</td>
                                <td><?php echo $data['motivo_liberacao']; ?></td>
                            </tr>
                            <tr>
                                <td width=75>Data:</td>
                                <td><?php
                                    $data_liberacao = '' . $data['dt_liberacao'] . '';
                                    $timestamp_dt = strtotime($data_liberacao);
                                    echo $dt_liberacao = date('d/m/Y', $timestamp_dt); ?></td>
                            </tr>
                        <?php } ?>



                        <?php if ($data['comprovante'] != '') { ?>
                            <tr>
                                <td width=75>Comprovante:</td>
                                <td><img src="../../assets/img/comprovantes/<?php echo $data['comprovante']; ?>" width="50%"></td>
                            </tr>
                            <tr>
                                <td width=75>Data:</td>
                                <td><?php
                                    $data_liberacao = '' . $data['dt_liberacao'] . '';
                                    $timestamp_dt = strtotime($data_liberacao);
                                    echo $dt_liberacao = date('d/m/Y', $timestamp_dt); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>