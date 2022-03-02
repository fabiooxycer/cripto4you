</div>
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; <?php echo date('Y'); ?> | Todos os direitos reservados.</span>
    </div>
  </div>
</footer>
</div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- EXIBE MODAL DE LOGOFF -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Selecione "SAIR" se você realmente quer encerrar seu acesso atual.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCELAR</button>
        <a class="btn btn-primary" href="sair">SAIR</a>
      </div>
    </div>
  </div>
</div>
<!-- /EXIBE MODAL DE LOGOFF -->

<a href="https://api.whatsapp.com/send?phone=+5541992823979?text=Ol%c3%a1,%20eu%20preciso%20de%20ajuda!" title="Precisa de ajuda? Envie uma WhatsApp!" style="position:fixed;width:60px;height:60px;bottom:40px;left:40px;background-color:#25d366;color:#FFF;border-radius:50px;text-align:center;font-size:30px;box-shadow: 1px 1px 2px #888; z-index:1000;" target="_blank">
  <i style="margin-top:16px" class="fab fa-whatsapp"></i>
</a>

<?php if ($_SESSION['UsuarioContrato'] == 1) { ?>
  <script type="text/javascript">
    $(window).on('load', function() {
      $('#modalContrato').modal('show');
    });
  </script>

  <!-- Modal Contrato -->
  <div class="modal fade" id="modalContrato" tabindex="-1" role="dialog" aria-labelledby="modalContrato" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" ole="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">ACEITE DE CONTRATO</h5>
        </div>
        <form action="footer.php" method="post">
          <div class="modal-body">
            <div style="width: 100%; height:550px; overflow-y:scroll;">
              <br>
              <?php include('includes/contrato.php'); ?>
              <br>
              <br>
            </div>
          </div>
          <div class="modal-footer text-center">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> FECHAR</button>
            <button type="submit" name="contrato" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> CONCORDO</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
  // Chama função para pegar o POST de cada FORM
  function get_post_action($name)
  {
    $params = func_get_args();

    foreach ($params as $name) {
      if (isset($_POST[$name])) {
        return $name;
      }
    }
  }

  // Verifica qual botao foi clicado
  switch (get_post_action('contrato')) {

    case 'contrato':

      if (!empty($_POST)) {

        $id_usuario       = $_SESSION['UsuarioID'];
        $contrato_aceito  = 2;
      }

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'UPDATE tbl_usuarios SET contrato_aceito = ? WHERE id = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($contrato_aceito, $id_transacao));

      echo '<script>setTimeout(function () { 
                    swal({
                      title: "Parabéns!",
                      text: "Contrato aceito com sucesso!",
                      type: "success",
                      confirmButtonText: "OK" 
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        window.location.href = "dashboard";
                      }
                    }); }, 1000);</script>';

      break;

    default:
  }
}
?>


<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="assets/js/sb-admin-2.min.js"></script>
<!--
<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/js/demo/chart-area-demo.js"></script>
<script src="assets/js/demo/chart-pie-demo.js"></script>
-->
<script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/demo/datatables-demo.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- WYSIWYG Editor js -->
<script src="assets/wysiwyag/jquery.richtext.js"></script>
<script src="assets/wysiwyag/richText1.js"></script>

<!--Summernote js-->
<script src="assets/summernote/summernote-bs4.js"></script>
<script src="assets/summernote/summernote2.js"></script>

<script>
  $(document).ready(function() {
    $('.botao-faturamento').on('click', function() {
      $('.botao-faturamento .far').toggleClass('fa-eye-slash');
      $('.botao-faturamento .far').toggleClass('fa-eye');
      $('span.faturamento').toggleClass('hide');
    });
  });
</script>

</body>

</html>