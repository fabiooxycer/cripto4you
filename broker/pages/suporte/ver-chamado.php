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

<style>
    .chatcontent{
        float: left;
        position: relative;
        width: 100%;
        padding: 10px 20px;
        min-height: 150px;

        background-color: #f1f1f1;
        border:1px solid #ccc;

        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }
    .answer{
        width: calc(50% - 10px);
        margin: 10px;
        padding: 10px;
        background-color: #fff;
    }
    .answer-left{
        position: relative;
        float: left;
        background-color: #333;
        color: #fff;        
    }
    .answer-left::after{
        content: '';
        display: block;

        position: absolute;
        left: -10px;
        top: 0;

        width: 0; 
        height: 0; 
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent; 
        
        border-right:10px solid #333;         
    }
    .answer-right{
        position: relative;
        float: right;
        text-align: right;
    }
    .answer-right::after{
        content: '';
        display: block;

        position: absolute;
        right: -10px;
        top: 0;

        width: 0; 
        height: 0; 
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent; 
        
        border-left:10px solid #fff;         
    }    

    .chattextarea{
        position: relative;

        width: 100%;
        height: 100px;
        background-color: #fff;

        border:1px solid #ccc;
        border-bottom: 0;

        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .chattextarea textarea{
        width: calc(100% - 300px);
        height: 98px;

        border:0;
        outline: none;
        resize: none;
        padding: 10px;
        font-size: 16px;
        color: #666;
        text-align: justify;

        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .chattextarea .chatbotoes{
        position: absolute;
        width: 300px;
        right: 0; bottom: 30px;
        border:0;
        text-align: center;
        border-left: 1px solid #f1f1f1;
    }    
</style>

<?php
    $id = $_REQUEST['id'];

    require_once("../../includes/database.php");
    $pdo = BancoCadastros::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $linha = $pdo->query("SELECT * FROM tbl_suporte WHERE id='$id'")->fetch();

    $dataChamado = new DateTime($linha['dt_criacao']);

    switch($linha['status']){
        case 1:
            $statusChamado = 'Em andamento';
            break;
        case 2:
            $statusChamado = 'Finalizado';
            break;            
    }
        
    $departamento = $pdo->query("SELECT * FROM tbl_suporte_departamentos WHERE id=$linha[id_departamento]")->fetch();
    $atendente = $pdo->query("SELECT * FROM tbl_cadastros WHERE id=$linha[atendente]")->fetch();
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="m-0 font-weight-bold text-primary">Dados do Chamado</h4>
                </div>
            </div>
        </div>

        <div class="card-body">

            <table class="display nowrap table table-hover table-striped table-bordered table-chamado" cellspacing="0" width="100%">
                <tr>
                    <td width="50%"><strong>ID:</strong> <?=$id?></td>
                    <td><strong>Data:</strong> <?=$dataChamado->format('d/m/Y')?> - <?=$linha['hr_criacao']?></td>
                </tr>
                <tr>
                    <td><strong>Departamento:</strong> <?=$departamento['departamento']?></td>
                    <td><strong>Assunto:</strong> <?=$linha['assunto']?></td>
                </tr>
                <tr>
                    <td><strong>Nome do Cliente:</strong> <?=$linha['nome']?></td>
                    <td><strong>CPF:</strong> <?=$linha['cpf']?></td>
                </tr>
                <tr>
                    <td><strong>E-mail:</strong> <?=$linha['email']?></td>
                    <td><strong>Telefone:</strong> <?=$linha['telefone']?></td>
                </tr>
                <tr>
                    <td><strong>Atendente:</strong> <?=$linha['atendente'].' - '.$atendente['nome']?></td>
                    <td><strong>Status:</strong> <?=$statusChamado?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Descrição:</strong> <?=$linha['descricao']?></td>
                </tr>
                <?php if($linha['anexo']!=NULL and $linha['anexo']!=''){ ?>
                <tr>
                    <td>
                        <a href="assets/img/anexo-chamado/<?=$linha['anexo']?>" target="_blank">
                            <img src="assets/img/anexo-chamado/<?=$linha['anexo']?>" alt="" class="img-fluid">
                        </a>
                    </td>
                    <td></td>
                </tr>
                <?php } ?>
            </table>

            <?php if($linha['status']!=2){ ?>
            <div class="chattextarea">
                <textarea name="mensagem" class="resposta-chamado" placeholder="Digitar resposta"></textarea>
                <div class="chatbotoes">
                    <button class="btn btn-success btn-responder-chamado" onclick="responderChamado(<?=$linha['id']?>, <?=$linha['atendente']?>)">Responder</button>
                    <!-- <button class="btn btn-warning btn-finalizar-chamado" onclick="finalizarChamado(<?=$linha['id']?>, <?=$linha['atendente']?>)">Finalizar Chamado</button> -->
                </div>
            </div>
            <?php } ?>

            <div style="clear: both;"></div>

            <div class="chatcontent">
                <?php
                    $sqlHistoricoChamado = "SELECT * FROM tbl_suporte_historico WHERE id_suporte='$linha[id]' ORDER BY id DESC";
                    foreach ($pdo->query($sqlHistoricoChamado) as $historicoChamado) {
                        if($historicoChamado['id_atendente']!=NULL){
                            $atendente = $pdo->query("SELECT * FROM tbl_cadastros WHERE id=$historicoChamado[id_atendente]")->fetch();
                            $usuarioHistorico = $atendente['nome'];
                        }else{
                            $usuarioHistorico = $linha['nome'];
                        }

                        $dataHistorico = new DateTime($historicoChamado['dt_criacao']);
                ?>
                <div class="answer <?php if($historicoChamado['id_atendente']==NULL){ echo 'answer-left'; }else{ echo 'answer-right'; } ?>">
                    <strong><?=$usuarioHistorico?> - <?=$dataHistorico->format('d/m/Y')?> às <?=substr($historicoChamado['hr_criacao'],0,5)?>:</strong><br>
                    <?=$historicoChamado['descricao']?>
                </div>
                <? } ?>
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
                            <input type="text" class="form-control" id="telefoneCliente" name="telefoneCliente" required>
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

    function responderChamado(idChamado, idAtendente){
        var resposta = $('.resposta-chamado').val();
        if(resposta.length>0){
            $('#loading').show();

            $.post( "pages/suporte/salvar-resposta-chamado.php", {resposta: resposta, idChamado:idChamado, idAtendente:idAtendente}, function(data){
                $('#loading').hide();

                if(data==1){
                    swal({
                        title: "Resposta cadastrada com sucesso!",
                        text: "",
                        type: "success",
                        confirmButtonText: "OK"
                    });                      
                    
                    setTimeout(function() {
                        location.reload();
                    }, 2000);                        
                }else{
                    swal({
                        title: "Erro!",
                        text: "Ocorreu um erro ao tentar responder o chamado.",
                        type: "error",
                        confirmButtonText: "OK"
                    });                        
                }
            });
        }else{
            $('.resposta-chamado').css('border','1px solid red');
        }
    }    

    function finalizarChamado(idChamado, idAtendente){
        var resposta = $('.resposta-chamado').val();
        if(resposta.length>0){
            $('#loading').show();

            $.post( "pages/suporte/finalizar-chamado.php", {resposta: resposta, idChamado:idChamado, idAtendente:idAtendente}, function(data){
                $('#loading').hide();

                if(data==1){
                    swal({
                        title: "Chamado Finalizado",
                        text: "",
                        type: "success",
                        confirmButtonText: "OK"
                    });                      
                    
                    setTimeout(function() {
                        location.reload();
                    }, 2000);                        
                }else{
                    swal({
                        title: "Erro!",
                        text: "Ocorreu um erro ao tentar finalizar o chamado.",
                        type: "error",
                        confirmButtonText: "OK"
                    });                        
                }
            });
        }else{
            $('.resposta-chamado').css('border','1px solid red');
        }
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
            if($(this).val().length == 11){
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
</script>

<?php include('../../includes/footer.php'); ?>