<?php
require_once("includes/database.php");
$pdo = BancoCadastros::conectar();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare(
  "SELECT * 
    FROM tbl_cadastros
    WHERE municipio_codigo_ibge is null
    ORDER BY nome ASC"
);
$stmt->execute();
$agentes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
</head>

<body>
  <table>
    <tr>
      <th>ID Agente</th>
      <th>Nome do Agente</th>
      <th>Cidade do Cadastro</th>
      <th>Cidade IBGE</th>
      <th>ID Cidade IBGE</th>
      <th>UF do Cadastro</th>
      <th>UF IBGE</th>
      <th>ID UF IBGE</th>
    </tr>

    <?php
    foreach ($agentes as $agente) {
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare(
        "SELECT municipio.municipio_codigo_ibge as codMunicipioIbge,
                municipio.municipio as municipioIbge,
                uf.estado_codigo_ibge as codUfIbge,
                uf.estado_sigla ufIbge
        FROM tbl_municipios_ibge as municipio
        LEFT JOIN tbl_estados_ibge as uf
        ON municipio.estado_codigo_ibge = uf.estado_codigo_ibge
        WHERE municipio.municipio = :municipioCadastro  
              
        "
      );

      $stmt->execute(array(
        ':municipioCadastro' => $agente['cidade']
      ));
      $cidade =  $stmt->fetch();

      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // $stmt = $pdo->prepare("UPDATE tbl_cadastros set municipio_codigo_ibge = :municipio_codigo_ibge WHERE id = :id");
      // $stmt->execute(array(
      //     ':municipio_codigo_ibge' => $cidade['codMunicipioIbge'],
      //     ':id' => $agente['id']
      // ));


    ?>

      <tr>
        <td><?php echo $agente['id']; ?></td>
        <td><?php echo $agente['nome']; ?></td>
        <td><?php echo $agente['cidade']; ?></td>
        <td><?php echo $cidade['municipioIbge']; ?></td>
        <td><?php echo $cidade['codMunicipioIbge']; ?></td>
        <td><?php echo $agente['estado']; ?></td>
        <td><?php echo $cidade['ufIbge']; ?></td>
        <td><?php echo $cidade['codUfIbge']; ?></td>

      </tr>
    <?php
    }
    ?>
  </table>

</body>

</html>