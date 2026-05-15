<div class="modal" id="modalVisualizarVacinacao">

  <div
    class="modal-overlay"
    data-close-modal="modalVisualizarVacinacao"
  ></div>

  <div class="modal-container modal-sm">

    <div class="modal-header">

      <div>
        <h2>Detalhes da Vacinação</h2>
        <p>Informações do registro sanitário</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalVisualizarVacinacao"
      >
        ✕
      </button>

    </div>

    <div class="modal-body">

      <div class="detalhes-grid">

        <div class="detalhe-item">
          <strong>Animal</strong>
          <span id="detalheVacinacaoAnimal"></span>
        </div>

        <div class="detalhe-item">
          <strong>Vacina</strong>
          <span id="detalheVacinacaoVacina"></span>
        </div>

        <div class="detalhe-item">
          <strong>Dose</strong>
          <span id="detalheVacinacaoDose"></span>
        </div>

        <div class="detalhe-item">
          <strong>Aplicação</strong>
          <span id="detalheVacinacaoAplicacao"></span>
        </div>

        <div class="detalhe-item">
          <strong>Próxima Dose</strong>
          <span id="detalheVacinacaoProximaDose"></span>
        </div>

        <div class="detalhe-item">
          <strong>Responsável</strong>
          <span id="detalheVacinacaoResponsavel"></span>
        </div>

        <div class="detalhe-item">
          <strong>Status</strong>
          <span id="detalheVacinacaoStatus"></span>
        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button
        type="button"
        class="btn-cancelar"
        data-close-modal="modalVisualizarVacinacao"
      >
        Fechar
      </button>

    </div>

  </div>

</div>