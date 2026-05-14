<div class="modal" id="modalExcluirAnimal">

  <div class="modal-overlay" data-close-modal="modalExcluirAnimal"></div>

  <div class="modal-container modal-sm">

    <div class="modal-header">

      <div>
        <h2>Excluir Animal</h2>
        <p>Confirme a exclusão do animal selecionado</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalExcluirAnimal"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/animal/excluir"
      id="formExcluirAnimal"
    >

      <input type="hidden" id="excluir_animal_id" name="id">

      <div
        class="animal-modal-message"
        id="excluirAnimalModalMessage"
        hidden
      ></div>

      <div class="modal-body animal-modal-body">

        <p class="delete-message">
          Tem certeza que deseja excluir o animal de brinco
          <strong id="excluir_animal_brinco"></strong>?
        </p>

        <p class="delete-warning">
          O animal deixará de aparecer na listagem, mas seu histórico continuará preservado no sistema.
          Esse brinco continuará reservado e não poderá ser usado em outro animal.
        </p>

      </div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalExcluirAnimal"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-excluir"
        >
          Excluir Animal
        </button>

      </div>

    </form>

  </div>

</div>