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

  <section class="page-actions">

    <div>
      <h2>Lista de Gado</h2>
      <p>
        Animais cadastrados no sistema
      </p>
    </div>

    <a
      href="<?= BASE_URL ?>/animal/cadastrar"
      class="primary-action"
    >
      <i class="ri-add-line"></i>
      Cadastrar Animal
    </a>

  </section>

  <section class="table-container">

    <table>

      <thead>

        <tr>
          <th>ID</th>
          <th>Brinco</th>
          <th>Nome</th>
          <th>Raça</th>
          <th>Sexo</th>
          <th>Peso</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>

      </thead>

      <tbody>

        <?php if (!empty($animais)): ?>

          <?php foreach ($animais as $animal): ?>

            <tr>

              <td><?= htmlspecialchars($animal['id']) ?></td>

              <td>
                #<?= htmlspecialchars($animal['brinco_identificador']) ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['nome'] ?? '-') ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['raca'] ?? '-') ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['sexo']) ?>
              </td>

              <td>
                <?= htmlspecialchars($animal['peso_entrada']) ?> kg
              </td>

              <td>
                <span class="status-badge status-<?= htmlspecialchars($animal['status']) ?>">
                  <?= htmlspecialchars($animal['status']) ?>
                </span>
              </td>

              <td>

                <div class="actions">

                  <a
                    href="<?= BASE_URL ?>/animal/detalhes?id=<?= $animal['id'] ?>"
                    class="action-btn"
                    title="Ver detalhes"
                  >
                    <i class="ri-eye-line"></i>
                  </a>

                  <a
                    href="<?= BASE_URL ?>/animal/editar?id=<?= $animal['id'] ?>"
                    class="action-btn"
                    title="Editar animal"
                  >
                    <i class="ri-edit-line"></i>
                  </a>

                  <a
                    href="<?= BASE_URL ?>/animal/excluir?id=<?= $animal['id'] ?>"
                    class="action-btn danger"
                    title="Excluir animal"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </a>

                </div>

              </td>

            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="8" class="empty-message">
              Nenhum animal cadastrado.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

</main>
