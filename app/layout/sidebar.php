<?php

$papelUsuario = $_SESSION['usuario']['papel'] ?? '';

$urlAtual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = parse_url(BASE_URL, PHP_URL_PATH);
$urlAtual = str_replace($basePath, '', $urlAtual);

if ($urlAtual === '') {
    $urlAtual = '/';
}

$menus = [
    [
        'label' => 'Dashboard',
        'url' => '/dashboard',
        'icon' => 'ri-dashboard-line',
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],
    [
        'label' => 'Gado',
        'url' => '/animal',
        'icon' => 'ri-bear-smile-line',
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],
    [
    'label' => 'Pesagem',
    'url' => '/peso',
    'icon' => 'ri-scales-3-line',
    'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],
    [
        'label' => 'Vacinação',
        'url' => '/vacinas',
        'icon' => 'ri-heart-pulse-line',
        'roles' => ['administrador', 'gestor', 'veterinario']
    ],
    [
        'label' => 'Financeiro',
        'url' => '/financeiro',
        'icon' => 'ri-line-chart-line',
        'roles' => ['administrador', 'gestor']
    ],
    [
        'label' => 'Relatórios',
        'url' => '/relatorios',
        'icon' => 'ri-file-chart-line',
        'roles' => ['administrador', 'gestor']
    ],
    [
        'label' => 'Perfil',
        'url' => '/profile',
        'icon' => 'ri-user-line',
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],
];

?>

<aside class="sidebar" id="sidebar">

    <div class="logo">

        <div class="logo-icon">
            <i class="ri-leaf-line"></i>
        </div>

        <div class="logo-text">
            <h2>GranBoi</h2>
            <span>Gestão Inteligente</span>
        </div>

    </div>

    <nav class="menu">

        <?php foreach ($menus as $menu): ?>

            <?php if (in_array($papelUsuario, $menu['roles'])): ?>

                <?php
                    $active = $urlAtual === $menu['url'] ? 'active' : '';
                ?>

                <a href="<?= BASE_URL . $menu['url'] ?>" class="menu-item <?= $active ?>">
                    <i class="<?= $menu['icon'] ?>"></i>
                    <span><?= $menu['label'] ?></span>
                </a>

            <?php endif; ?>

        <?php endforeach; ?>

        <a href="<?= BASE_URL ?>/logout" class="menu-item">
            <i class="ri-logout-box-line"></i>
            <span>Sair</span>
        </a>

    </nav>

</aside>