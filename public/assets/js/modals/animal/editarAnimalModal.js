document.addEventListener('DOMContentLoaded', () => {
  const modalEditarAnimal = document.getElementById('modalEditarAnimal');
  const formEditarAnimal = document.getElementById('formEditarAnimal');

  function abrirModal(modal) {
    if (!modal) return;
    modal.classList.add('active');
  }

  function fecharModal(modal) {
    if (!modal) return;
    modal.classList.remove('active');
  }

  function mostrarMensagemEditarModal(tipo, mensagem) {
    const messageBox = document.getElementById('editarAnimalModalMessage');

    if (!messageBox) return;

    messageBox.hidden = false;
    messageBox.className = `animal-modal-message ${tipo}`;
    messageBox.innerText = mensagem;
  }

  function limparMensagemEditarModal() {
    const messageBox = document.getElementById('editarAnimalModalMessage');

    if (!messageBox) return;

    messageBox.hidden = true;
    messageBox.className = 'animal-modal-message';
    messageBox.innerText = '';
  }

  document.querySelectorAll('.editar-animal-btn').forEach((button) => {
    button.addEventListener('click', () => {
      limparMensagemEditarModal();

      document.getElementById('editar_id').value = button.dataset.id || '';
      document.getElementById('editar_brinco').value = button.dataset.brinco || '';
      document.getElementById('editar_brinco_hidden').value = button.dataset.brinco || '';
      document.getElementById('editar_raca').value = button.dataset.raca || '';
      document.getElementById('editar_lote').value = button.dataset.lote || '';
      document.getElementById('editar_sexo').value = button.dataset.sexo || '';
      document.getElementById('editar_peso_entrada').value =
        button.dataset.peso ? `${button.dataset.peso} kg` : '';

    document.getElementById('editar_peso_entrada_hidden').value =
        button.dataset.peso || '';
      document.getElementById('editar_data_nascimento').value = button.dataset.dataNascimento || '';
      document.getElementById('editar_status').value = button.dataset.status || 'ativo';
      document.getElementById('editar_observacoes').value = button.dataset.observacoes || '';

      abrirModal(modalEditarAnimal);
    });
  });

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
          mostrarMensagemEditarModal('error', data.mensagem || 'Erro ao atualizar animal.');
          return;
        }

        mostrarMensagemEditarModal('success', data.mensagem || 'Animal atualizado com sucesso.');

        setTimeout(() => {
          window.location.reload();
        }, 700);
      } catch (error) {
        mostrarMensagemEditarModal('error', 'Erro de comunicação com o servidor. Tente novamente.');
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerText = textoOriginalBotao;
        }
      }
    });
  }
});