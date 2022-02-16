<?php
include('includes/header.php');
include('includes/slideshow.php');
?>

<section id="servicos" class="featured featured-2 text-center pb-50">
    <div class="container">
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                <div class="heading heading-4 mb-50 text--center">
                    <p class="heading--subtitle">Conheça</p>
                    <h2 class="heading--title">Nossos Serviços</h2>
                    <p class="heading--desc mb-0">Aplicamos as melhores metodologias do mercado financeiro, para ajuda-lo a conquistar sua independência financeira. </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 wow fadeInUp" data-wow-delay="100ms">
                <div class="feature-card">
                    <div class="feature-card-icon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="feature-card-content">
                        <h3 class="feature-card-title">Proteção & Segurança</h3>
                        <p class="feature-card-desc">Trabalhamos com Stop loss e take profit ajudarão a proteger seu investimento. O sistema executará automaticamente as negociações para obter ganhos.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 wow fadeInUp" data-wow-delay="200ms">
                <div class="feature-card">
                    <div class="feature-card-icon">
                        <i class="fa fa-signal"></i>
                    </div>
                    <div class="feature-card-content">
                        <h3 class="feature-card-title">Operações </h3>
                        <p class="feature-card-desc">Executamos operações com diversas criptomoedas do mercado, trazendo assim uma carteira de ativos com maior rentabilidade para nossos clientes.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 wow fadeInUp" data-wow-delay="300ms">
                <div class="feature-card">
                    <div class="feature-card-icon">
                        <i class="fa fa-dollar"></i>
                    </div>
                    <div class="feature-card-content">
                        <h3 class="feature-card-title">Investimento</h3>
                        <p class="feature-card-desc">Deixe seu dinheiro trabalhar por você. Aumente seu investimento quando quiser. Obtenha sua independência financeira!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="quero-investir" class="pricing pricing-1 pb-80">
    <div class="bg-section">
        <img src="assets/images/background/9.jpg" alt="background">
    </div>
    <div class="container">
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                <div class="heading heading-1 text--center mb-70">
                    <p class="heading--subtitle">Invista Já!</p>
                    <h2 class="heading--title text-white">Nossos Preços</h2>
                    <p class="heading--desc text-white mb-0">Escolha um plano abaixo, e inicie agora sua rentabilidade no mundo cripto.</p>
                </div>
            </div>
        </div>
        <div class="row">

            <div class=" col-xs-12 col-sm-12 col-md-4 price-table wow fadeInUp" data-wow-delay="100ms">
                <div class="pricing-panel">

                    <div class="pricing--heading text--center">
                        <div class="pricing--icon">
                            <img src="assets/images/icons/BitcoinIcon4.png" alt="Bitcoin Icon">
                        </div>
                        <h4>Starter Crypto Plan</h4>
                        <p>8<span class="currency">%</span></p>
                        <div class="pricing--desc">
                            Obtenha uma lucratividade de 8% ao mês.
                        </div>
                        <a class="btn btn--secondary btn--bordered btn--rounded" href="https://api.whatsapp.com/send?phone=<?php echo $contato['whatsapp']; ?>?text=Ol%c3%a1,%20eu%20gostaria%20de%20investir%20entre%20R$%205.000,00%20a%20R$%2050.000,00." target="_blank">INVESTIR</a>
                    </div>

                    <div class="pricing--footer">
                        Para Investimentos <br>de R$ 5.000,00 a R$ 50.000,00
                    </div>

                </div>
            </div>


            <div class=" col-xs-12 col-sm-12 col-md-4 price-table pricing-active wow fadeInUp" data-wow-delay="200ms">
                <div class="pricing-panel">

                    <div class="pricing--heading text--center">
                        <div class="pricing--icon">
                            <img src="assets/images/icons/BitcoinIcon5.png" alt="Bitcoin Icon">
                        </div>
                        <h4>Advanced Crypto Plan</h4>
                        <p>12<span class="currency">%</span></p>
                        <div class="pricing--desc">
                            Obtenha uma lucratividade de 12% ao mês.
                        </div>
                        <a class="btn btn--white btn--bordered btn--rounded" href="https://api.whatsapp.com/send?phone=<?php echo $contato['whatsapp']; ?>?text=Ol%c3%a1,%20eu%20gostaria%20de%20investir%20entre%20R$%2050.000,00%20a%20R$%20200.000,00." target="_blank">INVESTIR</a>
                    </div>

                    <div class="pricing--footer">
                        Para Investimentos <br>de R$ 50.000,00 a R$ 200.000,00
                    </div>

                </div>
            </div>


            <div class=" col-xs-12 col-sm-12 col-md-4 price-table wow fadeInUp" data-wow-delay="300ms">
                <div class="pricing-panel">

                    <div class="pricing--heading text--center">
                        <div class="pricing--icon">
                            <img src="assets/images/icons/BitcoinIcon4.png" alt="Bitcoin Icon">
                        </div>
                        <h4>Premium Crypto Plan</h4>
                        <p>15<span class="currency">%</span></p>
                        <div class="pricing--desc">
                            Obtenha uma lucratividade de 15% ao mês.
                        </div>
                        <a class="btn btn--secondary btn--bordered btn--rounded" href="https://api.whatsapp.com/send?phone=<?php echo $contato['whatsapp']; ?>?text=Ol%c3%a1,%20eu%20gostaria%20de%20investir%20acima%20de%20R$%20200.000,00." target="_blank">INVESTIR</a>
                    </div>

                    <div class="pricing--footer">
                        Para Investimentos <br>acima de R$ 200.000,00
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- 
<section id="testimonia1" class="testimonial testimonial-wide testimonial-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 wow fadeInUp" data-wow-delay="100ms">
                <div id="testimonial-wide" class="carousel carousel-navs" data-slide="1" data-slide-rs="1" data-autoplay="false" data-nav="true" data-dots="false" data-space="0" data-loop="true" data-speed="800">

                    <div class="testimonial-panel">
                        <div class="testimonial--icon"></div>
                        <div class="testimonial--body">
                            <p>“Highly recommended & a great experience. The process was simple and easy to understand. Trading was straight forward, supports all major cryptocurrencies and the entire process was super smooth!”</p>
                        </div>
                        <div class="testimonial--meta">
                            <div class="testimonial--meta-img">
                                <img src="assets/images/testimonial/2.png" alt="Testimonial Author">
                            </div>
                            <h4>Mahmoud Baghagho</h4>
                            <p>7oroof Agency</p>
                        </div>
                    </div>

                    <div class="testimonial-panel">
                        <div class="testimonial--icon"></div>
                        <div class="testimonial--body">
                            <p>“Highly recommended & a great experience. The process was simple and easy to understand. Trading was straight forward, supports all major cryptocurrencies and the entire process was super smooth!”</p>
                        </div>
                        <div class="testimonial--meta">
                            <div class="testimonial--meta-img">
                                <img src="assets/images/testimonial/1.png" alt="Testimonial Author">
                            </div>
                            <h4>ayman fikry</h4>
                            <p>zytheme</p>
                        </div>
                    </div>

                    <div class="testimonial-panel">
                        <div class="testimonial--icon"></div>
                        <div class="testimonial--body">
                            <p>“Highly recommended & a great experience. The process was simple and easy to understand. Trading was straight forward, supports all major cryptocurrencies and the entire process was super smooth!”</p>
                        </div>
                        <div class="testimonial--meta">
                            <div class="testimonial--meta-img">
                                <img src="assets/images/testimonial/3.png" alt="Testimonial Author">
                            </div>
                            <h4>Fouad badawy</h4>
                            <p>Tie Labs Inc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section id="contato" class="consultation consultation-1 pb-0">
    <div class="bg-section">
        <img src="assets/images/background/8.jpg" alt="Background" />
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="heading heading-2 mb-50">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7">
                            <h2 class="heading--title text-white"><span class="text-theme">Descobrir</span><span class="text-white"> Milhares de Oportunidades de Negociação e Investimento.</span></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <p class="heading--desc">Operamos de forma rápida, fácil e segura. Com grande alavancagem de negociação e margem. Comece a negociar conosco em segundos.</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <p class="heading--desc">As criptomoedas tornaram-se commodities de investimento estabelecidas entre as principais instituições financeiras e até foram adotadas por alguns países. Como em qualquer investimento, existem riscos ligados aos movimentos do mercado, mas trabalhamos com Proteção & Segurança!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="consultation-form mb-30 bg-white text-center">
                    <div class="consultation--desc">
                        Solicite nossa Consultoria
                    </div>
                    <form class="mb-0" action="includes/email-contato.php method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <input type="text" class="form-control" name="nome" id="nome" placeholder="Seu Nome" required>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Seu E-mail">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Seu Telefone">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <textarea class="form-control" name="mensagem" id="mensagem" rows="2" placeholder="Sua mensagem..."></textarea>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" name="contato" class="btn btn--primary btn--block">ENVIAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>