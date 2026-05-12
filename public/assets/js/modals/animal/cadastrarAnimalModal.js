document.addEventListener('DOMContentLoaded', () => {
  const abrirModalCadastrarAnimal = document.getElementById('abrirModalCadastrarAnimal');
  const modalCadastrarAnimal = document.getElementById('modalCadastrarAnimal');
  const formCadastrarAnimal = document.getElementById('formCadastrarAnimal');

  function abrirModal(modal) {
    if (!modal) return;
    modal.classList.add('active');
  }

  function fecharModal(modal) {
    if (!modal) return;
    modal.classList.remove('active');
  }

  function mostrarMensagemModal(tipo, mensagem) {
    const messageBox = document.getElementById('animalModalMessage');

    if (!messageBox) return;

    messageBox.hidden = false;
    messageBox.className = `animal-modal-message ${tipo}`;
    messageBox.innerText = mensagem;
  }

  function limparMensagemModal() {
    const messageBox = document.getElementById('animalModalMessage');

    if (!messageBox) return;

    messageBox.hidden = true;
    messageBox.className = 'animal-modal-message';
    messageBox.innerText = '';
  }

  if (abrirModalCadastrarAnimal && modalCadastrarAnimal) {
    abrirModalCadastrarAnimal.addEventListener('click', () => {
      limparMensagemModal();

      if (formCadastrarAnimal) {
        formCadastrarAnimal.reset();
      }

      abrirModal(modalCadastrarAnimal);
    });
  }

  document.querySelectorAll('[data-close-modal="modalCadastrarAnimal"]').forEach((elemento) => {
    elemento.addEventListener('click', () => {
      fecharModal(modalCadastrarAnimal);
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalCadastrarAnimal);
    }
  });

  if (formCadastrarAnimal) {
    formCadastrarAnimal.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemModal();

      const erroValidacao = validarCadastroAnimal();

      if (erroValidacao) {
        mostrarMensagemModal('error', erroValidacao);
        return;
      }

      const submitButton = formCadastrarAnimal.querySelector('button[type="submit"]');
      const textoOriginalBotao = submitButton ? submitButton.innerText : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerText = 'Salvando...';
      }

      try {
        const formData = new FormData(formCadastrarAnimal);

        const response = await fetch(formCadastrarAnimal.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemModal('error', data.mensagem || 'Erro ao cadastrar animal.');
          return;
        }

        mostrarMensagemModal('success', data.mensagem || 'Animal cadastrado com sucesso.');

        setTimeout(() => {
          window.location.reload();
        }, 700);
      } catch (error) {
        mostrarMensagemModal('error', 'Erro de comunicação com o servidor. Tente novamente.');
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerText = textoOriginalBotao;
        }
      }
    });
  }
});