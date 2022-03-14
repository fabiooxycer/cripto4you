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
include('includes/menu.php');
include('includes/topnavbar.php');
include('includes/scripts.php');
?>

<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">
                        <li>CLIENTES CADASTRADOS</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo será listado todos os clientes cadastrados na plataforma</p>
                  <div class="ml-auto" align="left">
                     <div>
                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalNovoUsuario" title="ADICIONAR USUÁRIO/CLIENTE"><i class="fas fa-user-plus"></i> Adicionar</button>
                     </div>
                  </div><br>
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important'>Nome</th>
                              <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                              <th style='text-align: center; vertical-align:middle !important'>Telefone</th>
                              <th style='text-align: center; vertical-align:middle !important'>E-mail</th>
                              <th style='text-align: center; vertical-align:middle !important'>Dt. Cadastro</th>
                              <th style='text-align: center; vertical-align:middle !important'>Cont. Aceito?</th>
                              <th style='text-align: center; vertical-align:middle !important'>Retirada?</th>
                              <th style='text-align: center; vertical-align:middle !important'>Dt. Retirada</th>
                              <th style='text-align: center; vertical-align:middle !important'>Situação</th>
                              <th style='text-align: center; vertical-align:middle !important'>Acesso</th>
                              <th style='text-align: center; vertical-align:middle !important' width="12%">Ação</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           $sql = "SELECT * FROM tbl_usuarios WHERE id != '1' ORDER BY nome ASC";

                           foreach ($pdo->query($sql) as $row) {

                              if ($row['nome']) {
                                 $nome = '' . $row['nome'] . '';
                              }
                              if ($row['cpf']) {
                                 $cpf = '' . $row['cpf'] . '';
                              }
                              if ($row['telefone']) {
                                 $telefone = '' . $row['telefone'] . '';
                              }
                              if ($row['email']) {
                                 $email = '' . $row['email'] . '';
                              }
                              if ($row['dt_cadastro']) {
                                 $data_cadastro = '' . $row['dt_cadastro'] . '';
                              }
                              if ($row['tipo_contrato'] == 1) {
                                 $contrato = 'DIÁRIO';
                              }
                              if ($row['tipo_contrato'] == 2) {
                                 $contrato = 'MENSAL';
                              }
                              if ($row['tipo_contrato'] == 3) {
                                 $contrato = 'QUINZENAL';
                              }
                              if ($row['contrato_aceito'] == 2) {
                                 $aceite_contrato = '<font color="green"> SIM </font>';
                              }
                              if ($row['contrato_aceito'] == 1) {
                                 $aceite_contrato = '<font color="red"> NÃO </font>';
                              }
                              if ($row['dt_saque']) {
                                 $saque = '' . $row['dt_saque'] . '';
                              }
                              if ($row['status'] == 1) {
                                 $status = '<font color="green"> ATIVO </font>';
                              }
                              if ($row['status'] == 2) {
                                 $status = '<font color="red"> INATIVO </font>';
                              }
                              if ($row['nivel'] == 1) {
                                 $nivel = '<font color="blue"> CLIENTE </font>';
                              }
                              if ($row['nivel'] == 99) {
                                 $nivel = '<font color="orange"> OPERADOR </font>';
                              }
                              if ($row['nivel'] == 100) {
                                 $nivel = '<font color="#666666"> ADMINISTRADOR </font>';
                              }

                              echo "<tr>";
                              echo "<td style='text-align: left; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $cpf . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $telefone . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $email . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . converte($data_cadastro, 2) . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $aceite_contrato . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $contrato . "</font></td>";
                              if ($row['dt_saque'] != '0000-00-00') {
                                 if ($row['dt_saque'] == date('Y-m-d')) {
                                    echo "<td style='text-align: center; vertical-align:middle !important'><font size='2' color='red'><strong>" . converte($saque, 2) . "</strong></font></td>";
                                 } else {
                                    echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . converte($saque, 2) . "</font></td>";
                                 }
                              } else {
                                 echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>-</font></td>";
                              }
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $status . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nivel . "</font></td>";
                              echo "<td style='text-align: center; vertical-align:middle !important'>";
                              echo '<form action="clientes" method="POST">';
                              echo '<a class="btn btn-sm btn-outline-info" title="MOVIMENTAÇÕES" href="clientes-movimentacao?id=' . $row['id'] . '"><i class="fa fa-list"></i></a>';
                              echo '&nbsp;<a class="btn btn-sm btn-outline-warning" title="EDITAR" href="clientes-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
                              echo '<input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                              if ($row['status'] == 1) {
                                 echo '&nbsp;<button type="submit" title="DESATIVAR" class="btn btn-sm btn-outline-danger" name="desativar"><i  class="fa fa-thumbs-down"></i></button>';
                              } else {
                                 echo '&nbsp;<button type="submit" title="ATIVAR" class="btn btn-sm btn-outline-success" name="ativar"><i  class="fa fa-thumbs-up"></i></button>';
                              }
                              echo '&nbsp;<button type="submit" title="REDEFINIR SENHA" class="btn btn-sm btn-outline-secondary" name="redefinir"><i  class="fa fa-key"></i></button>';
                              echo "</form>";
                              echo "</td>";
                           }
                           echo "</tr>";
                           ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th style='text-align: center; vertical-align:middle !important'>Nome</th>
                              <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                              <th style='text-align: center; vertical-align:middle !important'>Telefone</th>
                              <th style='text-align: center; vertical-align:middle !important'>E-mail</th>
                              <th style='text-align: center; vertical-align:middle !important'>Dt. Cadastro</th>
                              <th style='text-align: center; vertical-align:middle !important'>Cont. Aceito?</th>
                              <th style='text-align: center; vertical-align:middle !important'>Retirada?</th>
                              <th style='text-align: center; vertical-align:middle !important'>Dt. Retirada</th>
                              <th style='text-align: center; vertical-align:middle !important'>Situação</th>
                              <th style='text-align: center; vertical-align:middle !important'>Acesso</th>
                              <th style='text-align: center; vertical-align:middle !important' width="11%">Ação</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Exibe o Modal para inserção dos Cliente -->
