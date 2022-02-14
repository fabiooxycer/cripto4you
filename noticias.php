<?php
include('includes/header.php');
$pdo = BancoCadastros::conectar();
?>

<section id="page-title" class="page-title bg-overlay bg-overlay-dark bg-parallax">
  <div class="bg-section">
    <img src="assets/images/page-titles/2.jpg" alt="Background" />
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="title title-6 text-center">
          <div class="title--heading">
            <h1>Notícias</h1>
          </div>
          <div class="clearfix"></div>
          <ol class="breadcrumb">
            <li><a href="./inicio">Início</a></li>
            <li class="active">Notícias</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="blog" class="blog blog-grid">
  <div class="container">
    <div class="row">

      <?php
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'SELECT * FROM tbl_noticias ORDER BY dt_postagem,hr_postagem DESC';

      foreach ($pdo->query($sql) as $noticias) {
        $dt_postagem = $noticias['dt_postagem'];
        $hr_postagem = $noticias['hr_postagem'];
        $timestamp = strtotime($hr_postagem);
        $timestamp2 = strtotime($hr_postagem);
      ?>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <div class="blog-entry">
            <div class="entry--img">
              <a href="ver-noticia?id=<?php echo $noticias['id']; ?>">
                <img src="broker/assets/img/noticias/<?php echo $noticias['imagem']; ?>" alt="<?php echo $noticias['titulo']; ?>" />
                <div class="entry--overlay"></div>
              </a>
            </div>
            <div class="entry--content">
              <div class="entry--title">
                <h4><a href="ver-noticia?id=<?php echo $noticias['id']; ?>"><?php echo $noticias['titulo']; ?></a></h4>
              </div>
              <div class="entry--footer">
                <div class="entry--date">
                  <?php echo date('d/m/Y', $timestamp); ?> às <?php echo date('H:i:s', $timestamp2); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

    </div>
</section>


<?php include('includes/footer.php'); ?>