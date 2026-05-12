<main class="main-content">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Controle de Pesagem</h1>

      <p>
        Registre pesos, acompanhe evolução e calcule o GMD dos animais
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

    <div class="peso-message peso-message-success">
      <i class="ri-checkbox-circle-line"></i>
      <span><?= $_SESSION['sucesso'] ?></span>
    </div>

    <?php unset($_SESSION['sucesso']); ?>

  <?php endif; ?>

  <?php if (!empty($_SESSION['erro'])): ?>

    <div class="peso-message peso-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>

    <?php unset($_SESSION['erro']); ?>

  <?php endif; ?>

  <section class="peso-grid">

    <aside class="peso-card">

  <h2>Nova Pesagem</h2>

  <p>
    Selecione um animal e registre o peso atual.
  </p>

  <div
    class="peso-form-message"
    id="pesoFormMessage"
    hidden
  ></div>

  <?php if (!empty($animalSelecionado) && $animalSelecionado['status'] !== 'ativo'): ?>

  <div class="peso-form-message error">
    Não é possível registrar nova pesagem para animal <?= htmlspecialchars($animalSelecionado['status']) ?>.
  </div>

<?php endif; ?>

  <form method="POST" action="<?= BASE_URL ?>/peso/salvar" id="formPesagem">

        <div class="peso-form-group">

          <label for="animal_id">Animal</label>

          <select id="animal_id" name="animal_id" required>

            <option value="">Selecione um animal</option>

            <?php foreach ($animais as $animal): ?>

              <option
                value="<?= htmlspecialchars($animal['id']) ?>"
                <?= !empty($animalSelecionado) && $animalSelecionado['id'] == $animal['id'] ? 'selected' : '' ?>
              >
                #<?= htmlspecialchars($animal['brinco_identificador']) ?>
                <?= !empty($animal['raca']) ? ' - ' . htmlspecialchars($animal['raca']) : '' ?>
              </option>

            <?php endforeach; ?>

          </select>

        </div>

        <div class="peso-form-group">

  <label for="peso_atual">Peso atual registrado</label>

  <input
    type="text"
    id="peso_atual"
    value="<?= $pesoAtual !== null ? htmlspecialchars($pesoAtual) . ' kg' : 'Selecione um animal' ?>"
    disabled
  >

</div>

<div class="peso-form-group">

  <label for="peso">Nova pesagem</label>

  <input
    type="number"
    step="0.01"
    id="peso"
    name="peso"
    placeholder="Ex: 430"
    required
    <?= empty($animalSelecionado) ? 'disabled' : '' ?>
  >

</div>

        <div class="peso-form-group">

          <label for="observacao">Observação</label>

          <textarea
            id="observacao"
            name="observacao"
            placeholder="Ex: Pesagem realizada após manejo..."
          ></textarea>

        </div>

        <button
  type="submit"
  class="peso-submit-btn"
  <?= !empty($animalSelecionado) && $animalSelecionado['status'] !== 'ativo' ? 'disabled' : '' ?>
>
  Registrar Pesagem
</button>
      </form>

    </aside>

    <section>

      <div class="peso-summary">

        <div class="peso-summary-card">
          <span>Animal Selecionado</span>
          <strong>
            <?= !empty($animalSelecionado) ? '#' . htmlspecialchars($animalSelecionado['brinco_identificador']) : '-' ?>
          </strong>
        </div>

        <div class="peso-summary-card">
          <span>Total de Pesagens</span>
          <strong><?= count($historico) ?></strong>
        </div>

        <div class="peso-summary-card">
          <span>GMD</span>
          <strong>
            <?= $gmd !== null ? htmlspecialchars($gmd) . ' kg/dia' : '-' ?>
          </strong>
        </div>

      </div>

      <div class="peso-table-card">

        <h2>Histórico de Pesagens</h2>

        <table class="peso-table">

          <thead>

            <tr>
              <th>Data</th>
              <th>Peso</th>
              <th>Observação</th>
            </tr>

          </thead>

          <tbody>

            <?php if (!empty($historico)): ?>

              <?php foreach ($historico as $item): ?>

                <tr>

                  <td>
                    <?= date('d/m/Y H:i', strtotime($item['data_registro'])) ?>
                  </td>

                  <td>
                    <?= htmlspecialchars($item['peso']) ?> kg
                  </td>

                  <td>
                    <?= htmlspecialchars($item['observacao'] ?? '-') ?>
                  </td>

                </tr>

              <?php endforeach; ?>

            <?php else: ?>

              <tr>
                <td colspan="3" class="peso-empty">
                  Selecione um animal para visualizar o histórico.
                </td>
              </tr>

            <?php endif; ?>

          </tbody>

        </table>

      </div>

    </section>

  </section>

</main>