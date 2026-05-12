document.addEventListener('DOMContentLoaded', () => {
  const modalDetalhesAnimal = document.getElementById('modalDetalhesAnimal');

  function abrirModal(modal) {
    if (!modal) return;
    modal.classList.add('active');
  }

  function fecharModal(modal) {
    if (!modal) return;
    modal.classList.remove('active');
  }

  function formatarData(data) {
    if (!data) {
      return '-';
    }

    const partes = data.split('-');

    if (partes.length !== 3) {
      return data;
    }

    return `${partes[2]}/${partes[1]}/${partes[0]}`;
  }

  function preencherTexto(id, valor) {
    const elemento = document.getElementById(id);

    if (!elemento) {
      return;
    }

    elemento.innerText = valor || '-';
  }

  document.querySelectorAll('.detalhes-animal-btn').forEach((button) => {
    button.addEventListener('click', () => {
      preencherTexto('detalhes_id', button.dataset.id);
      preencherTexto('detalhes_brinco', `#${button.dataset.brinco || '-'}`);
      preencherTexto('detalhes_raca', button.dataset.raca);
      preencherTexto('detalhes_lote', button.dataset.lote);
      preencherTexto('detalhes_sexo', button.dataset.sexo);
      preencherTexto('detalhes_peso', button.dataset.peso ? `${button.dataset.peso} kg` : '-');
      preencherTexto('detalhes_status', button.dataset.status);
      preencherTexto('detalhes_data_nascimento', formatarData(button.dataset.dataNascimento));
      preencherTexto('detalhes_observacoes', button.dataset.observacoes);

      abrirModal(modalDetalhesAnimal);
    });
  });

  document.querySelectorAll('[data-close-modal="modalDetalhesAnimal"]').forEach((elemento) => {
    elemento.addEventListener('click', () => {
      fecharModal(modalDetalhesAnimal);
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalDetalhesAnimal);
    }
  });
});