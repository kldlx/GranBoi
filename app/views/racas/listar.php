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
            <i class="ri-git-branch-line"></i>
          </div>

          <div>
            <h2>Cadastrar nova raça</h2>
            <p>Adicione uma raça para usar no cadastro dos animais.</p>
          </div>
        </div>

      </div>

      <form method="POST" action="<?= BASE_URL ?>/racas/salvar">

        <div class="cadastros-form-grid">

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

          <button type="submit" class="save-btn">
            Cadastrar Raça
          </button>

        </div>

      </form>

    </section>

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-list-check-2"></i>
          </div>

          <div>
            <h2>Raças cadastradas</h2>
            <p>Atualize ou exclua as raças cadastradas no sistema.</p>
          </div>
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

                <tr>

                  <td>
                    <span class="cadastros-name">
                      <?= htmlspecialchars($raca['nome_raca']) ?>
                    </span>
                  </td>

                  <td>

                    <div class="cadastros-actions">

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/racas/atualizar"
                        class="cadastros-actions-form"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($raca['id']) ?>"
                        >

                        <input
                          type="text"
                          name="nome_raca"
                          value="<?= htmlspecialchars($raca['nome_raca']) ?>"
                          required
                          class="cadastros-inline-input"
                        >

                        <button type="submit" class="action-btn">
                          Atualizar
                        </button>

                      </form>

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/racas/excluir"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta raça?');"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($raca['id']) ?>"
                        >

                        <button type="submit" class="action-btn btn-danger">
                          Excluir
                        </button>

                      </form>

                    </div>

                  </td>

                </tr>

              <?php endforeach; ?>

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

  </div>

  <div class="cadastros-tab-content cadastros-content-lotes">

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-stack-line"></i>
          </div>

          <div>
            <h2>Cadastrar novo lote</h2>
            <p>Adicione lotes para organizar os animais da fazenda.</p>
          </div>
        </div>

      </div>

      <form method="POST" action="<?= BASE_URL ?>/lotes/salvar">

        <div class="cadastros-form-grid cadastros-form-grid-lote">

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

          <button type="submit" class="save-btn">
            Cadastrar Lote
          </button>

        </div>

      </form>

    </section>

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-list-check-2"></i>
          </div>

          <div>
            <h2>Lotes cadastrados</h2>
            <p>Atualize ou exclua os lotes cadastrados no sistema.</p>
          </div>
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

                <tr>

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

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/lotes/atualizar"
                        class="cadastros-actions-form"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($lote['id']) ?>"
                        >

                        <input
                          type="text"
                          name="nome_lote"
                          value="<?= htmlspecialchars($lote['nome_lote']) ?>"
                          required
                          class="cadastros-inline-input"
                        >

                        <input
                          type="text"
                          name="descricao"
                          value="<?= htmlspecialchars($lote['descricao'] ?? '') ?>"
                          placeholder="Descrição"
                          class="cadastros-inline-input"
                        >

                        <button type="submit" class="action-btn">
                          Atualizar
                        </button>

                      </form>

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/lotes/excluir"
                        onsubmit="return confirm('Tem certeza que deseja excluir este lote?');"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($lote['id']) ?>"
                        >

                        <button type="submit" class="action-btn btn-danger">
                          Excluir
                        </button>

                      </form>

                    </div>

                  </td>

                </tr>

              <?php endforeach; ?>

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

  </div>

</main>