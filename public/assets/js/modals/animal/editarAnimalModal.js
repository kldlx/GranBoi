document.addEventListener('DOMContentLoaded', () => {
  const modalEditarAnimal = document.getElementById('modalEditarAnimal');
  const formEditarAnimal = document.getElementById('formEditarAnimal');

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

  function mostrarMensagemEditarModal(tipo, mensagem) {
    const messageBox = document.getElementById('editarAnimalModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `animal-modal-message ${tipo}`;
    messageBox.innerText = mensagem;
  }

  function limparMensagemEditarModal() {
    const messageBox = document.getElementById('editarAnimalModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'animal-modal-message';
    messageBox.innerText = '';
  }

  function preencherCampo(id, valor) {
    const campo = document.getElementById(id);

    if (!campo) {
      return;
    }

    campo.value = valor || '';
  }

  function toggleVendaSection(status) {
    const section = document.getElementById('editarAnimalVendaSection');

    if (!section) {
      return;
    }

    section.hidden = status !== 'Vendido';

    if (status !== 'Vendido') {
      preencherCampo('editar_peso_saida', '');
      preencherCampo('editar_valor_venda', '');
      preencherCampo('editar_data_venda', '');
    }
  }

  document.querySelectorAll('.editar-animal-btn').forEach((button) => {
    button.addEventListener('click', () => {
      limparMensagemEditarModal();

      preencherCampo('editar_id', button.dataset.id);
      preencherCampo('editar_brinco', button.dataset.brinco);
      preencherCampo('editar_brinco_hidden', button.dataset.brinco);

      preencherCampo('editar_raca', button.dataset.racaId);
      preencherCampo('editar_lote', button.dataset.loteId);

      preencherCampo('editar_sexo', button.dataset.sexo);
      preencherCampo('editar_data_nascimento', button.dataset.dataNascimento);
      preencherCampo('editar_status', button.dataset.status || 'Ativo');
      preencherCampo('editar_chip', button.dataset.chip);

      preencherCampo('editar_data_compra', button.dataset.dataCompra || '');

      if (button.dataset.valorCompra) {
        const vcNum = parseFloat(button.dataset.valorCompra);
        document.getElementById('editar_valor_compra').value = isNaN(vcNum)
          ? ''
          : vcNum.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      } else {
        preencherCampo('editar_valor_compra', '');
      }

      const status = button.dataset.status || 'Ativo';
      const section = document.getElementById('editarAnimalVendaSection');

      if (section) {
        section.hidden = status !== 'Vendido';
      }

      preencherCampo('editar_peso_saida', status === 'Vendido' ? (button.dataset.pesoSaida || '') : '');

      if (status === 'Vendido' && button.dataset.valorVenda) {
        const valorNum = parseFloat(button.dataset.valorVenda);
        document.getElementById('editar_valor_venda').value = isNaN(valorNum)
          ? ''
          : valorNum.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      } else {
        preencherCampo('editar_valor_venda', '');
      }

      preencherCampo('editar_data_venda', status === 'Vendido' ? (button.dataset.dataVenda || '') : '');

      const pesoVisivel = document.getElementById('editar_peso_entrada');

      if (pesoVisivel) {
        pesoVisivel.value = button.dataset.peso ? `${button.dataset.peso} kg` : '';
      }

      preencherCampo('editar_peso_entrada_hidden', button.dataset.peso);

      abrirModal(modalEditarAnimal);
    });
  });

  const statusSelectEditar = document.getElementById('editar_status');

  if (statusSelectEditar) {
    statusSelectEditar.addEventListener('change', () => {
      toggleVendaSection(statusSelectEditar.value);
    });
  }

  document.querySelectorAll('[data-close-modal="modalEditarAnimal"]').forEach((elemento) => {
    elemento.addEventListener('click', () => {
      fecharModal(modalEditarAnimal);
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalEditarAnimal);
    }
  });

  if (formEditarAnimal) {
    formEditarAnimal.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemEditarModal();

      const erroValidacao = validarEdicaoAnimal();

      if (erroValidacao) {
        mostrarMensagemEditarModal('error', erroValidacao);
        return;
      }

      const submitButton = formEditarAnimal.querySelector('button[type="submit"]');
      const textoOriginalBotao = submitButton ? submitButton.innerText : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerText = 'Salvando...';
      }

      try {
        const formData = new FormData(formEditarAnimal);

        const response = await fetch(formEditarAnimal.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemEditarModal(
            'error',
            data.mensagem || 'Erro ao atualizar animal.'
          );
          return;
        }

        mostrarMensagemEditarModal(
          'success',
          data.mensagem || 'Animal atualizado com sucesso.'
        );

        setTimeout(() => {
          window.location.reload();
        }, 700);

      } catch (error) {
        mostrarMensagemEditarModal(
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