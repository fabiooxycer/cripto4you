<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
  $siteurl = 'http://localhost/prestes/painel';
} else {
  $siteurl = 'https://gestao-hml.digitalintelligentia.com';
} ?>

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

<script src="<?= $siteurl ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= $siteurl ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $siteurl ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= $siteurl ?>/assets/js/sb-admin-2.min.js"></script>
<!--
<script src="<?= $siteurl ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= $siteurl ?>/assets/js/demo/chart-area-demo.js"></script>
<script src="<?= $siteurl ?>/assets/js/demo/chart-pie-demo.js"></script>
-->
<script src="<?= $siteurl ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $siteurl ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= $siteurl ?>/assets/js/demo/datatables-demo.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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