<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/index.css">
    <title>GranBoi - Sistema de Gestão</title>
</head>
<body>
<header>
    <h1>GRANBOI</h1>
</header>
<nav>
<a href="<?= BASE_URL ?>home/homeGranboi">Home</a>
<?php if(!isset($_SESSION['logado'])): ?>
| <a href="<?= BASE_URL ?>usuario/Cadastro">Cadastrar</a>
| <a href="<?= BASE_URL ?>usuario/Login">Login</a>
<?php endif; ?>
<?php if(isset($_SESSION['logado'])): ?>
| <a href="<?= BASE_URL ?>boi/cadastro">Cadastrar boi</a>
| <a href="<?= BASE_URL ?>boi/verBoi">Ver bois cadastrados</a>
| <a href="<?= BASE_URL ?>usuario/editar">Meus Dados</a>
<?php if(isset($_SESSION['id_admin'])): ?>
| <a href="<?= BASE_URL ?>admin/cadastrarFuncionario">Cadastrar Funcionários</a>
<?php endif; ?>
| <a href="<?= BASE_URL ?>usuario/logout">Logout</a>
        <?php if (isset($_SESSION['nome_usuario'])): ?>
            <span class="usuario-logado">
                Olá, <?= htmlspecialchars($_SESSION['nome_usuario']) ?>
            </span>
        <?php endif; ?>
    <?php endif; ?>
    
</nav>
<hr>
