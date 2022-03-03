<!--
    NÍVEL DE PERFIS:

    1   = Usuário;
    99  = Colaborador;
    100 = Administrador;
-->

<hr class="sidebar-divider my-0">
<li class="nav-item">
    <a class="nav-link" href="dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<?php if ($_SESSION['UsuarioNivel'] >= '1') { ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Broker
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMeuInvestimento" aria-expanded="true" aria-controls="collapseMeuInvestimento">
            <i class="fas fa-fw fa-coins"></i>
            <span>Investimento</span>
        </a>
        <div id="collapseMeuInvestimento" class="collapse" aria-labelledby="headingMeuInvestimento" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="meu-investimento">Extrato</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
<?php } ?>


<?php if ($_SESSION['UsuarioNivel'] >= '98') { ?>
    <div class="sidebar-heading">
        Gestão
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCadastroClientes" aria-expanded="true" aria-controls="collapseCadastroClientes">
            <i class="fas fa-fw fa-users"></i>
            <span>Clientes</span>
        </a>
        <div id="collapseCadastroClientes" class="collapse" aria-labelledby="headingCadastroClientes" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="clientes">Listar</a>
            </div>
        </div>
    </li>
<?php } ?>

<?php if ($_SESSION['UsuarioNivel'] >= '98') { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfigSite" aria-expanded="true" aria-controls="collapseConfigSite">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configurações Site</span>
        </a>
        <div id="collapseConfigSite" class="collapse" aria-labelledby="headingConfigSite" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php if ($_SESSION['UsuarioNivel'] >= '100') { ?>
                    <a class="collapse-item" href="contato-seo">Contato / SEO</a>
                <?php }
                if ($_SESSION['UsuarioNivel'] >= '98') { ?>
                    <a class="collapse-item" href="noticias">Notícias</a>
                <?php } ?>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
<?php } ?>


<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<div class="sidebar-card d-none d-lg-flex">
    <p class="text-center mb-2"><strong>Dúvidas ou Sugestões?</strong></p>
    <a type="button" class="btn btn-primary btn-sm" href="mailto:suporte@cripto4yout.net" target="_blank">CONTATO</a>
</div>

<div class="sidebar-card d-none d-lg-flex">
    <p class="text-center mb-2"><strong>Notícias Cripto</strong></p>
    <a type="button" class="btn btn-primary btn-sm" href="https://t.me/+fNUWrs95VuUxNGUx" target="_blank"><i class="fab fa-telegram"></i> Telegram</a>
</div>

<div class="sidebar-card d-none d-lg-flex">
    <p class="text-center mb-2"><strong>Siga-nos</strong></p>
    <a type="button" class="btn btn-primary btn-sm" href="https://www.instagram.com/_cripto4you" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
</div>