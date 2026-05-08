<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Dashboard</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/dashboard/dashboard.css">
   <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">

  <!-- GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
  >

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
  >

  <!-- REMIX ICONS -->
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
  >

</head>

<body>

  <div class="dashboard-container">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

      <!-- LOGO -->
      <div class="logo">

        <div class="logo-icon">
          <i class="ri-leaf-line"></i>
        </div>

        <div class="logo-text">
          <h2>GranBoi</h2>
          <span>Gestão Inteligente</span>
        </div>

      </div>

      <!-- MENU -->
      <nav class="menu">

        <a
          href="<?= BASE_URL ?>/dashboard"
          class="menu-item active"
        >
          <i class="ri-dashboard-line"></i>
          <span>Dashboard</span>
        </a>

        <a
          href="<?= BASE_URL ?>/animal/cadastrar"
          class="menu-item"
        >
          <i class="ri-bear-smile-line"></i>
          <span>Gado</span>
        </a>

        <a
          href="<?= BASE_URL ?>/vacinas"
          class="menu-item"
        >
          <i class="ri-heart-pulse-line"></i>
          <span>Vacinação</span>
        </a>

        <a
          href="<?= BASE_URL ?>/financeiro"
          class="menu-item"
        >
          <i class="ri-line-chart-line"></i>
          <span>Financeiro</span>
        </a>

        <a
          href="<?= BASE_URL ?>/relatorios"
          class="menu-item"
        >
          <i class="ri-file-chart-line"></i>
          <span>Relatórios</span>
        </a>

        <a
          href="<?= BASE_URL ?>/profile"
          class="menu-item"
        >
          <i class="ri-user-line"></i>
          <span>Perfil</span>
        </a>

      </nav>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

      <!-- TOPBAR -->
      <header class="topbar">

        <button
          class="menu-toggle"
          id="menuToggle"
        >
          <i class="ri-menu-line"></i>
        </button>

        <div class="topbar-title">

          <h1>Dashboard</h1>

          <p>
            Visão geral do sistema
          </p>

        </div>

        <div class="profile">

          <div class="profile-info">
            <h3>Administrador</h3>
            <span>Fazenda Central</span>
          </div>

          <div class="profile-avatar">
            A
          </div>

        </div>

      </header>

      <!-- CARDS -->
      <section class="cards">

        <div class="card">

          <div class="card-icon green">
            <i class="ri-bear-smile-line"></i>
          </div>

          <div class="card-info">
            <span>Total de Gado</span>
            <h2>5.240</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon blue">
            <i class="ri-heart-pulse-line"></i>
          </div>

          <div class="card-info">
            <span>Vacinas Pendentes</span>
            <h2>124</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon orange">
            <i class="ri-scales-3-line"></i>
          </div>

          <div class="card-info">
            <span>Peso Médio</span>
            <h2>412kg</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon red">
            <i class="ri-money-dollar-circle-line"></i>
          </div>

          <div class="card-info">
            <span>Receita Mensal</span>
            <h2>R$ 82k</h2>
          </div>

        </div>

      </section>

      <!-- CONTENT -->
      <section class="content-grid">

        <!-- CHART -->
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

        <!-- TABLE -->
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

              <tr>

                <td>#1023</td>
                <td>Nelore</td>
                <td>410kg</td>

                <td>
                  <span class="status healthy">
                    Saudável
                  </span>
                </td>

              </tr>

              <tr>

                <td>#2045</td>
                <td>Angus</td>
                <td>450kg</td>

                <td>
                  <span class="status vaccine">
                    Vacina
                  </span>
                </td>

              </tr>

              <tr>

                <td>#8741</td>
                <td>Brahman</td>
                <td>390kg</td>

                <td>
                  <span class="status alert">
                    Atenção
                  </span>
                </td>

              </tr>

            </tbody>

          </table>

        </div>

      </section>

    </main>

  </div>

  <!-- JS -->
  <script src="<?= BASE_URL ?>/public/assets/js/dashboard/dashboard.js"></script>

</body>

</html>