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
            <select id="raca" name="raca" required>
              <option value="">Selecione uma raça</option>

              <?php if (!empty($racas)): ?>
                <?php foreach ($racas as $raca): ?>
                  <option value="<?= htmlspecialchars($raca['id']) ?>">
                    <?= htmlspecialchars($raca['nome_raca']) ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>

            </select>
          </div>

          <div class="animal-form-group">
            <label for="lote">Lote</label>
            <select id="lote" name="lote" required>
              <option value="">Selecione um lote</option>

              <?php if (!empty($lotes)): ?>
                <?php foreach ($lotes as $lote): ?>
                  <option value="<?= htmlspecialchars($lote['id']) ?>">
                    <?= htmlspecialchars($lote['nome_lote']) ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>

            </select>
          </div>

          <div class="animal-form-group">
            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo" required>
              <option value="">Selecione</option>
              <option value="M">Macho</option>
              <option value="F">Fêmea</option>
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

          <div class="animal-form-group">
            <label for="chip">Chip</label>
            <input
              type="text"
              id="chip"
              name="chip"
              placeholder="Código do chip, se houver"
            >
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