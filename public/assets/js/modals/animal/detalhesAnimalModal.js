document.addEventListener('DOMContentLoaded', () => {
  const modalDetalhesAnimal = document.getElementById('modalDetalhesAnimal');

  function abrirModal(modal) {
    if (!modal) {
      return;
    }

    modal.classList.add('active');
  }

  function fecharModal(modal) {
    if (!modal) {
      return;
    }

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

  function formatarSexo(sexo) {
    if (sexo === 'M') {
      return 'Macho';
    }

    if (sexo === 'F') {
      return 'Fêmea';
    }

    return sexo || '-';
  }

  function formatarStatus(status) {
    if (!status) {
      return '-';
    }

    if (status === 'ativo') {
      return 'Ativo';
    }

    if (status === 'vendido') {
      return 'Vendido';
    }

    if (status === 'morto') {
      return 'Abatido';
    }

    return status.charAt(0).toUpperCase() + status.slice(1);
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
      preencherTexto('detalhes_brinco', `#${button.dataset.brinco || '-'}`);
      preencherTexto('detalhes_raca', button.dataset.raca);
      preencherTexto('detalhes_lote', button.dataset.lote);
      preencherTexto('detalhes_sexo', formatarSexo(button.dataset.sexo));
      preencherTexto('detalhes_peso', button.dataset.peso ? `${button.dataset.peso} kg` : '-');
      preencherTexto('detalhes_status', formatarStatus(button.dataset.status));
      preencherTexto('detalhes_data_nascimento', formatarData(button.dataset.dataNascimento));
      preencherTexto('detalhes_chip', button.dataset.chip);

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