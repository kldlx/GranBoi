<div class="modal" id="modalEditarAnimal">

  <div class="modal-overlay" data-close-modal="modalEditarAnimal"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Editar Animal</h2>
        <p>Atualize os dados do animal selecionado</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalEditarAnimal"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/animal/atualizar"
      id="formEditarAnimal"
    >

      <input type="hidden" id="editar_id" name="id">

      <div
        class="animal-modal-message"
        id="editarAnimalModalMessage"
        hidden
      ></div>

      <div
        class="animal-status-warning"
        id="editarAnimalStatusWarning"
        hidden
    ></div>

      <div class="modal-body animal-modal-body">

        <div class="animal-form-grid">

          <div class="animal-form-group">
            <label for="editar_brinco">Número do Brinco — não editável</label>
            <input
  type="text"
  id="editar_brinco"
  disabled
>

<input
  type="hidden"
  id="editar_brinco_hidden"
  name="brinco"
>
          </div>

          <div class="animal-form-group">
            <label for="editar_raca">Raça</label>
            <input
              type="text"
              id="editar_raca"
              name="raca"
            >
          </div>

          <div class="animal-form-group">
            <label for="editar_lote">Lote</label>
            <input
              type="text"
              id="editar_lote"
              name="lote"
            >
          </div>

          <div class="animal-form-group">
            <label for="editar_sexo">Sexo</label>
            <select id="editar_sexo" name="sexo" required>
              <option value="">Selecione</option>
              <option value="Macho">Macho</option>
              <option value="Fêmea">Fêmea</option>
            </select>
          </div>

          <div class="animal-form-group">
  <label for="editar_peso_entrada">Peso atual — alterado somente em Pesagem</label>

  <input
    type="text"
    id="editar_peso_entrada"
    disabled
  >

  <input
    type="hidden"
    id="editar_peso_entrada_hidden"
    name="peso_entrada"
  >
</div>

          <div class="animal-form-group">
            <label for="editar_data_nascimento">Data de Nascimento</label>
            <input
              type="date"
              id="editar_data_nascimento"
              name="data_nascimento"
            >
          </div>

          <div class="animal-form-group">
            <label for="editar_status">Status</label>
            <select id="editar_status" name="status" required>
              <option value="ativo">Ativo</option>
              <option value="vendido">Vendido</option>
              <option value="morto">Morto</option>
            </select>
          </div>

          <div class="animal-form-group animal-form-full">
            <label for="editar_observacoes">Observações</label>
            <textarea
              id="editar_observacoes"
              name="observacoes"
              rows="4"
            ></textarea>
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalEditarAnimal"
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