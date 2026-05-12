<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'GranBoi' ?></title>
</head>

<body>

<nav>
    <a href="<?= BASE_URL ?>/dashboard">Home</a>

    <!-- Usuário deslogado -->
    <?php if (!isset($_SESSION['user'])): ?>

        | <a href="<?= BASE_URL ?>/login">Login</a>

    <?php endif; ?>


    <!-- Usuário logado -->
    <?php if (isset($_SESSION['user'])): ?>

        <?php $papel = $_SESSION['user']['papel'] ?? ''; ?>

        <!-- Administrador -->
        <?php if ($papel === 'administrador'): ?>
            | <a href="<?= BASE_URL ?>/animal">Ver bois</a>
            | <a href="<?= BASE_URL ?>/animal/cadastrar">Cadastrar boi</a>
            | <a href="<?= BASE_URL ?>/vacinas">Vacinas</a>
            | <a href="<?= BASE_URL ?>/financeiro">Financeiro</a>
            | <a href="<?= BASE_URL ?>/relatorios">Relatórios</a>
            | <a href="<?= BASE_URL ?>/profile">Meus Dados</a>
        <?php endif; ?>


        <!-- Gestor -->
        <?php if ($papel === 'gestor'): ?>
            | <a href="<?= BASE_URL ?>/animal">Ver bois</a>
            | <a href="<?= BASE_URL ?>/animal/cadastrar">Cadastrar boi</a>
            | <a href="<?= BASE_URL ?>/financeiro">Financeiro</a>
            | <a href="<?= BASE_URL ?>/relatorios">Relatórios</a>
            | <a href="<?= BASE_URL ?>/profile">Meus Dados</a>
        <?php endif; ?>


        <!-- Veterinário -->
        <?php if ($papel === 'veterinario'): ?>
            | <a href="<?= BASE_URL ?>/animal">Ver bois</a>
            | <a href="<?= BASE_URL ?>/vacinas">Vacinas</a>
            | <a href="<?= BASE_URL ?>/profile">Meus Dados</a>
        <?php endif; ?>


        <!-- Operador -->
        <?php if ($papel === 'operador'): ?>
            | <a href="<?= BASE_URL ?>/animal">Ver bois</a>
            | <a href="<?= BASE_URL ?>/animal/cadastrar">Cadastrar boi</a>
            | <a href="<?= BASE_URL ?>/profile">Meus Dados</a>
        <?php endif; ?>


        | <a href="<?= BASE_URL ?>/logout">Logout</a>

    <?php endif; ?>
</nav>

<hr>