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
      <p>Últimas vacinações registradas no sistema</p>
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

  <section class="vacinacao-filtros-container">

    <div class="vacinacao-search-box">
      <i class="ri-search-line"></i>

      <input
        type="text"
        id="pesquisaVacinacao"
        placeholder="Pesquisar por animal, vacina, dose, custo, responsável ou status..."
        autocomplete="off"
      >
    </div>

    <div class="vacinacao-status-filters">

      <button type="button" class="vacinacao-filter-btn active" data-status-filter="todos">
        Todas
      </button>

      <button type="button" class="vacinacao-filter-btn" data-status-filter="aplicada">
        Aplicadas
      </button>

      <button type="button" class="vacinacao-filter-btn" data-status-filter="pendente">
        Pendentes
      </button>

      <button type="button" class="vacinacao-filter-btn" data-status-filter="atrasada">
        Atrasadas
      </button>

    </div>

  </section>

  <section class="vacinacao-table-container">

    <table class="vacinacao-table">

      <thead>

        <tr>
          <th>Animal</th>
          <th>Vacina</th>
          <th>Dose</th>
          <th>Custo</th>
          <th>Aplicação</th>
          <th>Próxima Dose</th>
          <th>Responsável</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>

      </thead>

      <tbody id="tabelaVacinacaoBody">

        <?php if (!empty($vacinacoes)): ?>

          <?php foreach ($vacinacoes as $vacinacao): ?>

            <tr
              class="vacinacao-row"
              data-status="<?= htmlspecialchars($vacinacao['status']) ?>"
            >

              <td>
                #<?= htmlspecialchars($vacinacao['brinco_identificador']) ?>
              </td>

              <td>
                <?= htmlspecialchars($vacinacao['vacina']) ?>
              </td>

              <td>
                <?= !empty($vacinacao['quantidade']) ? number_format((float) $vacinacao['quantidade'], 2, ',', '.') . ' ml' : '-' ?>
              </td>

              <td>
                <?= isset($vacinacao['preco_custo_sanitario']) && $vacinacao['preco_custo_sanitario'] !== null ? 'R$ ' . number_format((float) $vacinacao['preco_custo_sanitario'], 2, ',', '.') : '-' ?>
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
                <span class="vacinacao-status vacinacao-status-<?= htmlspecialchars($vacinacao['status']) ?>">
                  <?= ucfirst(htmlspecialchars($vacinacao['status'])) ?>
                </span>
              </td>

              <td>

                <div class="vacinacao-actions">

                  <button
                    type="button"
                    class="action-btn visualizar-vacinacao-btn"
                    title="Visualizar vacinação"
                    data-animal="<?= htmlspecialchars($vacinacao['brinco_identificador']) ?>"
                    data-vacina="<?= htmlspecialchars($vacinacao['vacina']) ?>"
                    data-dose="<?= !empty($vacinacao['quantidade']) ? number_format((float) $vacinacao['quantidade'], 2, ',', '.') . ' ml' : '-' ?>"
                    data-custo="<?= isset($vacinacao['preco_custo_sanitario']) && $vacinacao['preco_custo_sanitario'] !== null ? 'R$ ' . number_format((float) $vacinacao['preco_custo_sanitario'], 2, ',', '.') : '-' ?>"
                    data-aplicacao="<?= date('d/m/Y', strtotime($vacinacao['data_aplicacao'])) ?>"
                    data-proxima-dose="<?= !empty($vacinacao['proxima_dose']) ? date('d/m/Y', strtotime($vacinacao['proxima_dose'])) : '-' ?>"
                    data-responsavel="<?= htmlspecialchars($vacinacao['responsavel'] ?? '-') ?>"
                    data-status="<?= ucfirst(htmlspecialchars($vacinacao['status'])) ?>"
                  >
                    <i class="ri-eye-line"></i>
                  </button>

                  <button
                    type="button"
                    class="action-btn editar-vacinacao-btn"
                    title="Editar vacinação"
                    data-id="<?= htmlspecialchars($vacinacao['id']) ?>"
                    data-animal-id="<?= htmlspecialchars($vacinacao['animal_id']) ?>"
                    data-vacina="<?= htmlspecialchars($vacinacao['vacina']) ?>"
                    data-quantidade="<?= htmlspecialchars($vacinacao['quantidade']) ?>"
                    data-custo="<?= htmlspecialchars($vacinacao['preco_custo_sanitario'] ?? '') ?>"
                    data-data-aplicacao="<?= htmlspecialchars($vacinacao['data_aplicacao']) ?>"
                    data-proxima-dose="<?= htmlspecialchars($vacinacao['proxima_dose'] ?? '') ?>"
                  >
                    <i class="ri-edit-line"></i>
                  </button>

                  <button
                    type="button"
                    class="action-btn danger excluir-vacinacao-btn"
                    title="Excluir vacinação"
                    data-id="<?= htmlspecialchars($vacinacao['id']) ?>"
                    data-animal="<?= htmlspecialchars($vacinacao['brinco_identificador']) ?>"
                    data-vacina="<?= htmlspecialchars($vacinacao['vacina']) ?>"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>

                  <?php if (in_array($vacinacao['status'], ['pendente', 'atrasada'])): ?>

                    <button
                      type="button"
                      class="action-btn aplicar-proxima-dose-btn"
                      title="Aplicar próxima dose"
                      data-id="<?= htmlspecialchars($vacinacao['id']) ?>"
                      data-animal-id="<?= htmlspecialchars($vacinacao['animal_id']) ?>"
                      data-animal="<?= htmlspecialchars($vacinacao['brinco_identificador']) ?>"
                      data-vacina="<?= htmlspecialchars($vacinacao['vacina']) ?>"
                      data-quantidade="<?= htmlspecialchars($vacinacao['quantidade']) ?>"
                      data-custo="<?= htmlspecialchars($vacinacao['preco_custo_sanitario'] ?? '') ?>"
                      data-data-aplicacao="<?= htmlspecialchars($vacinacao['data_aplicacao']) ?>"
                      data-proxima-dose="<?= htmlspecialchars($vacinacao['proxima_dose'] ?? '') ?>"
                    >
                      <i class="ri-syringe-line"></i>
                    </button>

                  <?php endif; ?>

                </div>

              </td>

            </tr>

          <?php endforeach; ?>

          <tr id="vacinacaoSearchEmpty" style="display: none;">
            <td colspan="9" class="vacinacao-empty">
              Nenhum resultado encontrado para a pesquisa ou filtro selecionado.
            </td>
          </tr>

        <?php else: ?>

          <tr>
            <td colspan="9" class="vacinacao-empty">
              Nenhuma vacinação registrada.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <?php require_once ROOT_PATH . '/app/views/components/modals/vacinacao/modal-cadastrar-vacinacao.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/vacinacao/modal-visualizar-vacinacao.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/vacinacao/modal-editar-vacinacao.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/vacinacao/modal-excluir-vacinacao.php'; ?>

</main>