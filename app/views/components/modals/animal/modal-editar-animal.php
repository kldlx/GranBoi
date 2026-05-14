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

            <select id="editar_raca" name="raca">
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
            <label for="editar_lote">Lote</label>

            <select id="editar_lote" name="lote">
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
            <label for="editar_sexo">Sexo</label>

            <select id="editar_sexo" name="sexo" required>
              <option value="">Selecione</option>
              <option value="M">Macho</option>
              <option value="F">Fêmea</option>
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

          <div class="animal-form-group">
            <label for="editar_chip">Chip</label>

            <input
              type="text"
              id="editar_chip"
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