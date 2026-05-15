document.addEventListener('DOMContentLoaded', () => {
  const modalEditarFuncionario =
    document.getElementById('modalEditarFuncionario');

  const formEditarFuncionario =
    document.getElementById('formEditarFuncionario');

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
      document.getElementById('editarFuncionarioModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `funcionario-modal-message ${tipo}`;
    messageBox.textContent = mensagem;
  }

  function limparMensagemModal() {
    const messageBox =
      document.getElementById('editarFuncionarioModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'funcionario-modal-message';
    messageBox.textContent = '';
  }

  function preencherCampo(id, valor) {
    const campo = document.getElementById(id);

    if (!campo) {
      return;
    }

    campo.value = valor || '';
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

  const editarCpfInput = document.getElementById('editar_cpf');
  const editarTelefoneInput = document.getElementById('editar_telefone');

  if (editarCpfInput) {
    editarCpfInput.addEventListener('input', () => {
      aplicarMascaraCpf(editarCpfInput);
    });
  }

  if (editarTelefoneInput) {
    editarTelefoneInput.addEventListener('input', () => {
      aplicarMascaraTelefone(editarTelefoneInput);
    });
  }

  document.querySelectorAll('.editar-funcionario-btn').forEach((botao) => {
    botao.addEventListener('click', () => {
      limparMensagemModal();

      preencherCampo('editar_funcionario_id', botao.dataset.id);
      preencherCampo('editar_nome_completo', botao.dataset.nomeCompleto);
      preencherCampo('editar_nome_social', botao.dataset.nomeSocial);
      preencherCampo('editar_cpf', botao.dataset.cpf);
      preencherCampo('editar_telefone', botao.dataset.telefone);
      preencherCampo('editar_email', botao.dataset.email);
      preencherCampo('editar_papel_id', botao.dataset.papelId);
      preencherCampo('editar_status', botao.dataset.status || 'ativo');
      preencherCampo('editar_senha', '');
      preencherCampo('editar_senha_confirmacao', '');

      aplicarMascaraCpf(editarCpfInput);
      aplicarMascaraTelefone(editarTelefoneInput);

      abrirModal(modalEditarFuncionario);
    });
  });

  document
    .querySelectorAll('[data-close-modal="modalEditarFuncionario"]')
    .forEach((elemento) => {
      elemento.addEventListener('click', () => {
        fecharModal(modalEditarFuncionario);
      });
    });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalEditarFuncionario);
    }
  });

  if (formEditarFuncionario) {
    formEditarFuncionario.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemModal();

      if (typeof validarEdicaoFuncionario !== 'function') {
        mostrarMensagemModal(
          'error',
          'Não foi possível validar o formulário. Atualize a página e tente novamente.'
        );
        return;
      }

      const erroValidacao = validarEdicaoFuncionario();

      if (erroValidacao) {
        mostrarMensagemModal('error', erroValidacao);
        return;
      }

      const submitButton =
        formEditarFuncionario.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.textContent : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Salvando...';
      }

      try {
        const formData = new FormData(formEditarFuncionario);

        const response = await fetch(formEditarFuncionario.action, {
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
            data.mensagem || 'Erro ao atualizar funcionário.'
          );
          return;
        }

        mostrarMensagemModal(
          'success',
          data.mensagem || 'Funcionário atualizado com sucesso.'
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