<div class="modal" id="modalCadastrarVacinacao">

  <div class="modal-overlay" data-close-modal="modalCadastrarVacinacao"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Registrar Vacinação</h2>
        <p>Preencha os dados da vacinação aplicada</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalCadastrarVacinacao"
      >
        ✕
      </button>

    </div>

    <form
      method="POST"
      action="<?= BASE_URL ?>/vacinas/salvar"
      id="formCadastrarVacinacao"
    >

      <div
        class="vacinacao-modal-message"
        id="vacinacaoModalMessage"
        hidden
      ></div>

      <div class="modal-body vacinacao-modal-body">

        <div class="vacinacao-form-grid">

          <div class="vacinacao-form-group">
            <label for="animal_id">Animal</label>

            <select id="animal_id" name="animal_id" required>
              <option value="">Selecione um animal</option>

              <?php if (!empty($animais)): ?>

                <?php foreach ($animais as $animal): ?>

                  <option value="<?= htmlspecialchars($animal['id']) ?>">
                    #<?= htmlspecialchars($animal['brinco_identificador']) ?>
                    <?= !empty($animal['raca']) ? ' - ' . htmlspecialchars($animal['raca']) : '' ?>
                  </option>

                <?php endforeach; ?>

              <?php else: ?>

                <option value="" disabled>
                  Nenhum animal disponível para vacinação
                </option>

              <?php endif; ?>

            </select>
          </div>

          <div class="vacinacao-form-group">
            <label for="vacina">Vacina</label>
            <input
              type="text"
              id="vacina"
              name="vacina"
              placeholder="Ex: Febre Aftosa"
              required
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="data_aplicacao">Data de Aplicação</label>
            <input
              type="date"
              id="data_aplicacao"
              name="data_aplicacao"
              required
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="proxima_dose">Próxima Dose</label>
            <input
              type="date"
              id="proxima_dose"
              name="proxima_dose"
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="responsavel">Responsável</label>
            <input
              type="text"
              id="responsavel"
              name="responsavel"
              placeholder="Ex: Dr. João"
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="lote_vacina">Lote da Vacina</label>
            <input
              type="text"
              id="lote_vacina"
              name="lote_vacina"
              placeholder="Ex: LOTE-2026"
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="quantidade">Quantidade/Dose</label>
            <input
              type="text"
              id="quantidade"
              name="quantidade"
              placeholder="Ex: 5"
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="via_aplicacao">Via de Aplicação</label>
            <select id="via_aplicacao" name="via_aplicacao">
              <option value="">Selecione</option>
              <option value="subcutanea">Subcutânea</option>
              <option value="intramuscular">Intramuscular</option>
              <option value="oral">Oral</option>
            </select>
          </div>

          <div class="vacinacao-form-group vacinacao-form-full">
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
          data-close-modal="modalCadastrarVacinacao"
        >
          Cancelar
        </button>

        <button
          type="submit"
          class="btn-salvar"
        >
          Salvar Vacinação
        </button>

      </div>

    </form>

  </div>

</div>