<?php
// Esperado vir do controller:
// $totalGado, $vacinasPendentes, $pesoMedio, $receitaMensal, $ultimosRegistros
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Dashboard</title>

  <link rel="stylesheet" href="/assets/css/dashboard/dashboard.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

</head>

<body>

<div class="dashboard-container">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">

    <div class="logo">
      <div class="logo-icon"><i class="ri-leaf-line"></i></div>
      <div class="logo-text">
        <h2>GranBoi</h2>
        <span>Gestão Inteligente</span>
      </div>
    </div>

    <nav class="menu">

      <a href="/dashboard" class="menu-item active">
        <i class="ri-dashboard-line"></i>
        <span>Dashboard</span>
      </a>

      <a href="/animal/listar" class="menu-item">
        <i class="ri-bear-smile-line"></i>
        <span>Gado</span>
      </a>

      <a href="/vacinas" class="menu-item">
        <i class="ri-heart-pulse-line"></i>
        <span>Vacinação</span>
      </a>

      <a href="/financeiro" class="menu-item">
        <i class="ri-line-chart-line"></i>
        <span>Financeiro</span>
      </a>

      <a href="/relatorios" class="menu-item">
        <i class="ri-file-chart-line"></i>
        <span>Relatórios</span>
      </a>

      <a href="/profile" class="menu-item">
        <i class="ri-user-line"></i>
        <span>Perfil</span>
      </a>

    </nav>

  </aside>

  <!-- MAIN -->
  <main class="main-content">

    <header class="topbar">

      <div class="topbar-title">
        <h1>Dashboard</h1>
        <p>Visão geral do sistema</p>
      </div>

      <div class="profile">
        <div class="profile-info">
          <h3><?= $_SESSION['user']['name'] ?? 'Usuário' ?></h3>
          <span>Fazenda</span>
        </div>

        <div class="profile-avatar">
          <?= strtoupper(substr($_SESSION['user']['name'] ?? 'U', 0, 1)) ?>
        </div>
      </div>

    </header>

    <!-- CARDS -->
    <section class="cards">

      <div class="card">
        <div class="card-icon green"><i class="ri-bear-smile-line"></i></div>
        <div class="card-info">
          <span>Total de Gado</span>
          <h2><?= $totalGado ?? 0 ?></h2>
        </div>
      </div>

      <div class="card">
        <div class="card-icon blue"><i class="ri-heart-pulse-line"></i></div>
        <div class="card-info">
          <span>Vacinas Pendentes</span>
          <h2><?= $vacinasPendentes ?? 0 ?></h2>
        </div>
      </div>

      <div class="card">
        <div class="card-icon orange"><i class="ri-scales-3-line"></i></div>
        <div class="card-info">
          <span>Peso Médio</span>
          <h2><?= $pesoMedio ?? 0 ?>kg</h2>
        </div>
      </div>

      <div class="card">
        <div class="card-icon red"><i class="ri-money-dollar-circle-line"></i></div>
        <div class="card-info">
          <span>Receita Mensal</span>
          <h2>R$ <?= $receitaMensal ?? 0 ?></h2>
        </div>
      </div>

    </section>

    <!-- CONTENT -->
    <section class="content-grid">

      <div class="chart-box">
        <div class="section-header">
          <h2>Evolução do Rebanho</h2>
        </div>

        <div class="fake-chart">
          <div class="bar" style="height: 60%;"></div>
          <div class="bar" style="height: 90%;"></div>
          <div class="bar" style="height: 75%;"></div>
          <div class="bar" style="height: 100%;"></div>
          <div class="bar" style="height: 80%;"></div>
          <div class="bar" style="height: 65%;"></div>
        </div>
      </div>

      <div class="table-box">

        <div class="section-header">
          <h2>Últimos Registros</h2>
        </div>

        <table>

          <thead>
            <tr>
              <th>Brinco</th>
              <th>Raça</th>
              <th>Peso</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>

          <?php if (!empty($ultimosRegistros)): ?>
            <?php foreach ($ultimosRegistros as $animal): ?>
              <tr>
                <td>#<?= $animal['id'] ?></td>
                <td><?= $animal['raca'] ?></td>
                <td><?= $animal['peso'] ?>kg</td>
                <td>
                  <span class="status">
                    <?= $animal['status'] ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>

          </tbody>

        </table>

      </div>

    </section>

  </main>

</div>

<script src="/assets/js/dashboard/dashboard.js"></script>

</body>
</html>