<div class="modal fade" id="modalNovoUsuario" tabindex="-1" role="dialog" aria-labelledby="modalNovoUsuario" aria-hidden="true">
   <div class="modal-dialog modal-xl " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><i class=" fa fa-user-plus"></i> Adicionar Novo Cliente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <form action="clientes" method="post" enctype="multipart/form-data">
               <div class="form-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="basicInput">Nome</label>
                           <input type="text" class="form-control" id="nome" name="nome" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="basicInput">RG</label>
                           <input type="text" class="form-control" id="rg" name="rg" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="basicInput">CPF</label>
                           <input type="text" class="form-control" id="cpf" name="cpf" onkeyup="cpfCheck(this)" maxlength="18" onkeydown="javascript: fMasc( this, mCPF );" autocomplete="off" required><span id="cpfResponse"></span></p>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="basicInput">Telefone</label>
                           <input type="text" class="form-control phone" id="telefone" name="telefone" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-9">
                        <div class="form-group">
                           <label for="basicInput">E-mail</label>
                           <input type="email" class="form-control" id="email" name="email" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">CEP</label>
                           <input type="text" class="form-control" id="cep" name="cep" onchange="pesquisacep(this.value);" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-9">
                        <div class="form-group">
                           <label for="basicInput">Endereço</label>
                           <input type="text" class="form-control" id="endereco" name="endereco" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Número</label>
                           <input type="text" class="form-control" id="numero" name="numero" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Complemento</label>
                           <input type="text" class="form-control" id="complemento" name="complemento" onChange="this.value=this.value.toUpperCase()" autocomplete="off">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Bairro</label>
                           <input type="text" class="form-control" id="bairro" name="bairro" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Cidade</label>
                           <input type="text" class="form-control" id="cidade" name="cidade" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Estado</label>
                           <input type="text" class="form-control" id="estado" name="estado" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">PIX</label>
                           <select type="text" class="form-control" id="tipo_pix" name="tipo_pix" autocomplete="off" onchange="verifica(this.value)" required>
                              <option value="">Selecione...</option>
                              <option value="Chave Aleatória">Chave Aleatória</option>
                              <option value="E-mail">E-mail</option>
                              <option value="CNPJ">CNPJ</option>
                              <option value="CPF">CPF</option>
                              <option value="Telefone">Telefone</option>
                              <option value="Não Possuo">Não Possuo</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="basicInput">Chave PIX</label>
                           <input type="text" class="form-control" id="chave" name="chave" autocomplete="off">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Tipo de Contrato</label>
                           <select type="text" class="form-control" id="tipo_contrato" name="tipo_contrato" onchange="contrato()" autocomplete="off" required>
                              <option value="">Selecione...</option>
                              <option value="1">Diário</option>
                              <option value="2">Mensal</option>
                              <option value="3">Quinzenal</option>
                           </select>
                        </div>
                     </div>
                     <div id="t_contrato_lbl" for="t_contrato_tipo" style="display: none" class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Data para Saque:</label>
                           <input type="date" class="form-control" id="dt_saque" name="dt_saque" autocomplete="off">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="basicInput">Nível Acesso</label>
                           <select type="text" class="form-control" id="nivel" name="nivel" autocomplete="off" required>
                              <option value="">Selecione...</option>
                              <option value="1">Cliente</option>
                              <option value="99">Operador</option>
                              <option value="100">Administrador</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer"></div>
               <div class="form-actions" align="right">
                  <button type="submit" name="adicionar" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> CADASTRAR</button>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

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

