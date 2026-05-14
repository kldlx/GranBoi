<main class="main-content">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Gestão de Gado</h1>

      <p>
        Consulte, cadastre e gerencie os animais do rebanho
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

  <section class="page-actions">

    <div>
      <h2>Lista de Gado</h2>
      <p>
        Animais cadastrados no sistema
      </p>
    </div>

    <button
      type="button"
      class="animal-create-btn"
      id="abrirModalCadastrarAnimal"
    >
      <i class="ri-add-line"></i>
      <span>Cadastrar Animal</span>
    </button>

  </section>

  <section class="table-container">

    <table>

      <thead>

        <tr>
          <th>Brinco</th>
          <th>Raça</th>
          <th>Sexo</th>
          <th>Peso Atual</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>

      </thead>

      <tbody>

        <?php if (!empty($animais)): ?>

          <?php foreach ($animais as $animal): ?>

            <tr>

              <td>
                #<?= htmlspecialchars($animal['brinco_identificador']) ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['raca'] ?? '-') ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['sexo']) ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['peso_atual'] ?? $animal['peso_entrada']) ?> kg
              </td>

              <td>
                <span class="status-badge status-<?= htmlspecialchars($animal['status']) ?>">
                  <?= ucfirst(htmlspecialchars($animal['status'])) ?>
                </span>
              </td>

              <td>

                <div class="actions">

                  <button
                    type="button"
                    class="action-btn detalhes-animal-btn"
                    title="Ver detalhes"
                    data-id="<?= htmlspecialchars($animal['id']) ?>"
                    data-brinco="<?= htmlspecialchars($animal['brinco_identificador']) ?>"
                    data-raca="<?= htmlspecialchars($animal['raca'] ?? '') ?>"
                    data-lote="<?= htmlspecialchars($animal['lote'] ?? '') ?>"
                    data-sexo="<?= htmlspecialchars($animal['sexo']) ?>"
                    data-peso="<?= htmlspecialchars($animal['peso_atual'] ?? $animal['peso_entrada']) ?>"
                    data-data-nascimento="<?= htmlspecialchars($animal['data_nascimento'] ?? '') ?>"
                    data-status="<?= htmlspecialchars($animal['status']) ?>"
                    data-observacoes="<?= htmlspecialchars($animal['observacoes'] ?? '') ?>"
                  >
                    <i class="ri-eye-line"></i>
                  </button>

                  <button
                    type="button"
                    class="action-btn editar-animal-btn"
                    title="Editar animal"
                    data-id="<?= htmlspecialchars($animal['id']) ?>"
                    data-brinco="<?= htmlspecialchars($animal['brinco_identificador']) ?>"
                    data-raca="<?= htmlspecialchars($animal['raca'] ?? '') ?>"
                    data-lote="<?= htmlspecialchars($animal['lote'] ?? '') ?>"
                    data-sexo="<?= htmlspecialchars($animal['sexo']) ?>"
                    data-peso="<?= htmlspecialchars($animal['peso_atual'] ?? $animal['peso_entrada']) ?>"
                    data-data-nascimento="<?= htmlspecialchars($animal['data_nascimento'] ?? '') ?>"
                    data-status="<?= htmlspecialchars($animal['status']) ?>"
                    data-observacoes="<?= htmlspecialchars($animal['observacoes'] ?? '') ?>"
                  >
                    <i class="ri-edit-line"></i>
                  </button>

                  <?php if (strtolower($animal['status']) === 'ativo'): ?>

                    <a
                      href="<?= BASE_URL ?>/peso?animal_id=<?= htmlspecialchars($animal['id']) ?>"
                      class="action-btn pesagem-animal-btn"
                      title="Controle de pesagem"
                    >
                      <i class="ri-scales-3-line"></i>
                    </a>

                  <?php else: ?>

                    <button
                      type="button"
                      class="action-btn action-btn-disabled"
                      title="Pesagem indisponível para animal <?= htmlspecialchars($animal['status']) ?>"
                      disabled
                    >
                      <i class="ri-scales-3-line"></i>
                    </button>

                  <?php endif; ?>

                  <button
                    type="button"
                    class="action-btn danger excluir-animal-btn"
                    title="Excluir animal"
                    data-id="<?= htmlspecialchars($animal['id']) ?>"
                    data-brinco="<?= htmlspecialchars($animal['brinco_identificador']) ?>"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>

                </div>

              </td>

            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="6" class="empty-message">
              Nenhum animal cadastrado.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <?php require_once ROOT_PATH . '/app/views/components/modals/animal/modal-cadastrar-animal.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/animal/modal-editar-animal.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/animal/modal-excluir-animal.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/animal/modal-detalhes-animal.php'; ?>

</main>