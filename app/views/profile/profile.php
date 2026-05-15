<main class="main-content profile-page">

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
        Consulte suas informações de acesso ao sistema
      </p>

    </div>

    <div class="profile">

      <div class="profile-info">
        <h3><?= htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário') ?></h3>
        <span><?= htmlspecialchars($_SESSION['usuario']['papel_nome'] ?? 'Perfil') ?></span>
      </div>

      <div class="profile-avatar">
        <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
      </div>

    </div>

  </header>

  <section class="profile-card">

    <div class="profile-header">

      <div class="profile-avatar-large">
        <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
      </div>

      <div class="profile-info-main">

        <h2>
          <?= htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário') ?>
        </h2>

        <p>
          <?= htmlspecialchars($_SESSION['usuario']['papel_nome'] ?? 'Perfil') ?> • GranBoi
        </p>

      </div>

    </div>

    <div class="profile-details-grid">

      <div class="profile-detail-item">
        <span>Nome Completo</span>
        <strong><?= htmlspecialchars($_SESSION['usuario']['nome'] ?? '-') ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>E-mail</span>
        <strong><?= htmlspecialchars($_SESSION['usuario']['email'] ?? '-') ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Função no Sistema</span>
        <strong><?= htmlspecialchars($_SESSION['usuario']['papel_nome'] ?? '-') ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Status</span>
        <strong><?= htmlspecialchars(ucfirst($_SESSION['usuario']['status'] ?? 'Ativo')) ?></strong>
      </div>

    </div>

    <div class="profile-alert">

      <i class="ri-information-line"></i>

      <div>
        <strong>Informações do perfil</strong>
        <p>
          Para alterar dados pessoais, senha ou função de acesso, solicite a alteração a um administrador do sistema.
        </p>
      </div>

    </div>

  </section>

</main>