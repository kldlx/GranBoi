<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Vacinação</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/pages/vacinas/vacinas.css">

  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/components/modal.css">

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
          class="menu-item active"
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

    <main class="main-content">

      <header class="topbar">

        <button
          class="menu-toggle"
          id="menuToggle"
        >
          <i class="ri-menu-line"></i>
        </button>

        <div class="topbar-title">

          <h1>Controle de Vacinação</h1>

          <p>
            Gerencie vacinas e imunizações do rebanho
          </p>

        </div>

      </header>

      <section class="cards">

        <div class="card">

          <div class="card-icon blue">
            <i class="ri-syringe-line"></i>
          </div>

          <div class="card-info">
            <span>Vacinas Aplicadas</span>
            <h2>2.430</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon orange">
            <i class="ri-alarm-warning-line"></i>
          </div>

          <div class="card-info">
            <span>Pendentes</span>
            <h2>124</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon green">
            <i class="ri-shield-check-line"></i>
          </div>

          <div class="card-info">
            <span>Imunizados</span>
            <h2>95%</h2>
          </div>

        </div>

      </section>

      <section class="table-container">

        <div class="table-header">

          <div>

            <h2>Próximas Vacinações</h2>

            <p>
              Controle das vacinas agendadas
            </p>

          </div>

          <button
            class="new-vaccine-btn"
            id="abrirModalVacinacao"
          >
            Nova Vacinação
          </button>

        </div>

        <table>

          <thead>

            <tr>
              <th>Brinco</th>
              <th>Vacina</th>
              <th>Data</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>

          </thead>

          <tbody>

            <tr
              data-id="1"
              data-animal="#1023"
              data-vacina="Febre Aftosa"
              data-data-aplicacao="2026-05-12"
              data-proxima-dose="2026-11-12"
              data-responsavel="Carlos Silva"
              data-lote="AFT-2026"
              data-quantidade="5ml"
              data-via-aplicacao="Subcutânea"
              data-observacoes="Vacinação sem reações."
              data-status="Pendente"
            >

              <td>#1023</td>
              <td>Febre Aftosa</td>
              <td>12/05/2026</td>

              <td>
                <span class="status pending">
                  Pendente
                </span>
              </td>

              <td>

                <div class="actions">

                  <button
                    class="action-btn view-btn"
                    data-action="view"
                  >
                    <i class="ri-eye-line"></i>
                  </button>

                  <button
                    class="action-btn edit-btn"
                    data-action="edit"
                  >
                    <i class="ri-edit-line"></i>
                  </button>

                  <button
                    class="action-btn delete-btn"
                    data-action="delete"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>

                </div>

              </td>

            </tr>

            <tr
              data-id="2"
              data-animal="#2045"
              data-vacina="Brucelose"
              data-data-aplicacao="2026-05-15"
              data-proxima-dose="2026-11-15"
              data-responsavel="Marcos Oliveira"
              data-lote="BRU-9921"
              data-quantidade="3ml"
              data-via-aplicacao="Intramuscular"
              data-observacoes="Aplicação realizada normalmente."
              data-status="Aplicada"
            >

              <td>#2045</td>
              <td>Brucelose</td>
              <td>15/05/2026</td>

              <td>
                <span class="status done">
                  Aplicada
                </span>
              </td>

              <td>

                <div class="actions">

                  <button
                    class="action-btn view-btn"
                    data-action="view"
                  >
                    <i class="ri-eye-line"></i>
                  </button>

                  <button
                    class="action-btn edit-btn"
                    data-action="edit"
                  >
                    <i class="ri-edit-line"></i>
                  </button>

                  <button
                    class="action-btn delete-btn"
                    data-action="delete"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>

                </div>

              </td>

            </tr>

            <tr
              data-id="3"
              data-animal="#8741"
              data-vacina="Raiva"
              data-data-aplicacao="2026-05-18"
              data-proxima-dose="2026-11-18"
              data-responsavel="Fernanda Costa"
              data-lote="RAV-4412"
              data-quantidade="4ml"
              data-via-aplicacao="Oral"
              data-observacoes="Vacinação atrasada devido ao manejo."
              data-status="Atrasada"
            >

              <td>#8741</td>
              <td>Raiva</td>
              <td>18/05/2026</td>

              <td>
                <span class="status warning">
                  Atrasada
                </span>
              </td>

              <td>

                <div class="actions">

                  <button
                    class="action-btn view-btn"
                    data-action="view"
                  >
                    <i class="ri-eye-line"></i>
                  </button>

                  <button
                    class="action-btn edit-btn"
                    data-action="edit"
                  >
                    <i class="ri-edit-line"></i>
                  </button>

                  <button
                    class="action-btn delete-btn"
                    data-action="delete"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>

                </div>

              </td>

            </tr>

          </tbody>

        </table>

      </section>

    </main>

  </div>

  <?php require_once 'app/components/modals/modal-vacinacao.php'; ?>

  <script src="<?= BASE_URL ?>/public/assets/js/pages/vacinas/vacinas.js"></script>

</body>

</html>