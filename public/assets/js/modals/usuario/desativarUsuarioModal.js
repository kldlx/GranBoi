document.addEventListener('DOMContentLoaded', () => {
  const modalDesativarFuncionario =
    document.getElementById('modalDesativarFuncionario');

  const formDesativarFuncionario =
    document.getElementById('formDesativarFuncionario');

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

  function preencherTexto(id, valor) {
    const elemento = document.getElementById(id);

    if (!elemento) {
      return;
    }

    elemento.textContent = valor || '-';
  }

  function preencherCampo(id, valor) {
    const campo = document.getElementById(id);

    if (!campo) {
      return;
    }

    campo.value = valor || '';
  }

  function mostrarMensagemModal(tipo, mensagem) {
    const messageBox =
      document.getElementById('desativarFuncionarioModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `funcionario-modal-message ${tipo}`;
    messageBox.textContent = mensagem;
  }

  function limparMensagemModal() {
    const messageBox =
      document.getElementById('desativarFuncionarioModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'funcionario-modal-message';
    messageBox.textContent = '';
  }

  document.querySelectorAll('.desativar-funcionario-btn').forEach((botao) => {
    botao.addEventListener('click', () => {
      limparMensagemModal();

      preencherCampo('desativar_funcionario_id', botao.dataset.id);
      preencherTexto('desativarFuncionarioNome', botao.dataset.nome);

      abrirModal(modalDesativarFuncionario);
    });
  });

  document
    .querySelectorAll('[data-close-modal="modalDesativarFuncionario"]')
    .forEach((elemento) => {
      elemento.addEventListener('click', () => {
        fecharModal(modalDesativarFuncionario);
      });
    });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalDesativarFuncionario);
    }
  });

  if (formDesativarFuncionario) {
    formDesativarFuncionario.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemModal();

      const id = document.getElementById('desativar_funcionario_id')?.value;

      if (!id) {
        mostrarMensagemModal('error', 'Funcionário não informado.');
        return;
      }

      const submitButton =
        formDesativarFuncionario.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.textContent : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Desativando...';
      }

      try {
        const formData = new FormData(formDesativarFuncionario);

        const response = await fetch(formDesativarFuncionario.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemModal(
            'error',
            data.mensagem || 'Erro ao desativar funcionário.'
          );
          return;
        }

        mostrarMensagemModal(
          'success',
          data.mensagem || 'Funcionário desativado com sucesso.'
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
          submitButton.textContent = textoOriginalBotao;
        }
      }
    });
  }
});