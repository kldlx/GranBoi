document.addEventListener('DOMContentLoaded', () => {
  const modalExcluirAnimal = document.getElementById('modalExcluirAnimal');
  const formExcluirAnimal = document.getElementById('formExcluirAnimal');

  function abrirModal(modal) {
    if (!modal) return;
    modal.classList.add('active');
  }

  function fecharModal(modal) {
    if (!modal) return;
    modal.classList.remove('active');
  }

  function mostrarMensagemExcluirModal(tipo, mensagem) {
    const messageBox = document.getElementById('excluirAnimalModalMessage');

    if (!messageBox) return;

    messageBox.hidden = false;
    messageBox.className = `animal-modal-message ${tipo}`;
    messageBox.innerText = mensagem;
  }

  function limparMensagemExcluirModal() {
    const messageBox = document.getElementById('excluirAnimalModalMessage');

    if (!messageBox) return;

    messageBox.hidden = true;
    messageBox.className = 'animal-modal-message';
    messageBox.innerText = '';
  }

  document.querySelectorAll('.excluir-animal-btn').forEach((button) => {
    button.addEventListener('click', () => {
      limparMensagemExcluirModal();

      const id = button.dataset.id || '';
      const brinco = button.dataset.brinco || '';

      document.getElementById('excluir_animal_id').value = id;
      document.getElementById('excluir_animal_brinco').innerText = `#${brinco}`;

      abrirModal(modalExcluirAnimal);
    });
  });

  document.querySelectorAll('[data-close-modal="modalExcluirAnimal"]').forEach((elemento) => {
    elemento.addEventListener('click', () => {
      fecharModal(modalExcluirAnimal);
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalExcluirAnimal);
    }
  });

  if (formExcluirAnimal) {
    formExcluirAnimal.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemExcluirModal();

      const submitButton = formExcluirAnimal.querySelector('button[type="submit"]');
      const textoOriginalBotao = submitButton ? submitButton.innerText : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerText = 'Excluindo...';
      }

      try {
        const formData = new FormData(formExcluirAnimal);

        const response = await fetch(formExcluirAnimal.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemExcluirModal('error', data.mensagem || 'Erro ao excluir animal.');
          return;
        }

        mostrarMensagemExcluirModal('success', data.mensagem || 'Animal excluído com sucesso.');

        setTimeout(() => {
          window.location.reload();
        }, 700);
      } catch (error) {
        mostrarMensagemExcluirModal('error', 'Erro de comunicação com o servidor. Tente novamente.');
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerText = textoOriginalBotao;
        }
      }
    });
  }
});