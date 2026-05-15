<div class="modal" id="modalExcluirVacinacao">

  <div
    class="modal-overlay"
    data-close-modal="modalExcluirVacinacao"
  ></div>

  <div class="modal-container modal-sm">

    <div class="modal-header">

      <div>
        <h2>Excluir Vacinação</h2>
        <p>Confirme a exclusão do registro sanitário</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalExcluirVacinacao"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/vacinas/excluir"
      id="formExcluirVacinacao"
    >

      <input
        type="hidden"
        id="excluir_vacinacao_id"
        name="id"
      >

      <div
        class="vacinacao-modal-message"
        id="excluirVacinacaoModalMessage"
        hidden
      ></div>

      <div class="modal-body">

        <div class="delete-message">
          <p>
            Tem certeza que deseja excluir a vacinação
            <strong id="excluirVacinacaoVacina"></strong>
            do animal
            <strong id="excluirVacinacaoAnimal"></strong>?
          </p>

          <p>
            Esta ação removerá o registro do histórico sanitário e não poderá ser desfeita.
          </p>
        </div>

      </div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalExcluirVacinacao"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-excluir"
        >
          Confirmar Exclusão
        </button>

      </div>

    </form>

  </div>

</div>