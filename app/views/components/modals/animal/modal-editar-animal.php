<div class="modal" id="modalEditarAnimal">

  <div class="modal-overlay" data-close-modal="modalEditarAnimal"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Editar Animal</h2>
        <p>Atualize os dados do animal selecionado</p>
      </div>

      <button type="button" class="close-modal" data-close-modal="modalEditarAnimal">
        ✕
      </button>

    </div>

    <form method="POST" action="<?= BASE_URL ?>/animal/atualizar" id="formEditarAnimal">

      <input type="hidden" id="editar_id" name="id">

      <div class="animal-modal-message" id="editarAnimalModalMessage" hidden></div>

      <div class="animal-status-warning" id="editarAnimalStatusWarning" hidden></div>

      <div class="modal-body animal-modal-body">

        <div class="animal-form-grid">

          <div class="animal-form-group">
            <label for="editar_brinco">Número do Brinco — não editável</label>

            <input type="text" id="editar_brinco" disabled>

            <input type="hidden" id="editar_brinco_hidden" name="brinco">
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

            <input type="text" id="editar_peso_entrada" disabled>

            <input type="hidden" id="editar_peso_entrada_hidden" name="peso_entrada">
          </div>

          <div class="animal-form-group">
            <label for="editar_data_nascimento">Data de Nascimento</label>

            <input type="date" id="editar_data_nascimento" name="data_nascimento">
          </div>

          <div class="animal-form-group">
            <label for="editar_status">Status</label>

            <select id="editar_status" name="status" required>
              <option value="Ativo">Ativo</option>
              <option value="Vendido">Vendido</option>
              <option value="Perda">Perda</option>
            </select>
          </div>

          <div class="animal-form-group">
            <label for="editar_chip">Chip</label>
            <input type="text" id="editar_chip" name="chip" placeholder="Código do chip, se houver">
          </div>

          <div class="animal-form-group">
            <label for="editar_data_compra">Data de Compra</label>
            <input type="date" id="editar_data_compra" name="data_compra">
          </div>

          <div class="animal-form-group">
            <label for="editar_valor_compra">Valor de Compra (R$) <span style="font-weight:400;color:#aaa">— opcional</span></label>
            <input type="text" id="editar_valor_compra" name="valor_compra" placeholder="Ex: 3.500,00">
          </div>

        </div>

        <div class="animal-venda-section" id="editarAnimalVendaSection" hidden>

          <div class="animal-venda-divider">
            <i class="ri-money-dollar-circle-line"></i>
            <span>Dados da Venda</span>
          </div>

          <div class="animal-form-grid">

            <div class="animal-form-group">
              <label for="editar_peso_saida">Peso de Saída (kg)</label>
              <input type="number" id="editar_peso_saida" name="peso_saida" placeholder="Ex: 480.500" min="0.001" step="0.001">
            </div>

            <div class="animal-form-group">
              <label for="editar_valor_venda">Valor de Venda (R$)</label>
              <input type="text" id="editar_valor_venda" name="valor_venda" placeholder="Ex: 3500,00">
            </div>

            <div class="animal-form-group">
              <label for="editar_data_venda">Data de Venda</label>
              <input type="date" id="editar_data_venda" name="data_venda">
            </div>

          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn-cancelar" data-close-modal="modalEditarAnimal">
          Cancelar
        </button>

        <button type="submit" class="btn-salvar">
          Salvar Alterações
        </button>

      </div>

    </form>

  </div>

</div>