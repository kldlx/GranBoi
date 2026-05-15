<div class="modal" id="modalDesativarFuncionario">

  <div
    class="modal-overlay"
    data-close-modal="modalDesativarFuncionario"
  ></div>

  <div class="modal-container modal-sm">

    <div class="modal-header">

      <div>
        <h2>Desativar Funcionário</h2>
        <p>Confirme a desativação do acesso</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalDesativarFuncionario"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/funcionarios/desativar"
      id="formDesativarFuncionario"
    >

      <input
        type="hidden"
        id="desativar_funcionario_id"
        name="id"
      >

      <div
        class="funcionario-modal-message"
        id="desativarFuncionarioModalMessage"
        hidden
      ></div>

      <div class="modal-body funcionario-modal-body">

        <p class="delete-message">
          Tem certeza que deseja desativar o funcionário
          <strong id="desativarFuncionarioNome"></strong>?
        </p>

        <p class="delete-warning">
          O funcionário não conseguirá mais acessar o sistema, mas seus registros e histórico serão preservados.
        </p>

      </div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalDesativarFuncionario"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-excluir"
        >
          Desativar Funcionário
        </button>

      </div>

    </form>

  </div>

</div>