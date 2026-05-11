document.addEventListener('DOMContentLoaded', () => {

  const menuToggle =
  document.getElementById('menuToggle');

  const sidebar =
  document.getElementById('sidebar');

  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });

  document.addEventListener('click', (event) => {

    const isInsideSidebar =
    sidebar.contains(event.target);

    const isMenuButton =
    menuToggle.contains(event.target);

    if (
      window.innerWidth <= 992 &&
      !isInsideSidebar &&
      !isMenuButton
    ) {
      sidebar.classList.remove('active');
    }

  });

  const vaccineButton =
  document.querySelector('.new-vaccine-btn');

  const modalVacinacao =
  document.getElementById('modalVacinacao');

  const fecharModal =
  document.getElementById('fecharModalVacinacao');

  const cancelarModal =
  document.getElementById('cancelarModalVacinacao');

  const modalOverlay =
  modalVacinacao.querySelector('.modal-overlay');

  const modalTituloVacinacao =
  document.getElementById('modalTituloVacinacao');

  const modalDescricaoVacinacao =
  document.getElementById('modalDescricaoVacinacao');

  const btnSalvarVacinacao =
  document.getElementById('btnSalvarVacinacao');

  const formVacinacao =
  document.getElementById('formVacinacao');

  const inputAnimal =
  document.getElementById('animal');

  const inputVacina =
  document.getElementById('vacina');

  const inputDataAplicacao =
  document.getElementById('data_aplicacao');

  const inputProximaDose =
  document.getElementById('proxima_dose');

  const inputResponsavel =
  document.getElementById('responsavel');

  const inputLote =
  document.getElementById('lote');

  const inputQuantidade =
  document.getElementById('quantidade');

  const inputViaAplicacao =
  document.getElementById('via_aplicacao');

  const inputObservacoes =
  document.getElementById('observacoes');

  function limparFormularioVacinacao() {
    formVacinacao.reset();
  }

  function abrirModalCriacao() {

    limparFormularioVacinacao();

    modalTituloVacinacao.innerText =
    'Vacinação de Gado';

    modalDescricaoVacinacao.innerText =
    'Registre uma nova vacinação';

    btnSalvarVacinacao.innerText =
    'Salvar Vacinação';

    modalVacinacao.classList.add('active');

  }

  if (vaccineButton) {
    vaccineButton.addEventListener('click', abrirModalCriacao);
  }

  function fecharModalFunction() {
    modalVacinacao.classList.remove('active');
  }

  fecharModal.addEventListener('click', fecharModalFunction);
  cancelarModal.addEventListener('click', fecharModalFunction);
  modalOverlay.addEventListener('click', fecharModalFunction);

  const editButtons =
  document.querySelectorAll('.edit-btn');

  editButtons.forEach((button) => {

    button.addEventListener('click', () => {

      const row =
      button.closest('tr');

      modalTituloVacinacao.innerText =
      'Editar Vacinação';

      modalDescricaoVacinacao.innerText =
      'Atualize as informações da vacinação';

      btnSalvarVacinacao.innerText =
      'Salvar Alterações';

      inputAnimal.value =
      row.dataset.animal || '';

      inputVacina.value =
      row.dataset.vacina || '';

      inputDataAplicacao.value =
      row.dataset.dataAplicacao || '';

      inputProximaDose.value =
      row.dataset.proximaDose || '';

      inputResponsavel.value =
      row.dataset.responsavel || '';

      inputLote.value =
      row.dataset.lote || '';

      inputQuantidade.value =
      row.dataset.quantidade || '';

      inputViaAplicacao.value =
      row.dataset.viaAplicacao || '';

      inputObservacoes.value =
      row.dataset.observacoes || '';

      modalVacinacao.classList.add('active');

    });

  });

  const modalVisualizar =
  document.getElementById('modalVisualizarVacina');

  const fecharModalVisualizacao =
  document.getElementById('fecharModalVisualizacao');

  const fecharVisualizacaoFooter =
  document.getElementById('fecharVisualizacaoFooter');

  const overlayVisualizacao =
  modalVisualizar.querySelector('.modal-overlay');

  const visualizarAnimal =
  document.getElementById('visualizarAnimal');

  const visualizarVacina =
  document.getElementById('visualizarVacina');

  const visualizarData =
  document.getElementById('visualizarData');

  const visualizarStatus =
  document.getElementById('visualizarStatus');

  const viewButtons =
  document.querySelectorAll('.view-btn');

  viewButtons.forEach((button) => {

    button.addEventListener('click', () => {

      const row =
      button.closest('tr');

      visualizarAnimal.value =
      row.dataset.animal || '';

      visualizarVacina.value =
      row.dataset.vacina || '';

      visualizarData.value =
      row.children[2].innerText || '';

      visualizarStatus.value =
      row.dataset.status || '';

      modalVisualizar.classList.add('active');

    });

  });

  function fecharModalVisualizacaoFunction() {
    modalVisualizar.classList.remove('active');
  }

  fecharModalVisualizacao.addEventListener('click', fecharModalVisualizacaoFunction);
  fecharVisualizacaoFooter.addEventListener('click', fecharModalVisualizacaoFunction);
  overlayVisualizacao.addEventListener('click', fecharModalVisualizacaoFunction);

  const modalExcluir =
  document.getElementById('modalExcluirVacina');

  const fecharModalExcluir =
  document.getElementById('fecharModalExcluir');

  const cancelarExcluir =
  document.getElementById('cancelarExcluir');

  const confirmarExcluir =
  document.getElementById('confirmarExcluir');

  const overlayExcluir =
  modalExcluir.querySelector('.modal-overlay');

  const animalExcluir =
  document.getElementById('animalExcluir');

  const deleteButtons =
  document.querySelectorAll('.delete-btn');

  let linhaSelecionadaExcluir = null;

  deleteButtons.forEach((button) => {

    button.addEventListener('click', () => {

      const row =
      button.closest('tr');

      linhaSelecionadaExcluir = row;

      const animal =
      row.children[0].innerText;

      animalExcluir.innerText =
      animal;

      modalExcluir.classList.add('active');

    });

  });

  function fecharModalExcluirFunction() {
    modalExcluir.classList.remove('active');
  }

  fecharModalExcluir.addEventListener('click', fecharModalExcluirFunction);
  cancelarExcluir.addEventListener('click', fecharModalExcluirFunction);
  overlayExcluir.addEventListener('click', fecharModalExcluirFunction);

  confirmarExcluir.addEventListener('click', () => {

    if (linhaSelecionadaExcluir) {
      linhaSelecionadaExcluir.remove();
      linhaSelecionadaExcluir = null;
    }

    fecharModalExcluirFunction();

  });

  document.addEventListener('keydown', (event) => {

    if (event.key === 'Escape') {
      fecharModalFunction();
      fecharModalVisualizacaoFunction();
      fecharModalExcluirFunction();
    }

  });

});