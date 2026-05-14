document.addEventListener('DOMContentLoaded', () => {
  const animalIdInput = document.getElementById('animal_id');
  const formPesagem = document.getElementById('formPesagem');
  const pesoInput = document.getElementById('peso');
  const messageBox = document.getElementById('pesoFormMessage');

  const inputPesquisaAnimal = document.getElementById('pesquisaAnimalPeso');
  const listaAnimaisPeso = document.getElementById('listaAnimaisPeso');
  const animaisPeso = document.querySelectorAll('.peso-animal-option');
  const animalSearchEmpty = document.getElementById('pesoAnimalSearchEmpty');

  function mostrarMensagem(tipo, mensagem) {
    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `peso-form-message ${tipo}`;
    messageBox.innerText = mensagem;
  }

  function limparMensagem() {
    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'peso-form-message';
    messageBox.innerText = '';
  }

  function esconderListaAnimais() {
    if (listaAnimaisPeso) {
      listaAnimaisPeso.style.display = 'none';
    }

    animaisPeso.forEach((animal) => {
      animal.style.display = 'none';
    });

    if (animalSearchEmpty) {
      animalSearchEmpty.style.display = 'none';
    }
  }

  function mostrarListaAnimais() {
    if (listaAnimaisPeso) {
      listaAnimaisPeso.style.display = 'flex';
    }
  }

  function filtrarAnimaisPeso() {
    const termo = inputPesquisaAnimal
      ? inputPesquisaAnimal.value.trim().toLowerCase()
      : '';

    if (!termo) {
      esconderListaAnimais();
      return;
    }

    mostrarListaAnimais();

    let totalVisivel = 0;

    animaisPeso.forEach((animal) => {
      const texto = animal.dataset.search || '';

      if (texto.includes(termo)) {
        animal.style.display = '';
        totalVisivel++;
      } else {
        animal.style.display = 'none';
      }
    });

    if (animalSearchEmpty) {
      animalSearchEmpty.style.display = totalVisivel === 0 ? '' : 'none';
    }
  }

  esconderListaAnimais();

  if (inputPesquisaAnimal) {
    inputPesquisaAnimal.addEventListener('input', filtrarAnimaisPeso);
  }

  if (formPesagem) {
    formPesagem.addEventListener('submit', (event) => {
      limparMensagem();

      const animalId = animalIdInput?.value;
      const peso = pesoInput?.value;

      if (!animalId) {
        event.preventDefault();
        mostrarMensagem('error', 'Selecione um animal antes de registrar a pesagem.');
        return;
      }

      if (!peso) {
        event.preventDefault();
        mostrarMensagem('error', 'Informe o novo peso do animal.');
        return;
      }

      if (isNaN(peso) || Number(peso) <= 0) {
        event.preventDefault();
        mostrarMensagem('error', 'O peso deve ser maior que zero.');
      }
    });
  }
});