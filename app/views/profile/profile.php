<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Perfil</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/profile/profile.css">

  <!-- GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- REMIX ICONS -->
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet">

</head>

<body>

  <div class="dashboard-container">

    <!-- SIDEBAR -->
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

      <!-- MENU -->
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
          class="menu-item"
        >
          <i class="ri-file-chart-line"></i>
          <span>Relatórios</span>
        </a>

        <a
          href="<?= BASE_URL ?>/profile"
          class="menu-item active"
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

          <h1>Meu Perfil</h1>

          <p>
            Gerencie suas informações pessoais
          </p>

        </div>

      </header>

      <!-- PROFILE CARD -->
      <section class="profile-card">

        <div class="profile-header">

          <div class="profile-avatar-large">
            A
          </div>

          <div class="profile-info">

            <h2>Administrador</h2>

            <p>
              Fazenda Central • Gerente do Sistema
            </p>

          </div>

        </div>

        <!-- FORM -->
        <div class="profile-form">

          <div class="input-row">

            <div class="input-group">

              <label>Nome Completo</label>

              <input
                type="text"
                value="Administrador"
              >

            </div>

            <div class="input-group">

              <label>Email</label>

              <input
                type="email"
                value="admin@GranBoi.com"
              >

            </div>

          </div>

          <div class="input-row">

            <div class="input-group">

              <label>Telefone</label>

              <input
                type="text"
                value="(63) 99999-9999"
              >

            </div>

            <div class="input-group">

              <label>Função</label>

              <input
                type="text"
                value="Administrador"
              >

            </div>

          </div>

          <div class="input-group">

            <label>Senha</label>

            <input
              type="password"
              value="1234"
            >

          </div>

          <button class="save-btn">
            Salvar Alterações
          </button>

        </div>

      </section>

    </main>

  </div>

  <!-- JS -->
  <script src="<?= BASE_URL ?>/public/assets/js/profile/profile.js"></script>

</body>

</html>