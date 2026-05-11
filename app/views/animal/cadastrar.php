<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Cadastro de Gado</title>

  <!-- CSS -->
   <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">

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

        <a href="<?= BASE_URL ?>/dashboard" class="menu-item">
          <i class="ri-dashboard-line"></i>
          <span>Dashboard</span>
        </a>

        <a href="<?= BASE_URL ?>/animal/cadastrar" class="menu-item active">
          <i class="ri-bear-smile-line"></i>
          <span>Gado</span>
        </a>

        <a href="<?= BASE_URL ?>/vacinas" class="menu-item">
          <i class="ri-heart-pulse-line"></i>
          <span>Vacinação</span>
        </a>

        <a href="<?= BASE_URL ?>/financeiro" class="menu-item">
          <i class="ri-line-chart-line"></i>
          <span>Financeiro</span>
        </a>

        <a href="<?= BASE_URL ?>/relatorios" class="menu-item">
          <i class="ri-file-chart-line"></i>
          <span>Relatórios</span>
        </a>

        <a href="<?= BASE_URL ?>/profile" class="menu-item">
          <i class="ri-user-line"></i>
          <span>Perfil</span>
        </a>

      </nav>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

      <!-- TOPBAR -->
      <header class="topbar">

        <button class="menu-toggle" id="menuToggle">
          <i class="ri-menu-line"></i>
        </button>

        <div class="topbar-title">

          <h1>Cadastro de Gado</h1>

          <p>
            Cadastre novos animais no sistema
          </p>

        </div>

      </header>

      <!-- FORM -->
      <div class="form-container">

        <div class="input-row">

          <div class="input-group">

            <label>Número do Brinco</label>

            <input
              type="text"
              placeholder="Ex: 1024"
            >

          </div>

          <div class="input-group">

            <label>Nome do Animal</label>

            <input
              type="text"
              placeholder="Ex: Trovão"
            >

          </div>

        </div>

        <div class="input-row">

          <div class="input-group">

            <label>Raça</label>

            <select>

              <option>Selecione</option>
              <option>Nelore</option>
              <option>Angus</option>
              <option>Brahman</option>

            </select>

          </div>

          <div class="input-group">

            <label>Sexo</label>

            <select>

              <option>Selecione</option>
              <option>Macho</option>
              <option>Fêmea</option>

            </select>

          </div>

        </div>

        <div class="input-row">

          <div class="input-group">

            <label>Peso Atual</label>

            <input
              type="number"
              placeholder="Ex: 420"
            >

          </div>

          <div class="input-group">

            <label>Data de Nascimento</label>

            <input type="date">

          </div>

        </div>

        <div class="input-group">

          <label>Observações</label>

          <textarea
            placeholder="Informações adicionais sobre o animal..."
          ></textarea>

        </div>

        <button class="save-btn">
          Salvar Animal
        </button>

      </div>

    </main>

  </div>

  <!-- JS -->
  <script src="<?= BASE_URL ?>/public/assets/js/animal/cadastrar.js"></script>

</body>

</html>