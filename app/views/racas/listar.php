<?php
$abaAtiva = $_GET['aba'] ?? 'racas';

if (!in_array($abaAtiva, ['racas', 'lotes'])) {
  $abaAtiva = 'racas';
}
?>

<main class="main-content cadastros-page">

  <?php if (!empty($_SESSION['sucesso'])): ?>

    <div class="animal-message animal-message-success">
      <i class="ri-checkbox-circle-line"></i>
      <span><?= $_SESSION['sucesso'] ?></span>
    </div>

    <?php unset($_SESSION['sucesso']); ?>

  <?php endif; ?>

  <?php if (!empty($_SESSION['erro'])): ?>

    <div class="animal-message animal-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>

    <?php unset($_SESSION['erro']); ?>

  <?php endif; ?>

  <section class="section-header-page cadastros-header">

    <div>
      <h1>Cadastros</h1>
      <p>Cadastre, edite e gerencie as raças e os lotes dos animais da fazenda.</p>
    </div>

  </section>

  <input
    type="radio"
    name="cadastros_tabs"
    id="tab-racas"
    class="cadastros-tabs-input"
    <?= $abaAtiva === 'racas' ? 'checked' : '' ?>
  >

  <input
    type="radio"
    name="cadastros_tabs"
    id="tab-lotes"
    class="cadastros-tabs-input"
    <?= $abaAtiva === 'lotes' ? 'checked' : '' ?>
  >

  <div class="cadastros-tabs-nav">

    <label for="tab-racas" class="cadastros-tab-label">
      <i class="ri-git-branch-line"></i>
      <span>Raças</span>
    </label>

    <label for="tab-lotes" class="cadastros-tab-label">
      <i class="ri-stack-line"></i>
      <span>Lotes</span>
    </label>

  </div>

  <div class="cadastros-tab-content cadastros-content-racas">

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-list-check-2"></i>
          </div>

          <div>
            <h2>Raças cadastradas</h2>
            <p>Cadastre, atualize ou exclua as raças cadastradas no sistema.</p>
          </div>
        </div>

        <button
          type="button"
          class="action-btn cadastros-btn-novo"
          onclick="document.getElementById('modalCadastrarRaca').showModal()"
        >
          <i class="ri-add-line"></i>
          <span>Nova Raça</span>
        </button>

      </div>

      <div class="cadastros-search-container">

        <div class="cadastros-search-box">
          <i class="ri-search-line"></i>

          <input
            type="text"
            id="pesquisaRacas"
            placeholder="Pesquisar por nome da raça..."
            autocomplete="off"
          >
        </div>

      </div>

      <div class="table-responsive">

        <table class="cadastros-table">

          <thead>

            <tr>
              <th>Nome da raça</th>
              <th>Ações</th>
            </tr>

          </thead>

          <tbody>

            <?php if (!empty($racas)): ?>

              <?php foreach ($racas as $raca): ?>

                <tr class="cadastros-raca-row">

                  <td>
                    <span class="cadastros-name">
                      <?= htmlspecialchars($raca['nome_raca']) ?>
                    </span>
                  </td>

                  <td>

                    <div class="cadastros-actions">

                      <button
                        type="button"
                        class="action-btn cadastros-btn-editar"
                        onclick="document.getElementById('modalEditarRaca<?= htmlspecialchars($raca['id']) ?>').showModal()"
                      >
                        <i class="ri-edit-line"></i>
                        <span>Editar</span>
                      </button>

                      <button
                        type="button"
                        class="action-btn btn-danger cadastros-btn-excluir"
                        onclick="document.getElementById('modalExcluirRaca<?= htmlspecialchars($raca['id']) ?>').showModal()"
                      >
                        <i class="ri-delete-bin-line"></i>
                        <span>Excluir</span>
                      </button>

                    </div>

                    <dialog
                      class="cadastros-modal"
                      id="modalEditarRaca<?= htmlspecialchars($raca['id']) ?>"
                    >

                      <div class="cadastros-modal-header">

                        <div>
                          <h2>Editar raça</h2>
                          <p>Atualize o nome da raça selecionada.</p>
                        </div>

                        <button
                          type="button"
                          class="cadastros-modal-close"
                          onclick="document.getElementById('modalEditarRaca<?= htmlspecialchars($raca['id']) ?>').close()"
                        >
                          <i class="ri-close-line"></i>
                        </button>

                      </div>

                      <form method="POST" action="<?= BASE_URL ?>/racas/atualizar">

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($raca['id']) ?>"
                        >

                        <div class="cadastros-field">
                          <label for="editar_nome_raca_<?= htmlspecialchars($raca['id']) ?>">Nome da raça</label>

                          <input
                            type="text"
                            id="editar_nome_raca_<?= htmlspecialchars($raca['id']) ?>"
                            name="nome_raca"
                            value="<?= htmlspecialchars($raca['nome_raca']) ?>"
                            required
                          >
                        </div>

                        <div class="cadastros-modal-footer">

                          <button
                            type="button"
                            class="action-btn cadastros-btn-cancelar"
                            onclick="document.getElementById('modalEditarRaca<?= htmlspecialchars($raca['id']) ?>').close()"
                          >
                            Cancelar
                          </button>

                          <button type="submit" class="action-btn">
                            Salvar alterações
                          </button>

                        </div>

                      </form>

                    </dialog>

                    <dialog
                      class="cadastros-modal cadastros-modal-danger"
                      id="modalExcluirRaca<?= htmlspecialchars($raca['id']) ?>"
                    >

                      <div class="cadastros-modal-header">

                        <div>
                          <h2>Excluir raça</h2>
                          <p>Confirme se deseja excluir esta raça.</p>
                        </div>

                        <button
                          type="button"
                          class="cadastros-modal-close"
                          onclick="document.getElementById('modalExcluirRaca<?= htmlspecialchars($raca['id']) ?>').close()"
                        >
                          <i class="ri-close-line"></i>
                        </button>

                      </div>

                      <div class="cadastros-modal-alert">
                        <i class="ri-error-warning-line"></i>

                        <div>
                          <strong><?= htmlspecialchars($raca['nome_raca']) ?></strong>
                          <span>Esta ação não poderá ser desfeita.</span>
                        </div>
                      </div>

                      <form method="POST" action="<?= BASE_URL ?>/racas/excluir">

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($raca['id']) ?>"
                        >

                        <div class="cadastros-modal-footer">

                          <button
                            type="button"
                            class="action-btn cadastros-btn-cancelar"
                            onclick="document.getElementById('modalExcluirRaca<?= htmlspecialchars($raca['id']) ?>').close()"
                          >
                            Cancelar
                          </button>

                          <button type="submit" class="action-btn btn-danger">
                            Confirmar exclusão
                          </button>

                        </div>

                      </form>

                    </dialog>

                  </td>

                </tr>

              <?php endforeach; ?>

              <tr id="racasSearchEmpty" style="display: none;">
                <td colspan="2" class="cadastros-empty">
                  Nenhuma raça encontrada para a pesquisa.
                </td>
              </tr>

            <?php else: ?>

              <tr>
                <td colspan="2" class="cadastros-empty">
                  Nenhuma raça cadastrada.
                </td>
              </tr>

            <?php endif; ?>

          </tbody>

        </table>

      </div>

    </section>

    <dialog class="cadastros-modal" id="modalCadastrarRaca">

      <div class="cadastros-modal-header">

        <div>
          <h2>Cadastrar raça</h2>
          <p>Adicione uma nova raça para usar no cadastro dos animais.</p>
        </div>

        <button
          type="button"
          class="cadastros-modal-close"
          onclick="document.getElementById('modalCadastrarRaca').close()"
        >
          <i class="ri-close-line"></i>
        </button>

      </div>

      <form method="POST" action="<?= BASE_URL ?>/racas/salvar">

        <div class="cadastros-field">
          <label for="nome_raca">Nome da raça</label>

          <input
            type="text"
            id="nome_raca"
            name="nome_raca"
            placeholder="Ex: Nelore"
            required
          >
        </div>

        <div class="cadastros-modal-footer">

          <button
            type="button"
            class="action-btn cadastros-btn-cancelar"
            onclick="document.getElementById('modalCadastrarRaca').close()"
          >
            Cancelar
          </button>

          <button type="submit" class="action-btn">
            Cadastrar Raça
          </button>

        </div>

      </form>

    </dialog>

  </div>

  <div class="cadastros-tab-content cadastros-content-lotes">

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-list-check-2"></i>
          </div>

          <div>
            <h2>Lotes cadastrados</h2>
            <p>Cadastre, atualize ou exclua os lotes cadastrados no sistema.</p>
          </div>
        </div>

        <button
          type="button"
          class="action-btn cadastros-btn-novo"
          onclick="document.getElementById('modalCadastrarLote').showModal()"
        >
          <i class="ri-add-line"></i>
          <span>Novo Lote</span>
        </button>

      </div>

      <div class="cadastros-search-container">

        <div class="cadastros-search-box">
          <i class="ri-search-line"></i>

          <input
            type="text"
            id="pesquisaLotes"
            placeholder="Pesquisar por nome ou descrição do lote..."
            autocomplete="off"
          >
        </div>

      </div>

      <div class="table-responsive">

        <table class="cadastros-table">

          <thead>

            <tr>
              <th>Nome do lote</th>
              <th>Descrição</th>
              <th>Ações</th>
            </tr>

          </thead>

          <tbody>

            <?php if (!empty($lotes)): ?>

              <?php foreach ($lotes as $lote): ?>

                <tr class="cadastros-lote-row">

                  <td>
                    <span class="cadastros-name">
                      <?= htmlspecialchars($lote['nome_lote']) ?>
                    </span>
                  </td>

                  <td>
                    <span class="cadastros-description">
                      <?= !empty($lote['descricao']) ? htmlspecialchars($lote['descricao']) : '-' ?>
                    </span>
                  </td>

                  <td>

                    <div class="cadastros-actions">

                      <button
                        type="button"
                        class="action-btn cadastros-btn-editar"
                        onclick="document.getElementById('modalEditarLote<?= htmlspecialchars($lote['id']) ?>').showModal()"
                      >
                        <i class="ri-edit-line"></i>
                        <span>Editar</span>
                      </button>

                      <button
                        type="button"
                        class="action-btn btn-danger cadastros-btn-excluir"
                        onclick="document.getElementById('modalExcluirLote<?= htmlspecialchars($lote['id']) ?>').showModal()"
                      >
                        <i class="ri-delete-bin-line"></i>
                        <span>Excluir</span>
                      </button>

                    </div>

                    <dialog
                      class="cadastros-modal"
                      id="modalEditarLote<?= htmlspecialchars($lote['id']) ?>"
                    >

                      <div class="cadastros-modal-header">

                        <div>
                          <h2>Editar lote</h2>
                          <p>Atualize os dados do lote selecionado.</p>
                        </div>

                        <button
                          type="button"
                          class="cadastros-modal-close"
                          onclick="document.getElementById('modalEditarLote<?= htmlspecialchars($lote['id']) ?>').close()"
                        >
                          <i class="ri-close-line"></i>
                        </button>

                      </div>

                      <form method="POST" action="<?= BASE_URL ?>/lotes/atualizar">

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($lote['id']) ?>"
                        >

                        <div class="cadastros-field">
                          <label for="editar_nome_lote_<?= htmlspecialchars($lote['id']) ?>">Nome do lote</label>

                          <input
                            type="text"
                            id="editar_nome_lote_<?= htmlspecialchars($lote['id']) ?>"
                            name="nome_lote"
                            value="<?= htmlspecialchars($lote['nome_lote']) ?>"
                            required
                          >
                        </div>

                        <div class="cadastros-field">
                          <label for="editar_descricao_lote_<?= htmlspecialchars($lote['id']) ?>">Descrição</label>

                          <input
                            type="text"
                            id="editar_descricao_lote_<?= htmlspecialchars($lote['id']) ?>"
                            name="descricao"
                            value="<?= htmlspecialchars($lote['descricao'] ?? '') ?>"
                            placeholder="Ex: Animais em fase de engorda"
                          >
                        </div>

                        <div class="cadastros-modal-footer">

                          <button
                            type="button"
                            class="action-btn cadastros-btn-cancelar"
                            onclick="document.getElementById('modalEditarLote<?= htmlspecialchars($lote['id']) ?>').close()"
                          >
                            Cancelar
                          </button>

                          <button type="submit" class="action-btn">
                            Salvar alterações
                          </button>

                        </div>

                      </form>

                    </dialog>

                    <dialog
                      class="cadastros-modal cadastros-modal-danger"
                      id="modalExcluirLote<?= htmlspecialchars($lote['id']) ?>"
                    >

                      <div class="cadastros-modal-header">

                        <div>
                          <h2>Excluir lote</h2>
                          <p>Confirme se deseja excluir este lote.</p>
                        </div>

                        <button
                          type="button"
                          class="cadastros-modal-close"
                          onclick="document.getElementById('modalExcluirLote<?= htmlspecialchars($lote['id']) ?>').close()"
                        >
                          <i class="ri-close-line"></i>
                        </button>

                      </div>

                      <div class="cadastros-modal-alert">
                        <i class="ri-error-warning-line"></i>

                        <div>
                          <strong><?= htmlspecialchars($lote['nome_lote']) ?></strong>
                          <span>Esta ação não poderá ser desfeita.</span>
                        </div>
                      </div>

                      <form method="POST" action="<?= BASE_URL ?>/lotes/excluir">

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($lote['id']) ?>"
                        >

                        <div class="cadastros-modal-footer">

                          <button
                            type="button"
                            class="action-btn cadastros-btn-cancelar"
                            onclick="document.getElementById('modalExcluirLote<?= htmlspecialchars($lote['id']) ?>').close()"
                          >
                            Cancelar
                          </button>

                          <button type="submit" class="action-btn btn-danger">
                            Confirmar exclusão
                          </button>

                        </div>

                      </form>

                    </dialog>

                  </td>

                </tr>

              <?php endforeach; ?>

              <tr id="lotesSearchEmpty" style="display: none;">
                <td colspan="3" class="cadastros-empty">
                  Nenhum lote encontrado para a pesquisa.
                </td>
              </tr>

            <?php else: ?>

              <tr>
                <td colspan="3" class="cadastros-empty">
                  Nenhum lote cadastrado.
                </td>
              </tr>

            <?php endif; ?>

          </tbody>

        </table>

      </div>

    </section>

    <dialog class="cadastros-modal" id="modalCadastrarLote">

      <div class="cadastros-modal-header">

        <div>
          <h2>Cadastrar lote</h2>
          <p>Adicione um novo lote para organizar os animais da fazenda.</p>
        </div>

        <button
          type="button"
          class="cadastros-modal-close"
          onclick="document.getElementById('modalCadastrarLote').close()"
        >
          <i class="ri-close-line"></i>
        </button>

      </div>

      <form method="POST" action="<?= BASE_URL ?>/lotes/salvar">

        <div class="cadastros-field">
          <label for="nome_lote">Nome do lote</label>

          <input
            type="text"
            id="nome_lote"
            name="nome_lote"
            placeholder="Ex: Lote A"
            required
          >
        </div>

        <div class="cadastros-field">
          <label for="descricao">Descrição</label>

          <input
            type="text"
            id="descricao"
            name="descricao"
            placeholder="Ex: Animais em fase de engorda"
          >
        </div>

        <div class="cadastros-modal-footer">

          <button
            type="button"
            class="action-btn cadastros-btn-cancelar"
            onclick="document.getElementById('modalCadastrarLote').close()"
          >
            Cancelar
          </button>

          <button type="submit" class="action-btn">
            Cadastrar Lote
          </button>

        </div>

      </form>

    </dialog>

  </div>

</main>