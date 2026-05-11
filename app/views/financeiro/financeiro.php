<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Financeiro</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/pages/financeiro/financeiro.css">

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
          class="menu-item active"
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

          <h1>Financeiro</h1>

          <p>
            Controle financeiro da fazenda
          </p>

        </div>

      </header>

      <section class="cards">

        <div class="card">

          <div class="card-icon green">
            <i class="ri-money-dollar-circle-line"></i>
          </div>

          <div class="card-info">
            <span>Receita Total</span>
            <h2>R$ 82.400</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon red">
            <i class="ri-bank-card-line"></i>
          </div>

          <div class="card-info">
            <span>Despesas</span>
            <h2>R$ 24.900</h2>
          </div>

        </div>

        <div class="card">

          <div class="card-icon blue">
            <i class="ri-wallet-3-line"></i>
          </div>

          <div class="card-info">
            <span>Lucro Líquido</span>
            <h2>R$ 57.500</h2>
          </div>

        </div>

      </section>

      <section class="finance-table-container">

        <div class="table-header">

          <div>

            <h2>Últimas Transações</h2>

            <p>
              Entradas e saídas recentes
            </p>

          </div>

          <button class="new-transaction-btn">
            Nova Transação
          </button>

        </div>

        <table>

          <thead>

            <tr>
              <th>Descrição</th>
              <th>Categoria</th>
              <th>Valor</th>
              <th>Status</th>
            </tr>

          </thead>

          <tbody>

            <tr>

              <td>Venda de Gado</td>
              <td>Receita</td>
              <td>R$ 15.000</td>

              <td>
                <span class="status income">
                  Entrada
                </span>
              </td>

            </tr>

            <tr>

              <td>Compra de Ração</td>
              <td>Despesa</td>
              <td>R$ 4.300</td>

              <td>
                <span class="status expense">
                  Saída
                </span>
              </td>

            </tr>

            <tr>

              <td>Vacinação</td>
              <td>Saúde Animal</td>
              <td>R$ 2.150</td>

              <td>
                <span class="status expense">
                  Saída
                </span>
              </td>

            </tr>

          </tbody>

        </table>

      </section>

    </main>

  </div>

  <script src="<?= BASE_URL ?>/public/assets/js/pages/financeiro/financeiro.js"></script>

</body>

</html>