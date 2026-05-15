<div class="modal" id="modalCadastrarFuncionario">

  <div
    class="modal-overlay"
    data-close-modal="modalCadastrarFuncionario"
  ></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Cadastrar Funcionário</h2>
        <p>Preencha os dados e defina o acesso ao sistema</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalCadastrarFuncionario"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/funcionarios/salvar"
      id="formCadastrarFuncionario"
    >

      <div
        class="funcionario-modal-message"
        id="cadastrarFuncionarioModalMessage"
        hidden
      ></div>

      <div class="modal-body funcionario-modal-body">

        <div class="funcionario-form-grid">

          <div class="funcionario-form-group">
            <label for="nome_completo">Nome Completo</label>

            <input
              type="text"
              id="nome_completo"
              name="nome_completo"
              placeholder="Ex: João da Silva"
              maxlength="150"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="nome_social">Nome Social</label>

            <input
              type="text"
              id="nome_social"
              name="nome_social"
              placeholder="Opcional"
              maxlength="50"
            >
          </div>

          <div class="funcionario-form-group">
            <label for="cpf">CPF</label>

            <input
              type="text"
              id="cpf"
              name="cpf"
              placeholder="000.000.000-00"
              maxlength="14"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="telefone">Telefone</label>

            <input
              type="text"
              id="telefone"
              name="telefone"
              placeholder="(00) 00000-0000"
              maxlength="15"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="email">E-mail</label>

            <input
              type="email"
              id="email"
              name="email"
              placeholder="funcionario@email.com"
              maxlength="100"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="papel_id">Função no Sistema</label>

            <select
              id="papel_id"
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
            <label for="senha">Senha</label>

            <input
              type="password"
              id="senha"
              name="senha"
              placeholder="Mínimo 6 caracteres"
              maxlength="50"
              required
            >
          </div>

          <div class="funcionario-form-group">
            <label for="senha_confirmacao">Confirmar Senha</label>

            <input
              type="password"
              id="senha_confirmacao"
              name="senha_confirmacao"
              placeholder="Repita a senha"
              maxlength="50"
              required
            >
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalCadastrarFuncionario"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-salvar"
        >
          Salvar Funcionário
        </button>

      </div>

    </form>

  </div>

</div>