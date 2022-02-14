<?php
include('../../includes/header.php');
?>


<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">PERÍCIAS AGUARDANDO PAGAMENTO</h6>
            <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style='text-align: center; vertical-align:middle !important'>PERÍCIA</th>
                            <th style='text-align: center; vertical-align:middle !important'>VALOR</th>
                            <th style='text-align: center; vertical-align:middle !important'>USUÁRIO</th>
                            <th style='text-align: center; vertical-align:middle !important'>CLIENTE</th>
                            <th style='text-align: center; vertical-align:middle !important'>DATA</th>
                            <th style='text-align: center; vertical-align:middle !important'>AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT * FROM tbl_cadastro_pericias WHERE pagamento_status = "pendente" ORDER BY dt_criacao ASC';

                        foreach ($pdo->query($sql) as $row) {
                            if ($row['id_pericia']) {
                                $id_pericia = '' . $row['id_pericia'] . '';
                            }
                            if ($row['valor']) {
                                $valor = '' . $row['valor'] . '';
                            }
                            if ($row['id_usuario']) {
                                $id_usuario = '' . $row['id_usuario'] . '';
                            }
                            if ($row['id_cliente']) {
                                $id_cliente = '' . $row['id_cliente'] . '';
                            }
                            if ($row['dt_criacao']) {
                                $dt_criacao = '' . strtotime($row['dt_criacao'])  . '';
                            }
                            echo "<tr>";
                            echo '<form action="pericias-aguardando-pagamento" method="POST">';
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $id_pericia . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $valor . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $id_usuario . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . $id_cliente . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important'><font size='3'>" . date('d/m/Y', $dt_criacao) . "</font></td>";
                            echo "<td style='text-align: center; vertical-align:middle !important' width=80>";
                            echo '<div align="center"><input type="hidden" name="id" id="id" value="' . $row['id'] . '" >';
                            //cho '&nbsp;<button type="submit" class="btn btn-sm btn-red" title="Desativar" name="desativar"><i  class="fa fa-eye"></i></button>';
                            echo "</form>";
                            echo '&nbsp;<a class="btn btn-sm btn-info" title="Editar" href="pericias-geradas-editar?id=' . $row['id'] . '"><i class="fa fa-eye"></i></a>';
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

<?php include('../../includes/footer.php'); ?>