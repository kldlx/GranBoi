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
        placeholder="Pesquisar por animal, vacina, dose, responsável ou status..."
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

                </div>

              </td>

            </tr>

          <?php endforeach; ?>

          <tr id="vacinacaoSearchEmpty" style="display: none;">
            <td colspan="8" class="vacinacao-empty">
              Nenhum resultado encontrado para a pesquisa ou filtro selecionado.
            </td>
          </tr>

        <?php else: ?>

          <tr>
            <td colspan="8" class="vacinacao-empty">
              Nenhuma vacinação registrada.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <?php require_once ROOT_PATH . '/app/views/components/modals/vacinacao/modal-cadastrar-vacinacao.php'; ?>

  <div class="modal" id="modalVisualizarVacinacao">

    <div
      class="modal-overlay"
      data-close-modal="modalVisualizarVacinacao"
    ></div>

    <div class="modal-container modal-sm">

      <div class="modal-header">

        <div>
          <h2>Detalhes da Vacinação</h2>
          <p>Informações do registro sanitário</p>
        </div>

        <button type="button" class="close-modal" data-close-modal="modalVisualizarVacinacao">
          ✕
        </button>

      </div>

      <div class="modal-body">

        <div class="detalhes-grid">

          <div class="detalhe-item">
            <strong>Animal</strong>
            <span id="detalheVacinacaoAnimal"></span>
          </div>

          <div class="detalhe-item">
            <strong>Vacina</strong>
            <span id="detalheVacinacaoVacina"></span>
          </div>

          <div class="detalhe-item">
            <strong>Dose</strong>
            <span id="detalheVacinacaoDose"></span>
          </div>

          <div class="detalhe-item">
            <strong>Aplicação</strong>
            <span id="detalheVacinacaoAplicacao"></span>
          </div>

          <div class="detalhe-item">
            <strong>Próxima Dose</strong>
            <span id="detalheVacinacaoProximaDose"></span>
          </div>

          <div class="detalhe-item">
            <strong>Responsável</strong>
            <span id="detalheVacinacaoResponsavel"></span>
          </div>

          <div class="detalhe-item">
            <strong>Status</strong>
            <span id="detalheVacinacaoStatus"></span>
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn-cancelar" data-close-modal="modalVisualizarVacinacao">
          Fechar
        </button>

      </div>

    </div>

  </div>

  <div class="modal" id="modalEditarVacinacao">

    <div
      class="modal-overlay"
      data-close-modal="modalEditarVacinacao"
    ></div>

    <div class="modal-container">

      <div class="modal-header">

        <div>
          <h2>Editar Vacinação</h2>
          <p>Atualize os dados do registro sanitário</p>
        </div>

        <button type="button" class="close-modal" data-close-modal="modalEditarVacinacao">
          ✕
        </button>

      </div>

      <form
        method="POST"
        action="<?= BASE_URL ?>/vacinas/atualizar"
        id="formEditarVacinacao"
      >

        <input
          type="hidden"
          id="editar_vacinacao_id"
          name="id"
        >

        <div
          class="vacinacao-modal-message"
          id="editarVacinacaoModalMessage"
          hidden
        ></div>

        <div class="modal-body vacinacao-modal-body">

          <div class="vacinacao-form-grid">

            <div class="vacinacao-form-group">
              <label for="editar_animal_id">Animal</label>

              <select id="editar_animal_id" name="animal_id" required>
                <option value="">Selecione um animal</option>

                <?php if (!empty($animais)): ?>

                  <?php foreach ($animais as $animal): ?>

                    <option value="<?= htmlspecialchars($animal['id']) ?>">
                      #<?= htmlspecialchars($animal['brinco_identificador']) ?>
                      <?= !empty($animal['raca']) ? ' - ' . htmlspecialchars($animal['raca']) : '' ?>
                    </option>

                  <?php endforeach; ?>

                <?php else: ?>

                  <option value="" disabled>
                    Nenhum animal disponível para vacinação
                  </option>

                <?php endif; ?>

              </select>
            </div>

            <div class="vacinacao-form-group">
              <label for="editar_vacina">Vacina</label>

              <input
                type="text"
                id="editar_vacina"
                name="vacina"
                placeholder="Ex: Febre Aftosa"
                required
              >
            </div>

            <div class="vacinacao-form-group">
              <label for="editar_data_aplicacao">Data de Aplicação</label>

              <input
                type="date"
                id="editar_data_aplicacao"
                name="data_aplicacao"
                required
              >
            </div>

            <div class="vacinacao-form-group">
              <label for="editar_proxima_dose">Próxima Dose</label>

              <input
                type="date"
                id="editar_proxima_dose"
                name="proxima_dose"
              >
            </div>

            <div class="vacinacao-form-group vacinacao-form-full">
              <label for="editar_quantidade">Quantidade/Dose</label>

              <input
                type="number"
                id="editar_quantidade"
                name="quantidade"
                placeholder="Ex: 5"
                min="0.001"
                step="0.001"
                required
              >
            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn-cancelar" data-close-modal="modalEditarVacinacao">
            Cancelar
          </button>

          <button type="submit" class="btn-salvar">
            Salvar Alterações
          </button>

        </div>

      </form>

    </div>

  </div>

  <div class="modal" id="modalExcluirVacinacao">

    <div
      class="modal-overlay"
      data-close-modal="modalExcluirVacinacao"
    ></div>

    <div class="modal-container modal-sm">

      <div class="modal-header">

        <div>
          <h2>Excluir Vacinação</h2>
          <p>Confirme a exclusão do registro sanitário</p>
        </div>

        <button type="button" class="close-modal" data-close-modal="modalExcluirVacinacao">
          ✕
        </button>

      </div>

      <form
        method="POST"
        action="<?= BASE_URL ?>/vacinas/excluir"
        id="formExcluirVacinacao"
      >

        <input
          type="hidden"
          id="excluir_vacinacao_id"
          name="id"
        >

        <div
          class="vacinacao-modal-message"
          id="excluirVacinacaoModalMessage"
          hidden
        ></div>

        <div class="modal-body">

          <div class="delete-message">
            <p>
              Tem certeza que deseja excluir a vacinação
              <strong id="excluirVacinacaoVacina"></strong>
              do animal
              <strong id="excluirVacinacaoAnimal"></strong>?
            </p>

            <p>
              Esta ação removerá o registro do histórico sanitário e não poderá ser desfeita.
            </p>
          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn-cancelar" data-close-modal="modalExcluirVacinacao">
            Cancelar
          </button>

          <button type="submit" class="btn-excluir">
            Confirmar Exclusão
          </button>

        </div>

      </form>

    </div>

  </div>

</main>