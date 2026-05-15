<div class="modal" id="modalEditarFuncionario">

  <div
    class="modal-overlay"
    data-close-modal="modalEditarFuncionario"
  ></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Editar Funcionário</h2>
        <p>Atualize os dados e o acesso do funcionário</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalEditarFuncionario"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/funcionarios/atualizar"
      id="formEditarFuncionario"
    >

      <input
        type="hidden"
        id="editar_funcionario_id"
        name="id"
      >

      <div
        class="funcionario-modal-message"
        id="editarFuncionarioModalMessage"
        hidden
      ></div>

      <div class="modal-body funcionario-modal-body">

        <div class="funcionario-form-grid">

          <div class="funcionario-form-group">
            <label for="editar_nome_completo">Nome Completo</label>

            <input
              type="text"
              id="editar_nome_completo"
              name="nome_completo"
              maxlength="150"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="editar_nome_social">Nome Social</label>

            <input
              type="text"
              id="editar_nome_social"
              name="nome_social"
              placeholder="Opcional"
              maxlength="50"
            >
          </div>

          <div class="funcionario-form-group">
            <label for="editar_cpf">CPF</label>

            <input
              type="text"
              id="editar_cpf"
              name="cpf"
              placeholder="000.000.000-00"
              maxlength="14"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="editar_telefone">Telefone</label>

            <input
              type="text"
              id="editar_telefone"
              name="telefone"
              placeholder="(00) 00000-0000"
              maxlength="15"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="editar_email">E-mail</label>

            <input
              type="email"
              id="editar_email"
              name="email"
              maxlength="100"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="editar_papel_id">Função no Sistema</label>

            <select
              id="editar_papel_id"
              name="papel_id"
              required
            >
              <option value="">Selecione uma função</option>

              <?php if (!empty($papeis)): ?>

                <?php foreach ($papeis as $papel): ?>

                  <option value="<?= htmlspecialchars($papel['id']) ?>">
                    <?= htmlspecialchars($papel['nome']) ?>
                  </option>

                <?php endforeach; ?>

              <?php endif; ?>

            </select>
          </div>

          <div class="funcionario-form-group">
            <label for="editar_status">Status</label>

            <select
              id="editar_status"
              name="status"
              required
            >
              <option value="ativo">Ativo</option>
              <option value="inativo">Inativo</option>
            </select>
          </div>

          <div class="funcionario-form-group">
            <label for="editar_senha">Nova Senha</label>

            <input
              type="password"
              id="editar_senha"
              name="senha"
              placeholder="Deixe em branco para manter"
              maxlength="50"
            >
          </div>

          <div class="funcionario-form-group">
            <label for="editar_senha_confirmacao">Confirmar Nova Senha</label>

            <input
              type="password"
              id="editar_senha_confirmacao"
              name="senha_confirmacao"
              placeholder="Repita a nova senha"
              maxlength="50"
            >
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalEditarFuncionario"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-salvar"
        >
          Salvar Alterações
        </button>

      </div>

    </form>

  </div>

</div>