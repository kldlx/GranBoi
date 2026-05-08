<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Cadastro de Gado</title>

  <link rel="stylesheet" href="/assets/css/gado/cadastrar.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

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

    <nav class="menu">

      <a href="/dashboard" class="menu-item">
        <i class="ri-dashboard-line"></i>
        <span>Dashboard</span>
      </a>

      <a href="/animal/listar" class="menu-item active">
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

      <button class="menu-toggle" id="menuToggle">
        <i class="ri-menu-line"></i>
      </button>

      <div class="topbar-title">
        <h1>Cadastro de Gado</h1>
        <p>Cadastre novos animais no sistema</p>
      </div>

    </header>

    <!-- FORM -->
    <div class="form-container">

      <form action="/animal/salvar" method="POST">

        <div class="input-row">

          <div class="input-group">
            <label>Número do Brinco</label>
            <input type="text" name="brinco" placeholder="Ex: 1024" required>
          </div>

          <div class="input-group">
            <label>Nome do Animal</label>
            <input type="text" name="nome" placeholder="Ex: Trovão">
          </div>

        </div>

        <div class="input-row">

          <div class="input-group">
            <label>Raça</label>
            <select name="raca_id" required>
              <option value="">Selecione</option>
              <option value="1">Nelore</option>
              <option value="2">Angus</option>
              <option value="3">Brahman</option>
            </select>
          </div>

          <div class="input-group">
            <label>Sexo</label>
            <select name="sexo" required>
              <option value="">Selecione</option>
              <option value="Macho">Macho</option>
              <option value="Fêmea">Fêmea</option>
            </select>
          </div>

        </div>

        <div class="input-row">

          <div class="input-group">
            <label>Peso Atual</label>
            <input type="number" name="peso_entrada" placeholder="Ex: 420" required>
          </div>

          <div class="input-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" required>
          </div>

        </div>

        <div class="input-group">
          <label>Observações</label>
          <textarea name="observacoes" placeholder="Informações adicionais sobre o animal..."></textarea>
        </div>

        <button type="submit" class="save-btn">
          Salvar Animal
        </button>

      </form>

    </div>

  </main>

</div>

<script src="/assets/js/gado/cadastrar.js"></script>

</body>
</html>