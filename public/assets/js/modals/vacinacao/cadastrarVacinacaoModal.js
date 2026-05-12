document.addEventListener('DOMContentLoaded', () => {
  const abrirModalCadastrarVacinacao =
    document.getElementById('abrirModalCadastrarVacinacao');

  const modalCadastrarVacinacao =
    document.getElementById('modalCadastrarVacinacao');

  const formCadastrarVacinacao =
    document.getElementById('formCadastrarVacinacao');

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

  function mostrarMensagemModal(tipo, mensagem) {
    const messageBox =
      document.getElementById('vacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `vacinacao-modal-message ${tipo}`;
    messageBox.innerText = mensagem;
  }

  function limparMensagemModal() {
    const messageBox =
      document.getElementById('vacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'vacinacao-modal-message';
    messageBox.innerText = '';
  }

  if (abrirModalCadastrarVacinacao && modalCadastrarVacinacao) {
    abrirModalCadastrarVacinacao.addEventListener('click', () => {
      limparMensagemModal();

      if (formCadastrarVacinacao) {
        formCadastrarVacinacao.reset();
      }

      abrirModal(modalCadastrarVacinacao);
    });
  }

  document.querySelectorAll('[data-close-modal="modalCadastrarVacinacao"]').forEach((elemento) => {
    elemento.addEventListener('click', () => {
      fecharModal(modalCadastrarVacinacao);
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalCadastrarVacinacao);
    }
  });

  if (formCadastrarVacinacao) {
    formCadastrarVacinacao.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemModal();

      const erroValidacao =
        validarCadastroVacinacao();

      if (erroValidacao) {
        mostrarMensagemModal('error', erroValidacao);
        return;
      }

      const submitButton =
        formCadastrarVacinacao.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.innerText : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerText = 'Salvando...';
      }

      try {
        const formData =
          new FormData(formCadastrarVacinacao);

        const response =
          await fetch(formCadastrarVacinacao.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

        const data =
          await response.json();

        if (!data.sucesso) {
          mostrarMensagemModal(
            'error',
            data.mensagem || 'Erro ao registrar vacinação.'
          );
          return;
        }

        mostrarMensagemModal(
          'success',
          data.mensagem || 'Vacinação registrada com sucesso.'
        );

        setTimeout(() => {
          window.location.reload();
        }, 700);

      } catch (error) {
        mostrarMensagemModal(
          'error',
          'Erro de comunicação com o servidor. Tente novamente.'
        );
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerText = textoOriginalBotao;
        }
      }
    });
  }
});