<div class="modal" id="modalVacinacao">

  <div class="modal-overlay"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>

        <h2 id="modalTituloVacinacao">
          Vacinação de Gado
        </h2>

        <p id="modalDescricaoVacinacao">
          Registre uma nova vacinação
        </p>

      </div>

      <button
        class="close-modal"
        id="fecharModalVacinacao"
      >
        ✕
      </button>

    </div>

    <div class="modal-body">

      <form id="formVacinacao" method="POST">

        <div class="form-row">

          <div class="form-group">

            <label for="animal">
              Animal
            </label>

            <input
              type="text"
              id="animal"
              name="animal"
              placeholder="Ex: #145 Nelore"
            >

          </div>

          <div class="form-group">

            <label for="vacina">
              Vacina
            </label>

            <select
              id="vacina"
              name="vacina"
            >
              <option value="">
                Selecione
              </option>

              <option value="aftosa">
                Febre Aftosa
              </option>

              <option value="brucelose">
                Brucelose
              </option>

              <option value="raiva">
                Raiva
              </option>

              <option value="clostridiose">
                Clostridiose
              </option>

            </select>

          </div>

        </div>

        <div class="form-row">

          <div class="form-group">

            <label for="data_aplicacao">
              Data da Aplicação
            </label>

            <input
              type="date"
              id="data_aplicacao"
              name="data_aplicacao"
            >

          </div>

          <div class="form-group">

            <label for="proxima_dose">
              Próxima Dose
            </label>

            <input
              type="date"
              id="proxima_dose"
              name="proxima_dose"
            >

          </div>

        </div>

        <div class="form-row">

          <div class="form-group">

            <label for="responsavel">
              Responsável
            </label>

            <input
              type="text"
              id="responsavel"
              name="responsavel"
              placeholder="Nome do responsável"
            >

          </div>

          <div class="form-group">

            <label for="lote">
              Lote da Vacina
            </label>

            <input
              type="text"
              id="lote"
              name="lote"
              placeholder="Ex: AXT-9921"
            >

          </div>

        </div>

        <div class="form-row">

          <div class="form-group">

            <label for="quantidade">
              Quantidade Aplicada
            </label>

            <input
              type="text"
              id="quantidade"
              name="quantidade"
              placeholder="Ex: 5ml"
            >

          </div>

          <div class="form-group">

            <label for="via_aplicacao">
              Via de Aplicação
            </label>

            <select
              id="via_aplicacao"
              name="via_aplicacao"
            >

              <option value="">
                Selecione
              </option>

              <option value="subcutanea">
                Subcutânea
              </option>

              <option value="intramuscular">
                Intramuscular
              </option>

              <option value="oral">
                Oral
              </option>

            </select>

          </div>

        </div>

        <div class="form-group">

          <label for="observacoes">
            Observações
          </label>

          <textarea
            id="observacoes"
            name="observacoes"
            rows="5"
            placeholder="Digite observações importantes..."
          ></textarea>

        </div>

      </form>

    </div>

    <div class="modal-footer">

      <button
        type="button"
        class="btn-cancelar"
        id="cancelarModalVacinacao"
      >
        Cancelar
      </button>

      <button
        type="submit"
        form="formVacinacao"
        class="btn-salvar"
        id="btnSalvarVacinacao"
      >
        Salvar Vacinação
      </button>

    </div>

  </div>

</div>

<div class="modal" id="modalVisualizarVacina">

  <div class="modal-overlay"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>

        <h2>
          Detalhes da Vacinação
        </h2>

        <p>
          Informações completas da vacinação
        </p>

      </div>

      <button
        class="close-modal"
        id="fecharModalVisualizacao"
      >
        ✕
      </button>

    </div>

    <div class="modal-body">

      <div class="form-row">

        <div class="form-group">

          <label>
            Animal
          </label>

          <input
            type="text"
            id="visualizarAnimal"
            disabled
          >

        </div>

        <div class="form-group">

          <label>
            Vacina
          </label>

          <input
            type="text"
            id="visualizarVacina"
            disabled
          >

        </div>

      </div>

      <div class="form-row">

        <div class="form-group">

          <label>
            Data
          </label>

          <input
            type="text"
            id="visualizarData"
            disabled
          >

        </div>

        <div class="form-group">

          <label>
            Status
          </label>

          <input
            type="text"
            id="visualizarStatus"
            disabled
          >

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button
        type="button"
        class="btn-cancelar"
        id="fecharVisualizacaoFooter"
      >
        Fechar
      </button>

    </div>

  </div>

</div>

<div class="modal" id="modalExcluirVacina">

  <div class="modal-overlay"></div>

  <div class="modal-container modal-sm">

    <div class="modal-header">

      <div>

        <h2>
          Excluir Vacinação
        </h2>

        <p>
          Confirme a exclusão do registro
        </p>

      </div>

      <button
        class="close-modal"
        id="fecharModalExcluir"
      >
        ✕
      </button>

    </div>

    <div class="modal-body">

      <p class="delete-message">

        Tem certeza que deseja excluir a vacinação do animal
        <strong id="animalExcluir"></strong>?

      </p>

    </div>

    <div class="modal-footer">

      <button
        type="button"
        class="btn-cancelar"
        id="cancelarExcluir"
      >
        Cancelar
      </button>

      <button
        type="button"
        class="btn-excluir"
        id="confirmarExcluir"
      >
        Excluir
      </button>

    </div>

  </div>

</div>