<?php


//$codAgente = $_GET['idAgente'];
if (!isset($_SESSION)) session_start();

$nivel = 1;

if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
    echo "<script>alert('VOCÊ NÃO POSSUI PERMISSÃO PARA EXIBIR ESTÁ TELA!');location.href='entrar';</script>";
    exit;
}

include('../../../includes/header.php');
require_once("../../../includes/database.php");
$pdo = BancoCadastros::conectar();

$id_agente = $_GET['id_agente'];


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare(
    "SELECT cidade.municipio_codigo_ibge as codigo_ibge, cidade.municipio as municipio, uf.estado_sigla as uf 
    FROM tbl_municipios_ibge as cidade
    LEFT JOIN tbl_estados_ibge as uf
    ON cidade.estado_codigo_ibge = uf.estado_codigo_ibge
   
    ORDER BY municipio ASC");
$stmt->execute();
$cidades = $stmt->fetchAll();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare(
    "SELECT * 
    FROM tbl_cadastros
    WHERE id = :id_agente
    ");
$stmt->execute(array(
    ":id_agente" => $id_agente
));
$agente = $stmt->fetch();

?>

<div class="container-fluid">

    <!--
    <h1 class="h3 mb-2 text-gray-800">PERÍCIAS AGUARDANDO PAGAMENTO</h1>
    <p class="mb-4">Abaixo serão listadas todas as perícias aguardando pagamento.</p>
    -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">CIDADES DA AGENTE: <?=$agente['nome']?></h4>
            <h6 class="m-0 font-weight-bold text-primary">Empresa:
            <?php 
            if ($agente['empresa'] == 8)
            {
              echo 'Constellater';
            } 
            if ($agente['empresa'] == 7)
            {
              echo 'Intelligenz';
            } 
            if ($agente['empresa'] == 6)
            {
              echo 'Lavvor';
            }
            if ($agente['empresa'] == 4)
            {
              echo 'Digital Allocate';
            }
            if ($agente['empresa'] == 3)
            {
              echo 'Digital Intelligentia';
            }
            ?>
           </h6>
            <p class="mb-4"></p>
        </div>
        <div class="card-body">
        <form class="" method="POST" action="../pages/configuracoes/vinculo_cidades/salva_cidades.php">
          <div class="form-row">
            <input type="hidden" name="id_agente" value="<?=$id_agente?>">
            <select class="cidades form-control" name="cidades[]" multiple="multiple">
            <?php
            foreach ($cidades as $cidade)
            {
              ?>
              <option value="<?=$cidade['codigo_ibge']?>"> <?=$cidade['municipio']?> - <?=$cidade['uf']?> </option>
              <?php
            }
              ?>
            </select>
          </div><br>
          <div class="form-row">
            <input type="submit" class="btn btn-primary btn-block" value="Salvar">
          </div>
        </form> 
        </div>
    </div>
</div>





<?php
include('../../../includes/footer.php');

function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}


?>

<script>
    $(function(){
  $('#cod_estados').change(function(){
    if( $(this).val() ) {
      $('#cod_cidades').hide();
      $('.carregando').show();
      $.getJSON(
        'pages/configuracoes/cidades.ajax.php?',
        {
          cod_estados: $(this).val(),
          ajax: 'true'
        }, function(j){
          var options = '<option value=""></option>';
          for (var i = 0; i < j.length; i++) {
            options += '<option value="' +
              j[i].cod_cidades + '">' +
              j[i].nome + '</option>';
          }
          $('#cod_cidades').html(options).show();
          $('.carregando').hide();
          console.log(options);
        });
    } else {
      $('#cod_cidades').html(
        '<option value="">-- Escolha um estado --</option>'
      );
    }
  });
});

</script>

<script>
$(document).ready(function() {
    $('.cidades').select2();
});

</script>