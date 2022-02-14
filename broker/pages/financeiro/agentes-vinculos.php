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
                [0, "asc"]
            ]
        });
    });
</script>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">LISTA DE AGENTES CADASTRADOS</h4>
            <p class="mb-4">Abaixo serão listados todos os cadastrados.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>NOME</th>
                            <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                            <th style='text-align: center; vertical-align:middle !important'>TELEFONE</th>
                            <th style='text-align: center; vertical-align:middle !important'>CELULAR</th>
                            <th style='text-align: center; vertical-align:middle !important'>E-MAIL</th>
                            <th style='text-align: center; vertical-align:middle !important'>CIDADE</th>
                            <th style='text-align: center; vertical-align:middle !important'>ESTADO</th>
                            <th style='text-align: center; vertical-align:middle !important'>ATUAÇÃO</th>
                            <th style='text-align: center; vertical-align:middle !important'>AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function mask($val, $mask)
                        {
                            $maskared = '';
                            $k = 0;
                            for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
                                if ($mask[$i] == '#') {
                                    if (isset($val[$k])) {
                                        $maskared .= $val[$k++];
                                    }
                                } else {
                                    if (isset($mask[$i])) {
                                        $maskared .= $mask[$i];
                                    }
                                }
                            }

                            return $maskared;
                        }
                        //require_once("../../includes/database.php");
                        $pdo = BancoCadastros::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT * FROM tbl_cadastros where nome != 'DIGITAL INTELLIGENCIA' AND nome != 'FIROOZ ALEXANDER SEFRE' AND empresa IN (3,4,6,7,8) AND atuacao IN (1,2) AND status = '1' AND id_vinculo is not null group by cpf";

                        foreach ($pdo->query($sql) as $result) {

                            if ($result['atuacao'] == '1') {
                                $atuacao = 'AEN';
                            }
                            if ($result['atuacao'] == '2') {
                                $atuacao = 'AEM';
                            }
                            echo "<tr>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['nome'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['cpf'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['telefone'] . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['celular'] . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['email'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['cidade'] . "<strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['estado'] . "<strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $atuacao . "<strong></font></td>";
                            echo '<td style="text-align: center; vertical-align:middle !important">';
                            echo '<a class="btn btn-primary" title="Exibir AEM Vinculados"  href="agentes-vinculos2?cpf=' . $result['cpf'] . '"><i class="fa fa-link"></i></a></td>';
                            echo '</td>';
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>