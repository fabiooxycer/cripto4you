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
    <div class="ml-auto" align="right">
        <div>
            <button class="btn btn-blue mt-4 mt-sm-0" data-toggle="modal" data-target="#modalNovaNoticia"><i class="fa fa-plus mr-1 mt-1"></i> CADASTRAR</button>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">NOTÍCIAS</h4>
            <p class="mb-4">Abaixo serão listadas todas as noticias exbidas no site.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">DATA</th>
                            <th style='text-align: center; vertical-align:middle !important'>TÍTULO</th>
                            <th style='text-align: center; vertical-align:middle !important' width="15%">AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pdo = BancoCadastros::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM tbl_noticias ORDER BY dt_postagem,hr_postagem DESC";

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['dt_postagem']) {
                                $data_postagem = '' . $row['dt_postagem'] . '';
                                $timestamp = strtotime($data_postagem);
                                $dt_postagem = '<font size="2">' . date('d/m/Y', $timestamp) . ' </font>';
                            }
                            if ($row['hr_postagem']) {
                                $hora_postagem = '' . $row['hr_postagem'] . '';
                                $timestamp2 = strtotime($hora_postagem);
                                $hr_postagem = '<font size="2">' . date('H:i:s', $timestamp2) . ' </font>';
                            }

                            if ($row['titulo']) {
                                $titulo = '' . $row['titulo'] . '';
                            }

                            echo "<tr>";

                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $dt_postagem . " às " . $hr_postagem . "</font></td>";
                            echo "<td style='text-align: left; vertical-align:middle !important'><font size='3'><strong>" . $titulo . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            //echo '<a type="button" class="liberacaoInterna btn btn-sm btn-success" onclick="modalLiberar2(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO INTERNA"><i  class="fa fa-file-signature"></i></a>';
                            //echo ' <a type="button" class="liberacaoComprovante btn btn-sm btn-warning" onclick="modalComprovante(\'' . $row["id"] . '\', \'' . $_SESSION["UsuarioNome"] . '\', \'' . date("d/m/Y") . '\')" title="LIBERAÇÃO COM COMPROVANTE DE PGTO."><i  class="fa fa-vote-yea"></i></a>';
                            //echo ' <a type="button" class="reprocessar btn btn-sm btn-primary" data-id="' . $row['id'] . '" title="REPROCESSAR"><i  class="fa fa-share"></i></a>';
                            echo '&nbsp;<a class="btn btn-sm btn-warning" title="EDITAR" href="noticia-editar?id=' . $row['id'] . '"><i class="fa fa-edit"></i></a>';
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

<!-- Exibe o Modal para inserção dos Cliente -->
<div class="modal" id="modalCadastro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ADICIONAR NOVO CLIENTE</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <form action="clientes" method="post" enctype="multipart/form-data">
            <div class="form-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="basicInput">NOME</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="NOME COMPLETO DO CLIENTE" onChange="this.value=this.value.toUpperCase()" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="basicInput">CPF</label>
                    <input type="text" class="form-control auto3" id="cpf" name="cpf" placeholder="CPF DO CLIENTE" onkeyup="cpfCheck(this)" maxlength="18" onkeydown="javascript: fMasc( this, mCPF );" required> <span id="cpfResponse"></span></p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="basicInput">E-MAIL</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-MAIL DO CLIENTE" onChange="this.value=this.value.toLowerCase()" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="basicInput">TELEFONE</label>
                    <input type="text" class="form-control phone" id="telefone" name="telefone" placeholder="TELEFONE DO CLIENTE" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="basicInput">STATUS</label>
                    <select type="text" class="form-control" id="status" name="status" autocomplete="off" required>
                      <option>Selecione...</option>
                      <option value="1">ATIVO</option>
                      <option value="2">INATIVO</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" name="adicionar" class="btn btn-blue"><i class="fa fa-check"></i> CADASTRAR</button>
              <button type="button" class="btn btn-secondary text-white" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
            </div>
          </form>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>

<?php include('../../includes/footer.php'); ?>