<?php
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../includes/header.php');

$cpf = null;
if (!empty($_GET['cpf'])) {
    $cpf = $_REQUEST['cpf'];
}

$pdo = BancoCadastros::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM tbl_cadastros WHERE cpf = '" . $cpf . "'";
$q = $pdo->prepare($sql);
$q->execute(array($cpf));
$data = $q->fetch(PDO::FETCH_ASSOC);

$cpfCad = $data['cpf'];
?>

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
            <h4 class="m-0 font-weight-bold text-primary">LISTA DOS VÍNCULOS DE <strong><?php echo $data['nome']; ?></strong></h4>
            <br>
            <p class="mb-4">
                <button type="button" class="btn btn-dark mr-1" onClick="history.go(-1)">
                    <i class="icon-action-undo"></i> VOLTAR
                </button>
            </p>
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

                        $pdo = BancoCadastros::conectar();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo->prepare("SELECT meu_id FROM tbl_cadastros WHERE cpf =  '" . $cpfCad . "'");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        $idsVinculo = array();
                        foreach ($result as $r) {
                            $codVinculo = mask($r['meu_id'], "#####");
                            $vinculo .= $codVinculo . ',';
                            $idsVinculo = substr($vinculo, 0, -1);
                        }
                        //echo $idsVinculo;

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmtCad = $pdo->prepare("SELECT * FROM tbl_cadastros WHERE status = '1' AND id_vinculo IN ($idsVinculo) GROUP BY cpf ORDER BY nome ASC");
                        $stmtCad->execute();
                        $resultCad = $stmtCad->fetchAll();

                        foreach ($resultCad as $result) {

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
                            //echo '<td style="text-align: center; vertical-align:middle !important">';
                            //echo '<a class="btn btn-primary" title="Exibir Vínculos"  href="agentes-vinculos-exibir?cpf=' . $result['cpf'] . '"><i class="fa fa-link"></i></a></td>';
                            //echo '</td>';
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