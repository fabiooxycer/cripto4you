<?php
include('includes/header.php');
$pdo = BancoCadastros::conectar();

$id = null;
if (!empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM tbl_noticias WHERE id="' . $id . '"';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
?>

<section id="page-title" class="page-title bg-overlay bg-overlay-dark bg-parallax">
  <div class="bg-section">
    <img src="assets/images/page-titles/3.jpg" alt="Background" />
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="title title-6 text-center">
          <div class="title--heading">
            <h1><?php echo $data['titulo']; ?></h1>
          </div>
          <div class="clearfix"></div>
          <ol class="breadcrumb">
            <li><a href="./inicio">Início</a></li>
            <li><a href="./noticias">Notícias</a></li>
            <li class="active"><?php echo $data['titulo']; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="blog" class="blog blog-single">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-8">

        <div class="blog-entry">
          <div class="entry--img">
            <a href="#">
              <img src="broker/assets/img/noticias/<?php echo $data['imagem']; ?>" alt="<?php echo $data['titulo']; ?>" />
            </a>
          </div>
          <div class="entry--content clearfix">
            <div class="entry--date">
              <?php
              $dt_postagem = $data['dt_postagem'];
              $hr_postagem = $data['hr_postagem'];
              $timestamp = strtotime($hr_postagem);
              $timestamp2 = strtotime($hr_postagem);

              echo date('d/m/Y', $timestamp) . '&nbsp;às' . date('H:i:s', $timestamp2);
              ?>
            </div>
            <div class="entry--title">
              <h4><?php echo $data['titulo']; ?></h4>
            </div>
            <div class="entry--bio" align="justify">
              <p><?php echo $data['descricao']; ?></p>
            </div>
            <!-- <div class="entry--share">
              <span class="share--title">Compartilhe:</span>
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-google-plus"></i></a>
              <a href="#"><i class="fa fa-pinterest"></i></a>
            </div> -->

          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="widget widget-recent-posts">
          <div class="widget--title">
            <h5>Notícias Recentes</h5>
          </div>
          <div class="widget--content">

            <?php
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM tbl_noticias ORDER BY dt_postagem,hr_postagem DESC';

            foreach ($pdo->query($sql) as $noticias) {
              $dt_postagem = $noticias['dt_postagem'];
              $hr_postagem = $noticias['hr_postagem'];
              $timestamp = strtotime($hr_postagem);
              $timestamp2 = strtotime($hr_postagem);
            ?>
              <div class="entry">
                <div class="entry--img">
                  <a href="ver-noticia?id=<?php echo $noticias['id']; ?>"> <img src="broker/assets/img/noticias/<?php echo $noticias['imagem']; ?>" width="100%" alt="<?php echo $noticias['titulo']; ?>">
                    <div class="entry--overlay"></div>
                  </a>
                </div>
                <div class="entry--desc">
                  <div class="entry--title">
                    <a href="ver-noticia?id=<?php echo $noticias['id']; ?>"><?php echo $noticias['titulo']; ?></a>
                  </div>
                  <div class="entry--date">
                    <?php echo date('d/m/Y', $timestamp); ?> às <?php echo date('H:i:s', $timestamp2); ?>
                  </div>
                </div>
              </div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('includes/footer.php'); ?>