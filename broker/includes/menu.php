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

<?php if ($_SESSION['UsuarioNivel'] >= '100') { ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Broker
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMeuInvestimento" aria-expanded="true" aria-controls="collapseMeuInvestimento">
            <i class="fas fa-fw fa-coins"></i>
            <span>Meu Investimento</span>
        </a>
        <div id="collapseMeuInvestimento" class="collapse" aria-labelledby="headingMeuInvestimento" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="meu-investimento">Visualizar</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRelatorio" aria-expanded="true" aria-controls="collapseRelatorio">
            <i class="fas fa-fw fa-list"></i>
            <span>Relatório</span>
        </a>
        <div id="collapseRelatorio" class="collapse" aria-labelledby="headingRelatorio" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="historico">Histórico</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Atendimento
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuporte" aria-expanded="true" aria-controls="collapseSuporte">
            <i class="fas fa-fw fa-life-ring"></i>
            <span>Suporte</span>
        </a>
        <div id="collapseSuporte" class="collapse" aria-labelledby="headingSuporte" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="fila-atendimento">Fila de Atendimento</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
<?php } ?>

<?php if ($_SESSION['UsuarioNivel'] <= '98') { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfigSite" aria-expanded="true" aria-controls="collapseConfigSite">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configurações Site</span>
        </a>
        <div id="collapseConfigSite" class="collapse" aria-labelledby="headingConfigSite" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php if ($_SESSION['UsuarioNivel'] >= '100') { ?>
                    <a class="collapse-item" href="contato">Contato</a>
                <?php }
                if ($_SESSION['UsuarioNivel'] <= '98') { ?>
                    <a class="collapse-item" href="noticias">Notícias</a>
                <?php }
                if ($_SESSION['UsuarioNivel'] >= '100') { ?>
                    <a class="collapse-item" href="notificacoes">Notificações</a>
                <?php }
                if ($_SESSION['UsuarioNivel'] >= '100') { ?>
                    <a class="collapse-item" href="seo">SEO</a>
                <?php } ?>
            </div>
        </div>
    </li>
<?php } ?>

<hr class="sidebar-divider d-none d-md-block">
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<div class="sidebar-card d-none d-lg-flex">
    <p class="text-center mb-2"><strong>Dúvidas ou Sugestões?</strong></p>
    <a type="button" class="btn btn-primary btn-sm" href="mailto:suporte@cripto4yout.net" target="_blank">CONTATO</a>
</div>