switch (get_post_action('desativar', 'ativar', 'adicionar', 'redefinir')) {

   case 'desativar':

      if (!empty($_POST)) {

         $id          = $_POST['id'];
         $status_down = '2';

         $validacao = true;
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'UPDATE tbl_usuarios SET status = ? WHERE id = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($status_down, $id));
      echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Cliente/Usuário desativado com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes";
              }
            }); }, 1000);</script>';
      break;

   case 'ativar':

      if (!empty($_POST)) {

         $id          = $_POST['id'];
         $status_up = '1';

         $validacao = true;
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'UPDATE tbl_usuarios SET status = ? WHERE id = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($status_up, $id));
      echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Cliente/Usuário ativado com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes";
                  }
                }); }, 1000);</script>';
      break;

   case 'adicionar':

      if (!empty($_POST)) {

         $nome          = $_POST['nome'];
         $rg            = $_POST['rg'];
         $cpf           = $_POST['cpf'];
         $telefone      = $_POST['telefone'];
         $email         = $_POST['email'];
         $cep           = $_POST['cep'];
         $endereco      = $_POST['endereco'];
         $numero        = $_POST['numero'];
         $complemento   = $_POST['complemento'];
         $bairro        = $_POST['bairro'];
         $cidade        = $_POST['cidade'];
         $estado        = $_POST['estado'];
         $tipo_pix      = $_POST['tipo_pix'];
         $chave         = $_POST['chave'];
         $tipo_contrato = $_POST['tipo_contrato'];
         $dt_saque      = $_POST['dt_saque'];
         $status        = '1';
         $nivel         = $_POST['nivel'];
         $dt_cadastro   = date("Y-m-d");

         if ($complemento == '') {
            $complemento = '-';
         }
         if ($chave == '') {
            $chave = '-';
         }
         if ($dt_saque == '') {
            $dt_saque = '0000-00-00';
         }
      }
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'SELECT * FROM tbl_usuarios WHERE cpf = "' . $_POST['cpf'] . '"';
      $q = $pdo->prepare($sql);
      $q->execute(array($_POST['cpf']));
      $data = $q->fetch(PDO::FETCH_ASSOC);

      if ($data['cpf'] != $_POST['cpf']) {

         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = "INSERT INTO tbl_usuarios (nome, rg, cpf, telefone, email, cep, endereco, numero, complemento, bairro, cidade, estado, tipo_pix, chave, tipo_contrato, dt_saque, status, nivel, dt_cadastro) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
         $q = $pdo->prepare($sql);
         $q->execute(array($nome, $rg, $cpf, $telefone, $email, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $tipo_pix, $chave, $tipo_contrato, $dt_saque, $status, $nivel, $dt_cadastro));


         $sql2 = 'SELECT * FROM tbl_usuarios ORDER BY id DESC limit 1';
         foreach ($pdo->query($sql2) as $usuario) {

            $usuario_nome = $usuario['nome'];
            if ($usuario['tipo_contrato'] == 1) {
               $tipo_contrato = 'DIÁRIO';
            }
            if ($usuario['tipo_contrato'] == 2) {
               $tipo_contrato = 'MENSAL';
            }
         }

         require('includes/phpmailer/hdw-phpmailer.php');


         $emailAssunto  = 'Cadastro | Cripto4You';
         $emailMensagem = "
            <style type='text/css'>
            <!--
            .style1 {
                font-family: Geneva, Arial, Helvetica, sans-serif;
                color: #333333;
                font-size: 18px;
            }
            a:link {
                color: #CC9900;
                text-decoration: none;
            }
            a:visited {
                text-decoration: none;
                color: #333333;
            }
            a:hover {
                text-decoration: none;
                color: #333333;
            }
            a:active {
                text-decoration: none;
                color: #333333;
            }
            -->
            </style>
            <p align='center'>&nbsp;</p>
            <p align='center'><img src='https://cripto4you.net/assets/images/email/header_email.png' width='980' height='150'></p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center' class='style1'>Ol&aacute; {$usuario_nome},</p>
            <p align='center' class='style1'>Seu cadastro foi realizado com sucesso em nossa plataforma.</p>
            <p align='center' class='style1'>Para acesso, clique no link abaixo, entre com seu e-mail e CPF, ap&oacute;s ser&aacute; solicitado o cadastro da sua senha de acesso. N&atilde;o utilize uma senha f&aacute;cil, tente mesclar em letras (mai&uacute;sculas e min&uacute;sculas), n&uacute;meros e caracteres especiais.</p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center' class='style1'><a href='htttps://broker.cripto4you.net' target='_blank'>https://broker.cripto4you.net </a></p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center' class='style1'>Obrigado,</p>
            <p align='center' class='style1'>&nbsp;</p>
            <p align='center'><img src='https://cripto4you.net/assets/images/email/footer_email.png' width='350' height='130'></p>
            <br />
<br />
";

         $id_smtp =  '1';
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = 'SELECT * FROM tbl_smtp';
         $q = $pdo->prepare($sql);
         $q->execute(array($id_smtp));
         $contato = $q->fetch(PDO::FETCH_ASSOC);

         $email_de        = $contato['email_de'];
         $email_para      = $usuario['email'];
         $email_para_nome = $usuario['nome'];
         $host_smtp       = $contato['host_smtp'];
         $porta_smtp      = $contato['porta_smtp'];
         $encrypt_smtp    = $contato['encrypt_smtp'];
         $email_login     = $contato['email_login'];
         $email_senha     = $contato['email_senha'];
         $emailDe          = array();

         $emailDe['from']        = $email_de;
         $emailDe['fromName']    = $contato['email_para_nome'];
         $emailDe['replyTo']     = $email;
         $emailDe['returnPath']  = $email_de;
         $emailDe['confirmTo']   = '';
         $emailPara              = array();
         $emailPara[1]['to']     = $email_para;
         $emailPara[1]['toName'] = $email_para_nome;
         // #2
         //$emailPara[2]['to']		= 'seuemail2@seudominio.com.br';
         //$emailPara[2]['toName']	= 'Seu Nome2';

         $SMTP             = array();
         $SMTP['host']     = $host_smtp;
         $SMTP['port']     = $porta_smtp;
         $SMTP['encrypt']  = $encrypt_smtp;
         $SMTP['username'] = $email_login;
         $SMTP['password'] = $email_senha;
         $SMTP['charset']  = 'utf-8';
         $SMTP['priority'] = 1;
         $SMTP['debug']    = FALSE;

         $mail = sendEmail($emailDe, $emailPara, $emailAssunto, $emailMensagem, $SMTP);

         if ($mail !== TRUE) {
            echo ('Nao foi possivel enviar a mensagem.<br />Erro: ' . $mail);
            exit;
         }


         echo '<script>setTimeout(function () { 
            swal({
              title: "Parabéns!",
              text: "Cliente/Usuário cadastrado com sucesso!",
              type: "success",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "clientes";
              }
            }); }, 1000);</script>';
      }
      if ($data['cpf'] == $_POST['cpf']) {
         echo '<script>setTimeout(function () { 
                swal({
                  title: "Atenção!",
                  text: "Cliente/Usuário já possui cadastro!",
                  type: "warning",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes";
                  }
                }); }, 1000);</script>';
      }
      break;

   case 'redefinir':

      if (!empty($_POST)) {

         $id    = $_POST['id'];
         $senha = '';

         $validacao = true;
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'UPDATE tbl_usuarios SET senha = ? WHERE id = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($senha, $id));
      echo '<script>setTimeout(function () { 
                swal({
                  title: "Parabéns!",
                  text: "Redefinição de senha realizada com sucesso!",
                  type: "success",
                  confirmButtonText: "OK" 
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "clientes";
                  }
                }); }, 1000);</script>';
      break;

   default:
}

include('includes/footer.php');
?>