<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-navbar-logo d-flex justify-content-between">
        <a href="dashboard" class="header-logo">
            <img src="assets/images/logo.png" class="img-fluid rounded" alt="Cripto4You">
        </a>
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="main-circle"><i class="ri-menu-line"></i></div>
                <div class="hover-circle"><i class="ri-close-fill"></i></div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li>
                    <a href="dashboard" class="iq-waves-effect"><i class="fa fa-tachometer iq-arrow-left"></i><span>Dashboard</span></a>
                </li>

                <?php if ($_SESSION['UsuarioNivel'] >= '1') { ?>
                    <hr class="sidebar-divider">
                    <div class="sidebar-heading">
                        Broker
                    </div>
                    <li aria-expanded="true">
                        <a href="#investimento" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-fw fa-coins iq-arrow-left"></i><span>Investimento</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="investimento" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <li><a href="meu-investimento"><i class="fa fa-list"></i>Extrato</a></li>
                        </ul>
                    </li>
                    <hr class="sidebar-divider">
                <?php } ?>

                <?php if ($_SESSION['UsuarioNivel'] >= '98') { ?>
                    <div class="sidebar-heading">
                        Gestão
                    </div>
                    <?php if ($_SESSION['UsuarioNivel'] >= '100') { ?>
                        <li aria-expanded="true">
                            <a href="#clientes" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-fw fa-coins iq-arrow-left"></i><span>Clientes</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="clientes" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li><a href="clientes"><i class="fa fa-users"></i>Listar</a></li>
                            </ul>
                        </li>
                <?php }
                } ?>

                <?php if ($_SESSION['UsuarioNivel'] >= '98') { ?>
                    <li aria-expanded="true">
                        <a href="#site" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-fw fa-globe iq-arrow-left"></i><span>Site</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="site" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            <?php if ($_SESSION['UsuarioNivel'] >= '100') { ?>
                                <li><a href="seo"><i class="far fa-building"></i>Contato / SEO</a></li>
                            <?php }
                            if ($_SESSION['UsuarioNivel'] >= '98') { ?>
                                <li><a href="noticias"><i class="fas fa-copy"></i>Notícias</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <hr class="sidebar-divider d-none d-md-block">
                <?php } ?>

                <br><br>
                <li>
                    <a href="https://api.whatsapp.com/send?phone=+5541992823979?text=Ol%c3%a1,%20eu%20tenho%20uma%20dúvida%20ou%20sugestão!" target="_blank" class="iq-waves-effect"><i class="fa fa-whatsapp iq-arrow-left"></i><span>Dúvidas ou Sugestões?</span></a>
                </li>
                <li>
                    <a href="https://t.me/+fNUWrs95VuUxNGUx" target="_blank" class="iq-waves-effect"><i class="fab fa-telegram-plane iq-arrow-left"></i><span>Cripto News</span></a>
                </li>
                <li>
                    <a href="https://www.instagram.com/_cripto4you" target="_blank" class="iq-waves-effect"><i class="fab fa-instagram iq-arrow-left"></i><span>Siga-nos</span></a>
                </li>
            </ul>
        </nav>

        <div class="p-3"></div>
    </div>
</div>