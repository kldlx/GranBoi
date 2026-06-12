<!DOCTYPE html>
<html lang="pt-BR">
    

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $titulo ?? 'GranBoi' ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css?v=2">

    <?php if (!empty($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL . $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
        rel="stylesheet"
    >

</head>

<body>

<?php

$papelUsuario = $_SESSION['usuario']['papel'] ?? '';

$urlAtual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = parse_url(BASE_URL, PHP_URL_PATH);
$urlAtual = str_replace($basePath, '', $urlAtual);

if ($urlAtual === '') {
    $urlAtual = '/';
}

function menuAtivoCabecalho($urlAtual, $url)
{
    return $urlAtual === $url ? 'active' : '';
}

?>

<header class="main-header">

    <div class="main-header-logo">

        <div class="logo-icon">
            <i class="ri-leaf-line"></i>
        </div>

        <div class="logo-text">
            <h2>GranBoi</h2>
            <span>Gestão Inteligente</span>
        </div>

    </div>

    <button
        type="button"
        class="main-header-toggle"
        id="menuToggle"
        aria-label="Abrir ou fechar menu"
    >
        <i class="ri-menu-line"></i>
    </button>

    <nav class="main-header-menu" id="mainHeaderMenu">

        <?php if ($papelUsuario === 'administrador'): ?>

            <a href="<?= BASE_URL ?>/dashboard" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/dashboard') ?>">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= BASE_URL ?>/animal" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/animal') ?>">
                <i class="ri-bear-smile-line"></i>
                <span>Gado</span>
            </a>

            <a href="<?= BASE_URL ?>/peso" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/peso') ?>">
                <i class="ri-scales-3-line"></i>
                <span>Pesagem</span>
            </a>

            <a href="<?= BASE_URL ?>/racas" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/racas') ?>">
                <i class="ri-folder-settings-line"></i>
                <span>Cadastros</span>
            </a>

            <a href="<?= BASE_URL ?>/vacinas" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/vacinas') ?>">
                <i class="ri-heart-pulse-line"></i>
                <span>Vacinação</span>
            </a>

            <a href="<?= BASE_URL ?>/financeiro" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/financeiro') ?>">
                <i class="ri-line-chart-line"></i>
                <span>Financeiro</span>
            </a>

            <a href="<?= BASE_URL ?>/relatorios" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/relatorios') ?>">
                <i class="ri-file-chart-line"></i>
                <span>Relatórios</span>
            </a>

            <a href="<?= BASE_URL ?>/funcionarios" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/funcionarios') ?>">
                <i class="ri-team-line"></i>
                <span>Funcionários</span>
            </a>

        <?php elseif ($papelUsuario === 'gestor'): ?>

            <a href="<?= BASE_URL ?>/dashboard" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/dashboard') ?>">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= BASE_URL ?>/animal" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/animal') ?>">
                <i class="ri-bear-smile-line"></i>
                <span>Gado</span>
            </a>

            <a href="<?= BASE_URL ?>/peso" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/peso') ?>">
                <i class="ri-scales-3-line"></i>
                <span>Pesagem</span>
            </a>

            <a href="<?= BASE_URL ?>/racas" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/racas') ?>">
                <i class="ri-folder-settings-line"></i>
                <span>Cadastros</span>
            </a>

            <a href="<?= BASE_URL ?>/vacinas" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/vacinas') ?>">
                <i class="ri-heart-pulse-line"></i>
                <span>Vacinação</span>
            </a>

            <a href="<?= BASE_URL ?>/relatorios" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/relatorios') ?>">
                <i class="ri-file-chart-line"></i>
                <span>Relatórios</span>
            </a>

        <?php elseif ($papelUsuario === 'veterinario'): ?>

            <a href="<?= BASE_URL ?>/dashboard" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/dashboard') ?>">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= BASE_URL ?>/animal" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/animal') ?>">
                <i class="ri-bear-smile-line"></i>
                <span>Gado</span>
            </a>

            <a href="<?= BASE_URL ?>/peso" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/peso') ?>">
                <i class="ri-scales-3-line"></i>
                <span>Pesagem</span>
            </a>

            <a href="<?= BASE_URL ?>/vacinas" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/vacinas') ?>">
                <i class="ri-heart-pulse-line"></i>
                <span>Vacinação</span>
            </a>

        <?php elseif ($papelUsuario === 'operador'): ?>

            <a href="<?= BASE_URL ?>/dashboard" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/dashboard') ?>">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= BASE_URL ?>/animal" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/animal') ?>">
                <i class="ri-bear-smile-line"></i>
                <span>Gado</span>
            </a>

            <a href="<?= BASE_URL ?>/peso" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/peso') ?>">
                <i class="ri-scales-3-line"></i>
                <span>Pesagem</span>
            </a>

        <?php else: ?>

            <a href="<?= BASE_URL ?>/dashboard" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/dashboard') ?>">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>

        <?php endif; ?>

        <?php if (in_array($papelUsuario, ['gestor', 'veterinario', 'operador'], true)): ?>
            <a href="<?= BASE_URL ?>/financeiro" class="main-header-link <?= menuAtivoCabecalho($urlAtual, '/financeiro') ?>">
                <i class="ri-line-chart-line"></i>
                <span>Financeiro</span>
            </a>
        <?php endif; ?>

    </nav>

    <div class="main-header-profile">

        <div class="profile-info">
            <h3><?= htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário') ?></h3>
            <span><?= htmlspecialchars($_SESSION['usuario']['papel_nome'] ?? 'Perfil') ?></span>
        </div>

        <a
            href="<?= BASE_URL ?>/profile"
            class="profile-avatar profile-avatar-link <?= menuAtivoCabecalho($urlAtual, '/profile') ?>"
            title="Meu Perfil"
        >
            <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
        </a>

        <a href="<?= BASE_URL ?>/logout" class="main-header-logout" title="Sair">
            <i class="ri-logout-box-line"></i>
        </a>

    </div>

</header>
