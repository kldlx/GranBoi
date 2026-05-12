document.addEventListener('DOMContentLoaded', () => {
  const animalSelect = document.getElementById('animal_id');
  const formPesagem = document.getElementById('formPesagem');
  const pesoInput = document.getElementById('peso');
  const messageBox = document.getElementById('pesoFormMessage');

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

  if (animalSelect) {
    animalSelect.addEventListener('change', () => {
      const animalId = animalSelect.value;

      if (animalId) {
        window.location.href = `?animal_id=${animalId}`;
      }
    });
  }

  if (formPesagem) {
    formPesagem.addEventListener('submit', (event) => {
      limparMensagem();

      const animalId = animalSelect?.value;
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

      if (Number(peso) <= 0) {
        event.preventDefault();
        mostrarMensagem('error', 'O peso deve ser maior que zero.');
        return;
      }
    });
  }
});