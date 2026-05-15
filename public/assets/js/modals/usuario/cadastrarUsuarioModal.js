document.addEventListener('DOMContentLoaded', () => {
  const abrirModalCadastrarFuncionario =
    document.getElementById('abrirModalCadastrarFuncionario');

  const modalCadastrarFuncionario =
    document.getElementById('modalCadastrarFuncionario');

  const formCadastrarFuncionario =
    document.getElementById('formCadastrarFuncionario');

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
      document.getElementById('cadastrarFuncionarioModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `funcionario-modal-message ${tipo}`;
    messageBox.textContent = mensagem;
  }

  function limparMensagemModal() {
    const messageBox =
      document.getElementById('cadastrarFuncionarioModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'funcionario-modal-message';
    messageBox.textContent = '';
  }

  function aplicarMascaraCpf(input) {
    if (!input) {
      return;
    }

    let valor = input.value.replace(/\D/g, '');

    valor = valor.slice(0, 11);

    valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
    valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
    valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

    input.value = valor;
  }

  function aplicarMascaraTelefone(input) {
    if (!input) {
      return;
    }

    let valor = input.value.replace(/\D/g, '');

    valor = valor.slice(0, 11);

    if (valor.length <= 10) {
      valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
      valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
    } else {
      valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
      valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
    }

    input.value = valor;
  }

  const cpfInput = document.getElementById('cpf');
  const telefoneInput = document.getElementById('telefone');

  if (cpfInput) {
    cpfInput.addEventListener('input', () => {
      aplicarMascaraCpf(cpfInput);
    });
  }

  if (telefoneInput) {
    telefoneInput.addEventListener('input', () => {
      aplicarMascaraTelefone(telefoneInput);
    });
  }

  if (abrirModalCadastrarFuncionario && modalCadastrarFuncionario) {
    abrirModalCadastrarFuncionario.addEventListener('click', () => {
      limparMensagemModal();

      if (formCadastrarFuncionario) {
        formCadastrarFuncionario.reset();
      }

      abrirModal(modalCadastrarFuncionario);
    });
  }

  document
    .querySelectorAll('[data-close-modal="modalCadastrarFuncionario"]')
    .forEach((elemento) => {
      elemento.addEventListener('click', () => {
        fecharModal(modalCadastrarFuncionario);
      });
    });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalCadastrarFuncionario);
    }
  });

  if (formCadastrarFuncionario) {
    formCadastrarFuncionario.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemModal();

      if (typeof validarCadastroFuncionario !== 'function') {
        mostrarMensagemModal(
          'error',
          'Não foi possível validar o formulário. Atualize a página e tente novamente.'
        );
        return;
      }

      const erroValidacao = validarCadastroFuncionario();

      if (erroValidacao) {
        mostrarMensagemModal('error', erroValidacao);
        return;
      }

      const submitButton =
        formCadastrarFuncionario.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.textContent : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Salvando...';
      }

      try {
        const formData = new FormData(formCadastrarFuncionario);

        const response = await fetch(formCadastrarFuncionario.action, {
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
            data.mensagem || 'Erro ao cadastrar funcionário.'
          );
          return;
        }

        mostrarMensagemModal(
          'success',
          data.mensagem || 'Funcionário cadastrado com sucesso.'
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