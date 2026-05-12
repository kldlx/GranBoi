<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  

  <title>GranBoi - Cadastro de Gado</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">
  <style>
  .alert-error {
    background: #fdecea;
    color: #b71c1c;
    border: 1px solid #f5c2c0;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 600;
  }
</style>

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

        <a href="<?= BASE_URL ?>/dashboard" class="menu-item">
          <i class="ri-dashboard-line"></i>
          <span>Dashboard</span>
        </a>

        <a href="<?= BASE_URL ?>/animal/listar" class="menu-item active">
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

    <main class="main-content">

      <header class="topbar">

        <button class="menu-toggle" id="menuToggle" type="button">
          <i class="ri-menu-line"></i>
        </button>

        <div class="topbar-title">

          <h1>Cadastro de Gado</h1>

          <p>
            Cadastre novos animais no sistema
          </p>

        </div>

      </header>
<div class="form-container">

  <?php if (isset($_GET['erro']) && $_GET['erro'] === 'brinco_duplicado'): ?>
  <div class="alert-error">
    Já existe um animal cadastrado com esse número de brinco.
  </div>
<?php endif; ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] === 'cadastro'): ?>
  <div class="alert-error">
    Não foi possível cadastrar o animal. Verifique se a raça e o lote existem no banco de dados.
  </div>
<?php endif; ?>

  <form action="<?= BASE_URL ?>/animal/salvar" method="POST">

          <div class="input-row">

            <div class="input-group">

              <label for="brinco">Número do Brinco</label>

              <input
                type="text"
                id="brinco"
                name="brinco"
                placeholder="Ex: 1024"
                required
              >

            </div>

            <div class="input-group">

              <label for="nome_animal">Nome do Animal</label>

              <input
                type="text"
                id="nome_animal"
                name="nome_animal"
                placeholder="Ex: Trovão"
              >

            </div>

          </div>

          <div class="input-row">

 <div class="input-group">

  <label for="raca">Raça</label>

  <select id="raca" name="raca" required>
    <option value="">Selecione</option>
    <option value="1">Nelore</option>
    <option value="2">Red Angus</option>
    <option value="3">Angus Mocho</option>
    <option value="4">Hereford</option>
    <option value="5">Brahman</option>
    <option value="6">Guzerá</option>
    <option value="7">Simental</option>
    <option value="8">Gir</option>
    <option value="9">Girolando</option>
    <option value="10">Jersey</option>
  </select>

</div>

      <div class="input-group">

  <label for="lote">Lote</label>

  <select id="lote" name="lote" required>
    <option value="">Selecione</option>
    <option value="1">NELORE - 500 ANIMAIS</option>
    <option value="2">ANGUS - 100 - ANIMAIS PRIMEIRA LINHA</option>
  </select>

</div>

          </div>

          <div class="input-row">

            <div class="input-group">

              <label for="sexo">Sexo</label>

              <select id="sexo" name="sexo" required>
                <option value="">Selecione</option>
                <option value="M">Macho</option>
                <option value="F">Fêmea</option>
              </select>

            </div>

            <div class="input-group">

              <label for="peso">Peso Atual</label>

              <input
                type="number"
                id="peso"
                name="peso"
                placeholder="Ex: 420"
                min="1"
                step="0.01"
                required
              >

            </div>

          </div>

          <div class="input-row">

            <div class="input-group">

              <label for="nascimento">Data de Nascimento</label>

              <input
                type="date"
                id="nascimento"
                name="nascimento"
              >

            </div>

            <div class="input-group">

              <label for="observacoes">Observações</label>

              <textarea
                id="observacoes"
                name="observacoes"
                placeholder="Informações adicionais sobre o animal..."
              ></textarea>

            </div>

          </div>

          <button type="submit" class="save-btn">
            Salvar Animal
          </button>

        </form>

      </div>

    </main>

  </div>

<!-- <script src="<?= BASE_URL ?>/public/assets/js/pages/animal/cadastrar.js"></script> -->
</body>

</html>