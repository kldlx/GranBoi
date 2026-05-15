<main class="main-content funcionarios-page">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Funcionários</h1>

      <p>
        Gerencie os funcionários e os acessos ao sistema
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

    <div class="funcionario-message funcionario-message-success">
      <i class="ri-checkbox-circle-line"></i>
      <span><?= $_SESSION['sucesso'] ?></span>
    </div>

    <?php unset($_SESSION['sucesso']); ?>

  <?php endif; ?>

  <?php if (!empty($_SESSION['erro'])): ?>

    <div class="funcionario-message funcionario-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>

    <?php unset($_SESSION['erro']); ?>

  <?php endif; ?>

  <section class="funcionario-page-actions">

    <div>
      <h2>Lista de Funcionários</h2>
      <p>Usuários cadastrados no sistema</p>
    </div>

    <button
      type="button"
      class="funcionario-create-btn"
      id="abrirModalCadastrarFuncionario"
    >
      <i class="ri-add-line"></i>
      <span>Cadastrar Funcionário</span>
    </button>

  </section>

  <section class="funcionario-filtros-container">

    <div class="funcionario-search-box">
      <i class="ri-search-line"></i>

      <input
        type="text"
        id="pesquisaFuncionario"
        placeholder="Pesquisar por nome, CPF, telefone, e-mail, função ou status..."
        autocomplete="off"
      >
    </div>

    <div class="funcionario-status-filters">

      <button
        type="button"
        class="funcionario-filter-btn active"
        data-status-filter="todos"
      >
        Todos
      </button>

      <button
        type="button"
        class="funcionario-filter-btn"
        data-status-filter="ativo"
      >
        Ativos
      </button>

      <button
        type="button"
        class="funcionario-filter-btn"
        data-status-filter="inativo"
      >
        Inativos
      </button>

    </div>

  </section>

  <section class="funcionario-table-container">

    <table class="funcionario-table">

      <thead>

        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Telefone</th>
          <th>E-mail</th>
          <th>Função</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>

      </thead>

      <tbody id="tabelaFuncionarioBody">

        <?php if (!empty($funcionarios)): ?>

          <?php foreach ($funcionarios as $funcionario): ?>

            <?php
              $statusFuncionario = strtolower(trim($funcionario['status'] ?? 'ativo'));
              $cpfFormatado = !empty($funcionario['cpf'])
                  ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $funcionario['cpf'])
                  : '-';

              $telefoneLimpo = preg_replace('/\D/', '', $funcionario['telefone_movel'] ?? '');

              if (strlen($telefoneLimpo) === 11) {
                  $telefoneFormatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefoneLimpo);
              } elseif (strlen($telefoneLimpo) === 10) {
                  $telefoneFormatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefoneLimpo);
              } else {
                  $telefoneFormatado = !empty($telefoneLimpo) ? htmlspecialchars($telefoneLimpo) : '-';
              }
            ?>

            <tr
              class="funcionario-row"
              data-status="<?= htmlspecialchars($statusFuncionario) ?>"
            >

              <td>
                <?= htmlspecialchars($funcionario['nome_completo'] ?? '-') ?>
              </td>

              <td>
                <?= htmlspecialchars($cpfFormatado) ?>
              </td>

              <td>
                <?= htmlspecialchars($telefoneFormatado) ?>
              </td>

              <td>
                <?= htmlspecialchars($funcionario['email'] ?? '-') ?>
              </td>

              <td>
                <?= htmlspecialchars($funcionario['papel_nome'] ?? '-') ?>
              </td>

              <td>
                <span class="funcionario-status funcionario-status-<?= htmlspecialchars($statusFuncionario) ?>">
                  <?= ucfirst(htmlspecialchars($statusFuncionario)) ?>
                </span>
              </td>

              <td>

                <div class="funcionario-actions">

                  <button
                    type="button"
                    class="action-btn editar-funcionario-btn"
                    title="Editar funcionário"
                    data-id="<?= htmlspecialchars($funcionario['id']) ?>"
                    data-nome-completo="<?= htmlspecialchars($funcionario['nome_completo'] ?? '') ?>"
                    data-nome-social="<?= htmlspecialchars($funcionario['nome_social'] ?? '') ?>"
                    data-cpf="<?= htmlspecialchars($funcionario['cpf'] ?? '') ?>"
                    data-telefone="<?= htmlspecialchars($funcionario['telefone_movel'] ?? '') ?>"
                    data-email="<?= htmlspecialchars($funcionario['email'] ?? '') ?>"
                    data-papel-id="<?= htmlspecialchars($funcionario['papel_id'] ?? '') ?>"
                    data-status="<?= htmlspecialchars($statusFuncionario) ?>"
                  >
                    <i class="ri-edit-line"></i>
                  </button>

                  <?php if ($statusFuncionario === 'ativo'): ?>

                    <button
                      type="button"
                      class="action-btn danger desativar-funcionario-btn"
                      title="Desativar funcionário"
                      data-id="<?= htmlspecialchars($funcionario['id']) ?>"
                      data-nome="<?= htmlspecialchars($funcionario['nome_completo'] ?? '') ?>"
                    >
                      <i class="ri-user-unfollow-line"></i>
                    </button>

                  <?php else: ?>

                    <form
                      method="POST"
                      action="<?= BASE_URL ?>/funcionarios/reativar"
                      class="funcionario-reativar-form"
                    >
                      <input
                        type="hidden"
                        name="id"
                        value="<?= htmlspecialchars($funcionario['id']) ?>"
                      >

                      <button
                        type="submit"
                        class="action-btn reativar-funcionario-btn"
                        title="Reativar funcionário"
                      >
                        <i class="ri-user-follow-line"></i>
                      </button>
                    </form>

                  <?php endif; ?>

                </div>

              </td>

            </tr>

          <?php endforeach; ?>

          <tr id="funcionarioSearchEmpty" style="display: none;">
            <td colspan="7" class="funcionario-empty">
              Nenhum funcionário encontrado para a pesquisa ou filtro selecionado.
            </td>
          </tr>

        <?php else: ?>

          <tr>
            <td colspan="7" class="funcionario-empty">
              Nenhum funcionário cadastrado.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <?php require_once ROOT_PATH . '/app/views/components/modals/usuario/modal-cadastrar-usuario.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/usuario/modal-editar-usuario.php'; ?>

  <?php require_once ROOT_PATH . '/app/views/components/modals/usuario/modal-desativar-usuario.php'; ?>

</main>