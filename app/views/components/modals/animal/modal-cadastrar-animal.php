<div class="modal" id="modalCadastrarAnimal">

  <div class="modal-overlay" data-close-modal="modalCadastrarAnimal"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Cadastrar Animal</h2>
        <p>Preencha os dados do novo animal</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalCadastrarAnimal"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/animal/salvar"
      id="formCadastrarAnimal"
    >

    <div
  class="animal-modal-message"
  id="animalModalMessage"
  hidden
></div>

      <div class="modal-body animal-modal-body">

  <div class="animal-form-grid">

    <div class="animal-form-group">
      <label for="brinco">Número do Brinco</label>
      <input
        type="text"
        id="brinco"
        name="brinco"
        placeholder="Ex: 1024"
        required
      >
    </div>

    <div class="animal-form-group">
      <label for="raca">Raça</label>
      <input
        type="text"
        id="raca"
        name="raca"
        placeholder="Ex: Nelore"
      >
    </div>

    <div class="animal-form-group">
      <label for="lote">Lote</label>
      <input
        type="text"
        id="lote"
        name="lote"
        placeholder="Ex: Lote A"
      >
    </div>

    <div class="animal-form-group">
      <label for="sexo">Sexo</label>
      <select id="sexo" name="sexo" required>
        <option value="">Selecione</option>
        <option value="Macho">Macho</option>
        <option value="Fêmea">Fêmea</option>
      </select>
    </div>

    <div class="animal-form-group">
      <label for="peso_entrada">Peso de Entrada</label>
      <input
        type="number"
        step="0.01"
        id="peso_entrada"
        name="peso_entrada"
        placeholder="Ex: 420"
        required
      >
    </div>

    <div class="animal-form-group">
      <label for="data_nascimento">Data de Nascimento</label>
      <input
        type="date"
        id="data_nascimento"
        name="data_nascimento"
      >
    </div>

    <div class="animal-form-group animal-form-full">
      <label for="observacoes">Observações</label>
      <textarea
        id="observacoes"
        name="observacoes"
        rows="4"
        placeholder="Informações adicionais..."
      ></textarea>
    </div>

  </div>

</div>

      <div class="modal-footer">

        <button
          type="button"
          class="btn-cancelar"
          data-close-modal="modalCadastrarAnimal"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-salvar"
        >
          Salvar Animal
        </button>

      </div>

    </form>

  </div>

</div>