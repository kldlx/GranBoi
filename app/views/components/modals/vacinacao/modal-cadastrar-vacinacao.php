<div class="modal" id="modalCadastrarVacinacao">

  <div class="modal-overlay" data-close-modal="modalCadastrarVacinacao"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Registrar Vacinação</h2>
        <p>Preencha os dados da vacinação aplicada</p>
      </div>

      <button type="button" class="close-modal" data-close-modal="modalCadastrarVacinacao">
        ✕
      </button>

    </div>

    <form method="POST" action="<?= BASE_URL ?>/vacinas/salvar" id="formCadastrarVacinacao">

      <div class="vacinacao-modal-message" id="vacinacaoModalMessage" hidden></div>

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

            <input type="text" id="vacina" name="vacina" placeholder="Ex: Febre Aftosa" required>
          </div>

          <div class="vacinacao-form-group">
            <label for="data_aplicacao">Data de Aplicação</label>

            <input type="date" id="data_aplicacao" name="data_aplicacao" required>
          </div>

          <div class="vacinacao-form-group">
            <label for="proxima_dose">Próxima Dose</label>

            <input type="date" id="proxima_dose" name="proxima_dose">
          </div>

          <div class="vacinacao-form-group vacinacao-form-full">
            <label for="quantidade">Quantidade/Dose</label>

            <input type="number" id="quantidade" name="quantidade" placeholder="Ex: 5" min="0.001" step="0.001"
              required>
          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn-cancelar" data-close-modal="modalCadastrarVacinacao">
          Cancelar
        </button>

        <button type="submit" class="btn-salvar">
          Salvar Vacinação
        </button>

      </div>

    </form>

  </div>

</div>