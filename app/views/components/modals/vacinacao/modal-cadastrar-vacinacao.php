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

      <input
        type="hidden"
        id="animal_id"
        name="animal_id"
      >

      <div
        class="vacinacao-modal-message"
        id="vacinacaoModalMessage"
        hidden
      ></div>

      <div class="modal-body vacinacao-modal-body">

        <div class="vacinacao-form-grid">

          <div class="vacinacao-form-group vacinacao-form-full">

            <label for="pesquisaAnimalVacinacao">Animal</label>

            <div class="vacinacao-animal-search-box">
              <i class="ri-search-line"></i>

              <input
                type="text"
                id="pesquisaAnimalVacinacao"
                placeholder="Pesquisar por brinco, raça ou status..."
                autocomplete="off"
              >
            </div>

            <div
              class="vacinacao-animal-selected"
              id="vacinacaoAnimalSelecionado"
              hidden
            >
              Nenhum animal selecionado.
            </div>

            <div
              class="vacinacao-animal-list"
              id="listaAnimaisVacinacao"
            >

              <?php if (!empty($animais)): ?>

                <?php foreach ($animais as $animal): ?>

                  <?php
                    $statusAnimal = strtolower(trim($animal['status'] ?? ''));

                    if ($statusAnimal === 'ativo') {
                        $statusAnimalTexto = 'Ativo';
                        $statusPesquisa = 'ativo';
                    } elseif ($statusAnimal === 'vendido') {
                        $statusAnimalTexto = 'Vendido';
                        $statusPesquisa = 'vendido';
                    } elseif ($statusAnimal === 'morto') {
                        $statusAnimalTexto = 'Perda';
                        $statusPesquisa = 'morto perda';
                    } else {
                        $statusAnimalTexto = '-';
                        $statusPesquisa = $statusAnimal;
                    }
                  ?>

                  <button
                    type="button"
                    class="vacinacao-animal-option"
                    data-id="<?= htmlspecialchars($animal['id']) ?>"
                    data-brinco="<?= htmlspecialchars($animal['brinco_identificador']) ?>"
                    data-raca="<?= htmlspecialchars($animal['raca'] ?? '') ?>"
                    data-status="<?= htmlspecialchars($statusAnimal) ?>"
                    data-status-texto="<?= htmlspecialchars($statusAnimalTexto) ?>"
                    data-search="<?= htmlspecialchars(strtolower(($animal['brinco_identificador'] ?? '') . ' ' . ($animal['raca'] ?? '') . ' ' . $statusPesquisa)) ?>"
                  >
                    <div>
                      <strong>#<?= htmlspecialchars($animal['brinco_identificador']) ?></strong>
                      <span>
                        <?= !empty($animal['raca']) ? htmlspecialchars($animal['raca']) : 'Raça não informada' ?>
                      </span>
                    </div>

                    <span class="vacinacao-animal-status vacinacao-animal-status-<?= htmlspecialchars($statusAnimal) ?>">
                      <?= htmlspecialchars($statusAnimalTexto) ?>
                    </span>
                  </button>

                <?php endforeach; ?>

                <div
                  class="vacinacao-animal-empty"
                  id="vacinacaoAnimalSearchEmpty"
                  style="display: none;"
                >
                  Nenhum animal encontrado.
                </div>

              <?php else: ?>

                <div class="vacinacao-animal-empty">
                  Nenhum animal disponível para vacinação.
                </div>

              <?php endif; ?>

            </div>

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
            <label for="quantidade">Quantidade/Dose</label>

            <input
              type="number"
              id="quantidade"
              name="quantidade"
              placeholder="Ex: 5"
              min="0.001"
              step="0.001"
              required
            >
          </div>

          <div class="vacinacao-form-group">
            <label for="preco_custo_sanitario">Custo da Vacina</label>

            <input
              type="number"
              id="preco_custo_sanitario"
              name="preco_custo_sanitario"
              placeholder="Ex: 25.00"
              min="0"
              step="0.01"
              required
            >
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