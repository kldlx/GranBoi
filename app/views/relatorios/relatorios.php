<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Relatórios</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/relatorios/relatorios.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet">

</head>

<body>

  <div class="dashboard-container">

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

        <a
          href="<?= BASE_URL ?>/dashboard"
          class="menu-item"
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
          class="menu-item active"
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

    <main class="main-content">

      <header class="topbar">

        <button
          class="menu-toggle"
          id="menuToggle"
        >
          <i class="ri-menu-line"></i>
        </button>

        <div class="topbar-title">

          <h1>Relatórios</h1>

          <p>
            Gere relatórios completos da fazenda
          </p>

        </div>

      </header>

      <section class="reports-grid">

        <div class="report-card">

          <div class="report-icon green">
            <i class="ri-bear-smile-line"></i>
          </div>

          <h2>Relatório de Gado</h2>

          <p>
            Dados completos do rebanho
          </p>

          <button class="report-btn">
            Gerar Relatório
          </button>

        </div>

        <div class="report-card">

          <div class="report-icon blue">
            <i class="ri-heart-pulse-line"></i>
          </div>

          <h2>Vacinação</h2>

          <p>
            Histórico de imunização
          </p>

          <button class="report-btn">
            Gerar Relatório
          </button>

        </div>

        <div class="report-card">

          <div class="report-icon orange">
            <i class="ri-line-chart-line"></i>
          </div>

          <h2>Financeiro</h2>

          <p>
            Fluxo de caixa e despesas
          </p>

          <button class="report-btn">
            Gerar Relatório
          </button>

        </div>

      </section>

      <section class="recent-reports">

        <div class="section-header">

          <div>

            <h2>Relatórios Recentes</h2>

            <p>
              Últimos relatórios gerados
            </p>

          </div>

        </div>

        <table>

          <thead>

            <tr>
              <th>Relatório</th>
              <th>Data</th>
              <th>Status</th>
              <th>Ação</th>
            </tr>

          </thead>

          <tbody>

            <tr>

              <td>Relatório Financeiro</td>
              <td>05/05/2026</td>

              <td>
                <span class="status success">
                  Concluído
                </span>
              </td>

              <td>
                <button class="download-btn">
                  Baixar
                </button>
              </td>

            </tr>

            <tr>

              <td>Relatório de Vacinação</td>
              <td>03/05/2026</td>

              <td>
                <span class="status processing">
                  Processando
                </span>
              </td>

              <td>
                <button class="download-btn disabled">
                  Aguarde
                </button>
              </td>

            </tr>

            <tr>

              <td>Relatório do Rebanho</td>
              <td>01/05/2026</td>

              <td>
                <span class="status success">
                  Concluído
                </span>
              </td>

              <td>
                <button class="download-btn">
                  Baixar
                </button>
              </td>

            </tr>

          </tbody>

        </table>

      </section>

    </main>

  </div>

  <script src="<?= BASE_URL ?>/public/assets/js/relatorios/relatorios.js"></script>

</body>

</html>