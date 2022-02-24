<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include_once('../../includes/funcoes_pericias.php');
include('../../includes/header.php');
?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [9, "asc"]
            ]
        });
    });
</script>

<style>
    .div-atribuir-atendente {
        display: none;
        text-align: left;
    }

    .botoes-modal2 {
        display: none;
    }

    .novo-chamado{
        margin-top: 8px;
    }

    #modalCadastrarChamado label{
        font-weight: bold;
    }
    .dados-chamado{
        display: none;
    }
</style>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="m-0 font-weight-bold text-primary">Suporte</h4>
                    <p class="mb-4">Abaixo serão listadas todos os atendimentos.</p>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-success novo-chamado"><i class="fas fa-plus"></i> Novo Chamado</button>
                </div>
            </div>
        </div>

        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="chamados-abertos" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Chamados Abertos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="chamados-em-andamento" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Chamados em Andamento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="chamados-finalizados" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Chamados Finalizados</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="chamados-abertos">
                    <!-- Chamados Abertos -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                                        <th style='text-align: center; vertical-align:middle !important'>DATA</th>
                                        <th style='text-align: center; vertical-align:middle !important'>DEPARTAMENTO</th>
                                        <th style='text-align: center; vertical-align:middle !important'>ASSUNTO</th>
                                        <th style='text-align: center; vertical-align:middle !important'>CLIENTE</th>
                                        <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once("../../includes/database.php");
                                    $pdo = BancoCadastros::conectar();
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $sql = "SELECT suporte.id as suporte_id,
                                    suporte.dt_criacao as suporte_dt_criacao,
                                    suporte.hr_criacao as suporte_hr_criacao,
                                    departamento.departamento as departamento_nome,
                                    suporte.assunto as assunto_nome,
                                    suporte.nome as nome,
                                    suporte.cpf as cpf,
                                    suporte.email as email,
                                    suporte.telefone as telefone,
                                    suporte.atendente as atendente,
                                    suporte.descricao as descricao,
                                    suporte.status as status,
                                    usuarios.nome as nome_atendente
                                    FROM tbl_suporte as suporte
                                    left join tbl_suporte_departamentos as departamento
                                    on suporte.id_departamento = departamento.id
                                    left join tbl_cadastros as usuarios on usuarios.id = suporte.atendente
                                    WHERE suporte.status=0
                                    ORDER BY suporte.id DESC, suporte.status DESC";                        

                                    foreach ($pdo->query($sql) as $row) {
                                        if ($row['suporte_id']) {
                                            $id = '' . $row['suporte_id'] . '';
                                        }
                                        if ($row['suporte_dt_criacao']) {
                                            $dt_criacao = '' . $row['suporte_dt_criacao'] . '';
                                            $timestamp = strtotime($dt_criacao);
                                            $data_criacao = '<font size="2">' . date('d/m/Y', $timestamp) . '</font>';
                                        }
                                        if ($row['suporte_hr_criacao']) {
                                            $suporte_hr_criacao = '' . $row['suporte_hr_criacao'] . '';
                                            $timestamp2 = strtotime($suporte_hr_criacao);
                                            $hora_criacao = '<font size="2">' . date('H:i:s', $timestamp2) . '</font>';
                                        }
                                        if ($row['departamento_nome']) {
                                            $departamento_nome = '' . $row['departamento_nome'] . '';
                                        }
                                        if ($row['assunto_nome']) {
                                            $assunto_nome = '' . $row['assunto_nome'] . '';
                                        }
                                        if ($row['nome']) {
                                            $nome = '' . $row['nome'] . '';
                                        }
                                        if ($row['cpf']) {
                                            $cpf = '' . $row['cpf'] . '';
                                        }
                                        if ($row['email']) {
                                            $email = '' . $row['email'] . '';
                                        }
                                        if ($row['telefone']) {
                                            $telefone = '' . $row['telefone'] . '';
                                        }

                                        if ($row['descricao']) {
                                            $descricao = '' . $row['descricao'] . '';
                                        }
                                        echo "<tr>";

                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $id . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $data_criacao . ' às ' . $hora_criacao . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $departamento_nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $assunto_nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                                        if ($row['atendente'] == '') {
                                            echo '<a type="button" class="liberacaoInterna btn btn-sm btn-info" onclick="modalLiberar2(\'' . $id . '\', \'' . $row['suporte_dt_criacao'] . '\', \'' . $row['suporte_hr_criacao'] . '\', \'' . $departamento_nome . '\', \'' . $assunto_nome . '\', \'' . $nome . '\', \'' . $cpf . '\', \'' . $email . '\', \'' . $telefone . '\', \'' . $row['atendente'] . '\', \'' . $row['status'] . '\', \'' . $descricao . '\')" title="VISUALIZAR ATENDIMENTO"><i  class="fa fa-eye"></i></a>';
                                        } else {
                                            echo '-';
                                        }
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="chamados-em-andamento">
                    <!-- Chamados em Andamento -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                                        <th style='text-align: center; vertical-align:middle !important'>DATA</th>
                                        <th style='text-align: center; vertical-align:middle !important'>DEPARTAMENTO</th>
                                        <th style='text-align: center; vertical-align:middle !important'>ASSUNTO</th>
                                        <th style='text-align: center; vertical-align:middle !important'>CLIENTE</th>
                                        <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT suporte.id as suporte_id,
                                    suporte.dt_criacao as suporte_dt_criacao,
                                    suporte.hr_criacao as suporte_hr_criacao,
                                    departamento.departamento as departamento_nome,
                                    suporte.assunto as assunto_nome,
                                    suporte.nome as nome,
                                    suporte.cpf as cpf,
                                    suporte.email as email,
                                    suporte.telefone as telefone,
                                    suporte.atendente as atendente,
                                    suporte.descricao as descricao,
                                    suporte.status as status,
                                    usuarios.nome as nome_atendente
                                    FROM tbl_suporte as suporte
                                    left join tbl_suporte_departamentos as departamento
                                    on suporte.id_departamento = departamento.id
                                    left join tbl_cadastros as usuarios on usuarios.id = suporte.atendente
                                    WHERE suporte.status=1
                                    ORDER BY suporte.id,suporte.status DESC";                        

                                    foreach ($pdo->query($sql) as $row) {
                                        if ($row['suporte_id']) {
                                            $id = '' . $row['suporte_id'] . '';
                                        }
                                        if ($row['suporte_dt_criacao']) {
                                            $dt_criacao = '' . $row['suporte_dt_criacao'] . '';
                                            $timestamp = strtotime($dt_criacao);
                                            $data_criacao = '<font size="2">' . date('d/m/Y', $timestamp) . '</font>';
                                        }
                                        if ($row['suporte_hr_criacao']) {
                                            $suporte_hr_criacao = '' . $row['suporte_hr_criacao'] . '';
                                            $timestamp2 = strtotime($suporte_hr_criacao);
                                            $hora_criacao = '<font size="2">' . date('H:i:s', $timestamp2) . '</font>';
                                        }
                                        if ($row['departamento_nome']) {
                                            $departamento_nome = '' . $row['departamento_nome'] . '';
                                        }
                                        if ($row['assunto_nome']) {
                                            $assunto_nome = '' . $row['assunto_nome'] . '';
                                        }
                                        if ($row['nome']) {
                                            $nome = '' . $row['nome'] . '';
                                        }
                                        if ($row['cpf']) {
                                            $cpf = '' . $row['cpf'] . '';
                                        }
                                        if ($row['email']) {
                                            $email = '' . $row['email'] . '';
                                        }
                                        if ($row['telefone']) {
                                            $telefone = '' . $row['telefone'] . '';
                                        }                                    

                                        if ($row['descricao']) {
                                            $descricao = '' . $row['descricao'] . '';
                                        }
                                        echo "<tr>";

                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $id . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $data_criacao . ' às ' . $hora_criacao . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $departamento_nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $assunto_nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";
                                        
                                        echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                                        echo '<a href="ver-chamado?id='.$id.'" class="liberacaoInterna btn btn-sm btn-info" title="VISUALIZAR ATENDIMENTO"><i  class="fa fa-eye"></i></a>';
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="chamados-finalizados">
                    <!-- Chamados Finalizados -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style='text-align: center; vertical-align:middle !important'>CÓD.</th>
                                        <th style='text-align: center; vertical-align:middle !important'>DATA</th>
                                        <th style='text-align: center; vertical-align:middle !important'>DEPARTAMENTO</th>
                                        <th style='text-align: center; vertical-align:middle !important'>ASSUNTO</th>
                                        <th style='text-align: center; vertical-align:middle !important'>CLIENTE</th>
                                        <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT suporte.id as suporte_id,
                                    suporte.dt_criacao as suporte_dt_criacao,
                                    suporte.hr_criacao as suporte_hr_criacao,
                                    departamento.departamento as departamento_nome,
                                    suporte.assunto as assunto_nome,
                                    suporte.nome as nome,
                                    suporte.cpf as cpf,
                                    suporte.email as email,
                                    suporte.telefone as telefone,
                                    suporte.atendente as atendente,
                                    suporte.descricao as descricao,
                                    suporte.status as status,
                                    usuarios.nome as nome_atendente
                                    FROM tbl_suporte as suporte
                                    left join tbl_suporte_departamentos as departamento
                                    on suporte.id_departamento = departamento.id
                                    left join tbl_cadastros as usuarios on usuarios.id = suporte.atendente
                                    WHERE suporte.status=2
                                    ORDER BY suporte.id,suporte.status DESC";                        

                                    foreach ($pdo->query($sql) as $row) {
                                        if ($row['suporte_id']) {
                                            $id = '' . $row['suporte_id'] . '';
                                        }
                                        if ($row['suporte_dt_criacao']) {
                                            $dt_criacao = '' . $row['suporte_dt_criacao'] . '';
                                            $timestamp = strtotime($dt_criacao);
                                            $data_criacao = '<font size="2">' . date('d/m/Y', $timestamp) . '</font>';
                                        }
                                        if ($row['suporte_hr_criacao']) {
                                            $suporte_hr_criacao = '' . $row['suporte_hr_criacao'] . '';
                                            $timestamp2 = strtotime($suporte_hr_criacao);
                                            $hora_criacao = '<font size="2">' . date('H:i:s', $timestamp2) . '</font>';
                                        }
                                        if ($row['departamento_nome']) {
                                            $departamento_nome = '' . $row['departamento_nome'] . '';
                                        }
                                        if ($row['assunto_nome']) {
                                            $assunto_nome = '' . $row['assunto_nome'] . '';
                                        }
                                        if ($row['nome']) {
                                            $nome = '' . $row['nome'] . '';
                                        }
                                        if ($row['cpf']) {
                                            $cpf = '' . $row['cpf'] . '';
                                        }
                                        if ($row['email']) {
                                            $email = '' . $row['email'] . '';
                                        }
                                        if ($row['telefone']) {
                                            $telefone = '' . $row['telefone'] . '';
                                        }

                                        if ($row['descricao']) {
                                            $descricao = '' . $row['descricao'] . '';
                                        }
                                        echo "<tr>";

                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $id . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $data_criacao . ' às ' . $hora_criacao . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $departamento_nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $assunto_nome . "</font></td>";
                                        echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";

                                        echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                                        echo '<a href="ver-chamado?id='.$id.'" class="liberacaoInterna btn btn-sm btn-info" title="VISUALIZAR ATENDIMENTO"><i  class="fa fa-eye"></i></a>';
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
            </div>    

        </div>

    </div>
</div>

<!-- Exibe informações do chamado -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ticket de Suporte</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body" align="center">

                <h2 style="text-align: left;">
                    <strong style="color: #FF4D4D;">
                        Ticket <span class="idChamado"></span>
                    </strong>
                </h2>

                <table class="display nowrap table table-hover table-striped table-bordered table-chamado" cellspacing="0" width="100%">
                    <tr>
                        <td>ID</td>
                        <td><span class="idChamado"></span></td>
                    </tr>
                    <tr>
                        <td>Data:</td>
                        <td><span class="dtCriacao"></span> | <span class="hrCriacao"></span></td>
                    </tr>
                    <tr>
                        <td>Departamento:</td>
                        <td><span class="departamento"></span></td>
                    </tr>
                    <tr>
                        <td>Assunto:</td>
                        <td><span class="assunto"></span></td>
                    </tr>
                    <tr>
                        <td>Nome:</td>
                        <td><span class="clienteNome"></span></td>
                    </tr>
                    <tr>
                        <td>CPF:</td>
                        <td><span class="clienteCpf"></span></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><span class="clienteEmail"></span></td>
                    </tr>
                    <tr>
                        <td>Telefone:</td>
                        <td><span class="clienteTelefone"></span></td>
                    </tr>
                    <tr>
                        <td>Atendente:</td>
                        <td><span class="clienteAtendente"></span></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td><span class="status"></span></td>
                    </tr>
                    <tr>
                        <td>Descrição:</td>
                        <td><span class="descricao"></span></td>
                    </tr>
                </table>

                <div class="div-atribuir-atendente">
                    Selecione um atendente para atribuir ao ticket:<br>
                    <select name="atendente" id="" class="form-control"></select>
                </div>

            </div>
            <div class="modal-footer">
                <div class="botoes-modal1">
                    <a href="iniciar-atendimento.php?id=" class="btn btn-success iniciar-atendimento"><i class="fa fa-check"></i> Iniciar Atendimento</a>
                    &nbsp;|&nbsp;
                    <a type="button" class="btn btn-info atribuir-atendente"><i class="fa fa-user-edit"></i> Atribuir Atendente</a>
                    &nbsp;|&nbsp;
                    <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
                </div>

                <div class="botoes-modal2">
                    <a type="button" class="btn btn-info voltar-modal1"><i class="fas fa-chevron-left"></i> Voltar</a>
                    &nbsp;|&nbsp;
                    <a type="button" class="btn btn-success salvar-atendente"><i class="fa fa-user-check"></i> Salvar</a>
                    &nbsp;|&nbsp;
                    <button type="button" class="btn btn-primary text-white" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cadastrar novo chamado -->
<div id="modalCadastrarChamado" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cadastrar novo Chamado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form id="formNovoChamado">

                    Dados do Cliente:<br><br>
                    
                    <div class="form-group">
                        <label for="cpfCliente">CPF</label>
                        <input type="text" class="form-control" id="cpfCliente" name="cpfCliente" maxlength="11" required>
                    </div> 

                    
                    <div class="dados-chamado">
                        <div class="form-group">
                            <label for="nomeCliente">Nome</label>
                            <input type="text" class="form-control" id="nomeCliente" name="nomeCliente" required>
                        </div>

                        
                        <div class="form-group">
                            <label for="telefoneCliente">Telefone</label>
                            <input type="text" class="form-control phone" id="telefoneCliente" name="telefoneCliente" required>
                        </div> 
                        
                        <div class="form-group">
                            <label for="emailCliente">E-mail</label>
                            <input type="text" class="form-control" id="emailCliente" name="emailCliente" required>
                        </div>                         

                        <hr class="mt-4">

                        Dados do Chamado:<br><br>

                        <div class="form-group">
                            <label for="assuntoChamado">Assunto do Chamado</label>
                            <input type="text" class="form-control" id="assuntoChamado" name="assuntoChamado" required>
                        </div> 

                        <div class="form-group">
                            <label for="departamentoChamado">Departamento</label>
                            <select class="form-control" id="departamentoChamado" name="departamentoChamado" required>
                                <option value="">Selecione um Departamento</option>
                                <?php
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $sql = "SELECT * FROM tbl_suporte_departamentos ORDER BY departamento";
                                    foreach ($pdo->query($sql) as $row){
                                ?>
                                <option value="<?=$row['id']?>"><?=$row['departamento']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="prioridadeChamado">Prioridade</label>
                            <select class="form-control" id="prioridadeChamado" name="prioridadeChamado" required>
                                <option value="">Selecione uma Prioridade</option>
                                <option>Baixa</option>
                                <option selected>Normal</option>
                                <option>Alta</option>
                            </select>
                        </div>                          
                        
                        <div class="form-group">
                            <label for="descricaoChamado">Descrição</label>
                            <textarea class="form-control" id="descricaoChamado" name="descricaoChamado" rows="3" required></textarea>
                        </div>     
                        
                        <div class="form-group">
                            <label for="anexoChamado">Anexo (imagem jpg ou png)</label>
                            <input type="file" class="form-control-file" name="anexoChamado" id="anexoChamado">
                        </div>          
                    </div>          
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success salvar-chamado"><i class="fa fa-user-check"></i> Salvar</button>
                &nbsp;|&nbsp;
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
    function modalLiberar2(idChamado, dtCriacao, hrCriacao, departamento, assunto, clienteNome, clienteCpf, clienteEmail, clienteTelefone, atendente, status, descricao) {
        $('.idChamado').text(idChamado);
        $('.dtCriacao').text(dtCriacao);
        $('.hrCriacao').text(hrCriacao);
        $('.departamento').text(departamento);
        $('.assunto').text(assunto);
        $('.clienteNome').text(clienteNome);
        $('.clienteCpf').text(clienteCpf);
        $('.clienteEmail').text(clienteEmail);
        $('.clienteTelefone').text(clienteTelefone);
        $('.atendente').text(atendente);

        $('a.iniciar-atendimento').attr('href', 'iniciar-atendimento?ticket=' + idChamado);

        switch (status) {
            case "0":
                $('.status').text('Aberto');
                break;
            case "1":
                $('.status').text('Em Andamento');
                break;
            case "2":
                $('.status').text('Fechado');
                break;
            default:
                console.log(status);
        }

        $('.descricao').text(descricao);

        $('#myModal').modal('show');
    }

    $(document).ready(function() {
        $('a.iniciar-atendimento').on('click', function(e) {
            e.preventDefault();

            $('#loading').show();

            $.post('pages/suporte/' + $('a.iniciar-atendimento').attr('href'), function(data) {
                if (data == 1) {
                    $('#loading').hide();

                    swal({
                        title: "Atendimento Iniciado",
                        text: "",
                        type: "success",
                        confirmButtonText: "OK"
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        });


        // Carrega atendentes do mesmo departamento 
        $('.atribuir-atendente').on('click', function(e) {
            e.preventDefault();

            $('#loading').show();

            var departamento = $('span.departamento').text();

            $.post('pages/suporte/lista-atendentes.php?departamento=' + departamento, function(data) {
                if (data) {
                    $('#loading').hide();
                    $('select[name=atendente]').html(data);
                }
            });

            $('.table-chamado, .botoes-modal1').hide();
            $('.div-atribuir-atendente, .botoes-modal2').show();
        });


        // Salvar atendente
        $('.salvar-atendente').on('click', function(e) {
            e.preventDefault();

            $('#loading').show();

            var atendente = $('select[name=atendente]').val();
            var ticket = $('span.idChamado').first().text();

            $.post('pages/suporte/salvar-atendente.php', {
                atendente: atendente,
                ticket: ticket
            }, function(data) {
                if (data == 1) {
                    $('#loading').hide();

                    swal({
                        title: "Atendente Salvo",
                        text: "",
                        type: "success",
                        confirmButtonText: "OK"
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        });

        $('.voltar-modal1').on('click', function() {
            $('.div-atribuir-atendente, .botoes-modal2').hide();
            $('.table-chamado, .botoes-modal1').show();
        });

        // Abre Modal do Novo Chamado
        $('.novo-chamado').on('click', function(){
            $('#modalCadastrarChamado').modal('show');
        });

        // Carrega os dados do usuário
        $('#cpfCliente').keyup(function(){
            if($(this).val().length == 14){
                $('#loading').show();

                $.post( "pages/suporte/dados-cliente.php", {cpf: $('#cpfCliente').val()}, function( data ) {
                    if(data=='erro'){
                        $('#cpfCliente').val('');
                        $('#loading').hide();

                        swal({
                            title: "Erro!",
                            text: "CPF não encontrado.",
                            type: "error",
                            confirmButtonText: "OK"
                        });                        
                    }else{
                        $('#loading').hide();

                        data = JSON.parse(data);

                        var nomeCliente = data.nome;
                        var telefoneCliente = data.telefone;
                        var emailCliente = data.email;

                        $('#nomeCliente').val(nomeCliente);
                        $('#telefoneCliente').val(telefoneCliente);
                        $('#emailCliente').val(emailCliente);
                        $('.dados-chamado').show();
                    }
                });                        
            }
        });

        // Salva o chamado
        $('.salvar-chamado').on('click', function(e) {
            e.preventDefault();

            $('#loading').show();

            var formData = new FormData($('#formNovoChamado')[0]);

            $.ajax({
                url: 'pages/suporte/salvar-chamado.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    $('#loading').hide();

                    if (data == 1) {
                        $('#modalCadastrarChamado').modal('hide');

                        swal({
                            title: "Chamado cadastrado com sucesso!",
                            text: "",
                            type: "success",
                            confirmButtonText: "OK"
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (data == 0) {
                        swal({
                            title: "Erro!",
                            text: "Ocorreu um erro ao tentar cadastrar o chamado.",
                            type: "error",
                            confirmButtonText: "OK"
                        });
                    } else if (data == 'formatoinvalido') {
                        swal({
                            title: "Erro!",
                            text: "O anexo do chamado precisa ser uma imagem jpg ou png.",
                            type: "error",
                            confirmButtonText: "OK"
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });        
    });

    $('#cpfCliente').mask('000.000.000-00');
</script>

<?php include('../../includes/footer.php'); ?>