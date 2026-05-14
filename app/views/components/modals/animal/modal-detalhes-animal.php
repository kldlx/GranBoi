<div class="modal" id="modalDetalhesAnimal">

  <div class="modal-overlay" data-close-modal="modalDetalhesAnimal"></div>

  <div class="modal-container">

    <div class="modal-header">

      <div>
        <h2>Detalhes do Animal</h2>
        <p>Informações completas do animal selecionado</p>
      </div>

      <button
        type="button"
        class="close-modal"
        data-close-modal="modalDetalhesAnimal"
      >
        ✕
      </button>

    </div>

    <div class="modal-body animal-modal-body">

      <div
        class="animal-modal-message"
        id="detalhesAnimalModalMessage"
        hidden
      ></div>

      <div class="animal-details-grid">

        <div class="animal-detail-item">
          <span>Brinco</span>
          <strong id="detalhes_brinco">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Raça</span>
          <strong id="detalhes_raca">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Lote</span>
          <strong id="detalhes_lote">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Sexo</span>
          <strong id="detalhes_sexo">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Peso Atual</span>
          <strong id="detalhes_peso">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Status</span>
          <strong id="detalhes_status">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Data de Nascimento</span>
          <strong id="detalhes_data_nascimento">-</strong>
        </div>

        <div class="animal-detail-item">
          <span>Chip</span>
          <strong id="detalhes_chip">-</strong>
        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button
        type="button"
        class="btn-cancelar"
        data-close-modal="modalDetalhesAnimal"
      >
        Fechar
      </button>

    </div>

  </div>

</div>