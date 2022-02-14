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

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">LISTA DE AGENTES NÃO CADASTRADOS NOS APPS</h4>
            <p class="mb-4">Abaixo serão listados todos os agentes que não possuem cadastro em nenhum App.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>NOME</th>
                            <th style='text-align: center; vertical-align:middle !important'>CPF</th>
                            <th style='text-align: center; vertical-align:middle !important'>TELEFONE</th>
                            <th style='text-align: center; vertical-align:middle !important'>E-MAIL</th>
                            <th style='text-align: center; vertical-align:middle !important'>CEP</th>
                            <th style='text-align: center; vertical-align:middle !important'>ENDEREÇO</th>
                            <th style='text-align: center; vertical-align:middle !important'>BAIRRO</th>
                            <th style='text-align: center; vertical-align:middle !important'>CIDADE</th>
                            <th style='text-align: center; vertical-align:middle !important'>ESTADO</th>
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
                        require_once("../../includes/databaseApps.php");
                        $pdoApps = BancoApps::conectar();
                        
                        $pdoApps->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdoApps->prepare("SELECT cpf FROM tbl_usuarios");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        $cpfs = array();
                        foreach ($result as $r)
                        {
                            $cpf = mask($r['cpf'], '###.###.###-##');
                            array_push($cpfs,$cpf);
                        }
                   

                        require_once("../../includes/database.php");
                        $pdoCad = BancoCadastros::conectar();
                        $pdoCad->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmtCad = $pdoCad->prepare("SELECT DISTINCT * FROM tbl_cadastros where empresa IN (3,4,6,7,8) AND status = 1 AND cpf NOT IN ('.$cpfs.') group by cpf");
                        $stmtCad->execute();
                        $resultCad = $stmtCad->fetchAll();


                        foreach($resultCad as $result)
                        {
                            echo "<tr>";

                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['nome'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['cpf'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['telefone'] . " / " . $result['celular'] . "</strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['email'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['cep'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $result['endereco'] . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['bairro'] . "<strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['cidade'] . "<strong></font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $result['estado'] . "<strong></font></td>";
                        
                        }
                            echo "</tr>";
                            

                    

                    //     require_once("../../includes/databaseApps.php");
                    //     $pdo = BancoApps::conectar();
                    //     $sql2 = 'SELECT * FROM tbl_usuarios WHERE cpf != "' . $cpf_agente . '" ORDER BY nome ASC';
                    //     $sql2 = 'SELECT * FROM tbl_usuarios WHERE cpf NOT IN (' . $cpfsArray . ') ORDER BY nome ASC';
                    //     foreach ($pdo->query($sql) as $row2) {

                    //         if ($row['nome']) {
                    //             $nome = '' . $row['nome'] . '';
                    //         }
                    //         if ($row['cpf']) {
                    //             $cpf = '' . $row['cpf'] . '';
                    //         }
                    //         if ($row['telefone']) {
                    //             $telefone = '' . $row['telefone'] . '';
                    //         }
                    //         if ($row['celular']) {
                    //             $celular = '' . $row['celular'] . '';
                    //         }
                    //         if ($row['email']) {
                    //             $email = '' . $row['email'] . '';
                    //         }
                    //         if ($row['cep']) {
                    //             $cep = '' . $row['cep'] . '';
                    //         }
                    //         if ($row['endereco']) {
                    //             $endereco = '' . $row['endereco'] . '';
                    //         }
                    //         if ($row['bairro']) {
                    //             $bairro = '' . $row['bairro'] . '';
                    //         }
                    //         if ($row['cidade']) {
                    //             $cidade = '' . $row['cidade'] . '';
                    //         }
                    //         if ($row['estado']) {
                    //             $estado = '' . $row['estado'] . '';
                    //         }

                    //         echo "<tr>";

                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $nome . "</font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $cpf . "</font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $telefone . " / " . $celular . "</strong></font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $email . "</font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $cep . "</font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'>" . $endereco . "</font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $bairro . "<strong></font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $cidade . "<strong></font></td>";
                    //         echo "<td style='text-align: center; vertical-align:middle !important'><font size='2'><strong>" . $estado . "<strong></font></td>";
                        
                    // }
                    //     echo "</tr>";
                    //     BancoCadastros::desconectar();
                    //     BancoApps::desconectar()
                    //     ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>