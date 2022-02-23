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

<a href="https://api.whatsapp.com/send?phone=+5541992823979?text=Ol%c3%a1,%20eu%20preciso%20de%20ajuda!" alt="Precisa de ajuda? Envie uma WhatsApp!" style="position:fixed;width:60px;height:60px;bottom:40px;left:40px;background-color:#25d366;color:#FFF;border-radius:50px;text-align:center;font-size:30px;box-shadow: 1px 1px 2px #888; z-index:1000;" target="_blank">
	<i style="margin-top:16px" class="fab fa-whatsapp"></i>
</a>

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