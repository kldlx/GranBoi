<main class="main-content">

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

  <section class="section-header-page">

    <div>
      <h1>Raças</h1>
      <p>Cadastre, edite e gerencie as raças dos animais da fazenda.</p>
    </div>

  </section>

  <section class="form-container">

    <div class="section-header">
      <h2>Cadastrar nova raça</h2>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/racas/salvar">

      <div class="input-row">

        <div class="input-group">
          <label for="nome_raca">Nome da raça</label>
          <input
            type="text"
            id="nome_raca"
            name="nome_raca"
            placeholder="Ex: Nelore"
            required
          >
        </div>

        <div class="input-group">
          <label>&nbsp;</label>
          <button type="submit" class="save-btn">
            Cadastrar Raça
          </button>
        </div>

      </div>

    </form>

  </section>

  <section class="table-box" style="margin-top: 24px;">

    <div class="section-header">
      <h2>Raças cadastradas</h2>
    </div>

    <div class="table-responsive">

      <table>

        <thead>

          <tr>
            <th>ID</th>
            <th>Nome da raça</th>
            <th>Ações</th>
          </tr>

        </thead>

        <tbody>

          <?php if (!empty($racas)): ?>

            <?php foreach ($racas as $raca): ?>

              <tr>

                <td>
                  <?= htmlspecialchars($raca['id']) ?>
                </td>

                <td>
                  <?= htmlspecialchars($raca['nome_raca']) ?>
                </td>

                <td>

                  <form
                    method="POST"
                    action="<?= BASE_URL ?>/racas/atualizar"
                    style="display: inline-flex; gap: 8px; align-items: center; margin-bottom: 8px;"
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
                      style="height: 42px; border: 1px solid #ddd; border-radius: 12px; padding: 0 12px;"
                    >

                    <button type="submit" class="action-btn">
                      Atualizar
                    </button>

                  </form>

                  <form
                    method="POST"
                    action="<?= BASE_URL ?>/racas/excluir"
                    style="display: inline-flex;"
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

                </td>

              </tr>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="3">
                Nenhuma raça cadastrada.
              </td>
            </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

  </section>

</main>