<main class="main-content relatorios-page">

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
        Consulte informações consolidadas da fazenda
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

  <section class="relatorios-page-actions">

    <div>
      <h2>Central de Relatórios</h2>
      <p>
        Acompanhe dados importantes sobre rebanho, vacinação, pesagem e gestão.
      </p>
    </div>

  </section>

  <section class="reports-grid">

    <article class="report-card">

      <div class="report-icon green">
        <i class="ri-bear-smile-line"></i>
      </div>

      <div class="report-content">

        <h2>Relatório de Gado</h2>

        <p>
          Consulta geral dos animais cadastrados, incluindo brinco, raça, sexo, peso atual e status.
        </p>

      </div>

      <a
        href="<?= BASE_URL ?>/animal"
        class="report-btn"
      >
        <i class="ri-arrow-right-line"></i>
        <span>Ver Gado</span>
      </a>

    </article>

    <article class="report-card">

      <div class="report-icon blue">
        <i class="ri-heart-pulse-line"></i>
      </div>

      <div class="report-content">

        <h2>Relatório de Vacinação</h2>

        <p>
          Acompanhe vacinações aplicadas, pendentes, atrasadas e próximas doses.
        </p>

      </div>

      <a
        href="<?= BASE_URL ?>/vacinas"
        class="report-btn"
      >
        <i class="ri-arrow-right-line"></i>
        <span>Ver Vacinação</span>
      </a>

    </article>

    <article class="report-card">

      <div class="report-icon orange">
        <i class="ri-scales-3-line"></i>
      </div>

      <div class="report-content">

        <h2>Relatório de Pesagem</h2>

        <p>
          Consulte o histórico de peso, evolução dos animais e ganho médio diário.
        </p>

      </div>

      <a
        href="<?= BASE_URL ?>/peso"
        class="report-btn"
      >
        <i class="ri-arrow-right-line"></i>
        <span>Ver Pesagem</span>
      </a>

    </article>

    <?php if (($_SESSION['usuario']['papel'] ?? '') === 'administrador'): ?>

      <article class="report-card">

        <div class="report-icon purple">
          <i class="ri-line-chart-line"></i>
        </div>

        <div class="report-content">

          <h2>Relatório Financeiro</h2>

          <p>
            Área destinada ao acompanhamento financeiro, custos, receitas e resultados da fazenda.
          </p>

        </div>

        <a
          href="<?= BASE_URL ?>/financeiro"
          class="report-btn"
        >
          <i class="ri-arrow-right-line"></i>
          <span>Ver Financeiro</span>
        </a>

      </article>

    <?php endif; ?>

  </section>

  <section class="relatorios-table-card">

    <div class="section-header">

      <div>
        <h2>Resumo dos Relatórios</h2>
        <p>
          Veja quais informações podem ser consultadas em cada área do sistema.
        </p>
      </div>

    </div>

    <table class="relatorios-table">

      <thead>

        <tr>
          <th>Relatório</th>
          <th>Informações</th>
          <th>Acesso</th>
          <th>Status</th>
        </tr>

      </thead>

      <tbody>

        <tr>
          <td>Gado</td>
          <td>Animais, raça, lote, sexo, peso atual e status.</td>
          <td>Administrador, Gestor, Veterinário e Operador</td>
          <td>
            <span class="relatorio-status disponivel">
              Disponível
            </span>
          </td>
        </tr>

        <tr>
          <td>Vacinação</td>
          <td>Histórico sanitário, doses aplicadas, pendentes e atrasadas.</td>
          <td>Administrador, Gestor e Veterinário</td>
          <td>
            <span class="relatorio-status disponivel">
              Disponível
            </span>
          </td>
        </tr>

        <tr>
          <td>Pesagem</td>
          <td>Histórico de peso, peso atual e ganho médio diário.</td>
          <td>Administrador, Gestor, Veterinário e Operador</td>
          <td>
            <span class="relatorio-status disponivel">
              Disponível
            </span>
          </td>
        </tr>

        <?php if (($_SESSION['usuario']['papel'] ?? '') === 'administrador'): ?>

          <tr>
            <td>Financeiro</td>
            <td>Custos, receitas e acompanhamento financeiro da fazenda.</td>
            <td>Administrador</td>
            <td>
              <span class="relatorio-status planejamento">
                Em estruturação
              </span>
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

</main>