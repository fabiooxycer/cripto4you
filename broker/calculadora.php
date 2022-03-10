<?php
if ($_SERVER['HTTP_HOST'] != 'localhost') {
   if (!isset($_SESSION)) session_start();

   $nivel = 1;

   if (!isset($_SESSION['UsuarioID']) or ($_SESSION['UsuarioNivel'] < $nivel)) {
      echo '<script>setTimeout(function () { 
            swal({
              title: "Oopss!",
              text: "Você não possui permissão para exibir esta tela!",
              type: "warning",
              confirmButtonText: "OK" 
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "entrar";
              }
            }); }, 1000);</script>';

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

<script>
   function removeMaskMoney(x) {
      x = "" + x;
      if ((x.replace(",", ".") != x)) {
         if (x.replace(".", "") != x) {
            aux = x;
            x = x.replace(".", "");
         } else {
            aux = x;
         }
         if (x.replace(",", ".") != x) {
            x = x.replace(",", ".")
         } else {
            x = aux;
         }
      }
      if (isNaN(parseFloat(x))) {
         x = 0;
      } else {
         x = parseFloat(x)
      }
      return x;
   }

   function tiraMascara(e) {
      value = removeMaskMoney($(e).val());
      $("[name=n1]").val(value)
   }
</script>

<script>
   $(document).on('keyup', '#valor', function() {
      $('#valor2').val($(this).val());
   });
</script>
<script>
   function calcular() {
      var n1 = parseInt(document.getElementById('n1').value);
      var n2 = parseInt(document.getElementById('n2').value);
      document.getElementById('diario').innerHTML = n1 / 100 * n2;
      document.getElementById('mensal').innerHTML = n1 / 100 * n2 * 30;
      document.getElementById('anual').innerHTML = n1 / 100 * n2 * 30 * 12;
   }
</script>

<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">
                        <li>CALCULADORA DE GANHOS</li>
                     </h4>
                  </div>
               </div>
               <div class="iq-card-body">
                  <p>Abaixo você pode calcular o lucro diário, mensal e anual de acordo com o valor de aporte pretendido</p>
                  <div class="form-body">
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="text" class="form-control" id="valor" name="valor" placeholder="Informe o Valor do Aporte. Ex.: 50.000,00" onblur="tiraMascara(this)" onKeyPress="return(moeda(this,'.',',',event))" autocomplete="off" required>
                              <input type="hidden" class="form-control" id="valor2" name="valor2" readonly>
                              <input type="hidden" class="form-control" id="n1" name="n1" readonly>
                              <input type="hidden" class="form-control" id="n2" name="n2" value="1" readonly>
                           </div>
                        </div>
                        <div class="col-md-2">
                           <div class="form-group">
                              <button class="btn btn-lg btn-outline-success" onclick="calcular()"><i class="fas fa-calculator"></i> Calcular</button><br><br>
                           </div>
                        </div>
                     </div>
                  </div>
                  <p>
                     <font size="4"><strong>Com o valor de aporte informado acima, seu lucro será de:</strong></font>
                  </p><br>
                  <li>
                     <font size="4"><strong>R$ <i id="diario"></i><i>,00</strong></font> &nbsp;diário</i>
                  <li>
                     <font size="4"><strong>R$ <i id="mensal"></i><i>,00</strong></font> &nbsp;mensal</i>
                  </li>
                  <li>
                     <font size="4"><strong>R$ <i id="anual"></i><i>,00</strong></font> &nbsp;anual</i>
                  </li><br>
                  <p>
                     <strong>Obs.:</strong> <i>Levar em consideração o cálculo de 10% de traxa de transação. Ex.: Lucro - 10%</i>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include('includes/footer.php'); ?>