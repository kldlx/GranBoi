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
        Registre e acompanhe as vacinações dos animais
      </p>

    </div>

    <div class="profile">

      <div class="profile-info">
        <h3><?= $_SESSION['usuario']['nome'] ?? 'Usuário' ?></h3>
        <span><?= $_SESSION['usuario']['papel_nome'] ?? 'Perfil' ?></span>
      </div>

      <div class="profile-avatar">
        <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
      </div>

    </div>

  </header>

  <?php if (!empty($_SESSION['sucesso'])): ?>

    <div class="vacinacao-message vacinacao-message-success">
      <i class="ri-checkbox-circle-line"></i>
      <span><?= $_SESSION['sucesso'] ?></span>
    </div>

    <?php unset($_SESSION['sucesso']); ?>

  <?php endif; ?>

  <?php if (!empty($_SESSION['erro'])): ?>

    <div class="vacinacao-message vacinacao-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>

    <?php unset($_SESSION['erro']); ?>

  <?php endif; ?>

  <section class="vacinacao-page-actions">

    <div>
      <h2>Histórico de Vacinação</h2>
      <p>Vacinas registradas no sistema</p>
    </div>

    <button
      type="button"
      class="vacinacao-create-btn"
      id="abrirModalCadastrarVacinacao"
    >
      <i class="ri-add-line"></i>
      <span>Registrar Vacinação</span>
    </button>

  </section>

  <section class="vacinacao-table-container">

    <table class="vacinacao-table">

      <thead>

        <tr>
          <th>Animal</th>
          <th>Vacina</th>
          <th>Aplicação</th>
          <th>Próxima Dose</th>
          <th>Responsável</th>
          <th>Via</th>
          <th>Status</th>
        </tr>

      </thead>

      <tbody>

        <?php if (!empty($vacinacoes)): ?>

          <?php foreach ($vacinacoes as $vacinacao): ?>

            <tr>

              <td>
                #<?= htmlspecialchars($vacinacao['brinco_identificador']) ?>
              </td>

              <td>
                <?= htmlspecialchars($vacinacao['vacina']) ?>
              </td>

              <td>
                <?= date('d/m/Y', strtotime($vacinacao['data_aplicacao'])) ?>
              </td>

              <td>
                <?= !empty($vacinacao['proxima_dose']) ? date('d/m/Y', strtotime($vacinacao['proxima_dose'])) : '-' ?>
              </td>

              <td>
                <?= htmlspecialchars($vacinacao['responsavel'] ?? '-') ?>
              </td>

              <td>
                <?= htmlspecialchars($vacinacao['via_aplicacao'] ?? '-') ?>
              </td>

              <td>
                <span class="vacinacao-status vacinacao-status-<?= htmlspecialchars($vacinacao['status']) ?>">
                  <?= ucfirst(htmlspecialchars($vacinacao['status'])) ?>
                </span>
              </td>

            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="7" class="vacinacao-empty">
              Nenhuma vacinação registrada.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <?php require_once ROOT_PATH . '/app/views/components/modals/vacinacao/modal-cadastrar-vacinacao.php'; ?>

</main>