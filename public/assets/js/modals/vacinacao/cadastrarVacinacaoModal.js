document.addEventListener('DOMContentLoaded', () => {
  const abrirModalCadastrarVacinacao =
    document.getElementById('abrirModalCadastrarVacinacao');

  const modalCadastrarVacinacao =
    document.getElementById('modalCadastrarVacinacao');

  const formCadastrarVacinacao =
    document.getElementById('formCadastrarVacinacao');

  const inputPesquisaAnimal =
    document.getElementById('pesquisaAnimalVacinacao');

  const listaAnimaisVacinacao =
    document.getElementById('listaAnimaisVacinacao');

  const animaisVacinacao =
    document.querySelectorAll('.vacinacao-animal-option');

  const animalSearchEmpty =
    document.getElementById('vacinacaoAnimalSearchEmpty');

  const animalIdInput =
    document.getElementById('animal_id');

  const animalSelecionadoBox =
    document.getElementById('vacinacaoAnimalSelecionado');

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
    messageBox.textContent = mensagem;
  }

  function limparMensagemModal() {
    const messageBox =
      document.getElementById('vacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'vacinacao-modal-message';
    messageBox.textContent = '';
  }

  function preencherCampo(id, valor) {
    const campo = document.getElementById(id);

    if (!campo) {
      return;
    }

    campo.value = valor || '';
  }

  function esconderListaAnimais() {
    if (listaAnimaisVacinacao) {
      listaAnimaisVacinacao.style.display = 'none';
    }

    animaisVacinacao.forEach((animal) => {
      animal.style.display = 'none';
    });

    if (animalSearchEmpty) {
      animalSearchEmpty.style.display = 'none';
    }
  }

  function mostrarListaAnimais() {
    if (listaAnimaisVacinacao) {
      listaAnimaisVacinacao.style.display = 'flex';
    }
  }

  function limparSelecaoAnimal() {
    if (animalIdInput) {
      animalIdInput.value = '';
    }

    if (inputPesquisaAnimal) {
      inputPesquisaAnimal.value = '';
    }

    if (animalSelecionadoBox) {
      animalSelecionadoBox.hidden = true;
      animalSelecionadoBox.textContent = 'Nenhum animal selecionado.';
      animalSelecionadoBox.className = 'vacinacao-animal-selected';
    }

    animaisVacinacao.forEach((animal) => {
      animal.classList.remove('active');
    });

    esconderListaAnimais();
  }

  function resetarFormularioCadastro() {
    limparMensagemModal();

    if (formCadastrarVacinacao) {
      formCadastrarVacinacao.reset();
    }

    limparSelecaoAnimal();
  }

  function filtrarAnimaisVacinacao() {
    const termo = inputPesquisaAnimal
      ? inputPesquisaAnimal.value.trim().toLowerCase()
      : '';

    if (!termo) {
      esconderListaAnimais();
      return;
    }

    mostrarListaAnimais();

    let totalVisivel = 0;

    animaisVacinacao.forEach((animal) => {
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

  function marcarAnimalSelecionado(botao) {
    const brinco = botao.dataset.brinco || '-';
    const raca = botao.dataset.raca || 'Raça não informada';
    const statusTexto = botao.dataset.statusTexto || '-';

    if (animalIdInput) {
      animalIdInput.value = botao.dataset.id || '';
    }

    animaisVacinacao.forEach((animal) => {
      animal.classList.remove('active');
    });

    botao.classList.add('active');

    if (animalSelecionadoBox) {
      animalSelecionadoBox.hidden = false;
      animalSelecionadoBox.className = 'vacinacao-animal-selected active';
      animalSelecionadoBox.textContent = `Animal selecionado: #${brinco} - ${raca} (${statusTexto})`;
    }

    if (inputPesquisaAnimal) {
      inputPesquisaAnimal.value = `#${brinco} - ${raca}`;
    }

    esconderListaAnimais();
  }

  function selecionarAnimal(botao) {
    limparMensagemModal();

    const status = botao.dataset.status || '';
    const statusTexto = botao.dataset.statusTexto || status;

    if (status !== 'ativo') {
      if (animalIdInput) {
        animalIdInput.value = '';
      }

      if (animalSelecionadoBox) {
        animalSelecionadoBox.hidden = true;
        animalSelecionadoBox.textContent = 'Nenhum animal selecionado.';
        animalSelecionadoBox.className = 'vacinacao-animal-selected';
      }

      animaisVacinacao.forEach((animal) => {
        animal.classList.remove('active');
      });

      mostrarMensagemModal(
        'error',
        `Não é possível registrar vacinação para animal ${statusTexto.toLowerCase()}.`
      );

      return;
    }

    marcarAnimalSelecionado(botao);
  }

  function selecionarAnimalPorId(animalId) {
    const animalEncontrado = Array.from(animaisVacinacao).find((animal) => {
      return animal.dataset.id === String(animalId);
    });

    if (!animalEncontrado) {
      if (animalIdInput) {
        animalIdInput.value = animalId || '';
      }

      if (animalSelecionadoBox) {
        animalSelecionadoBox.hidden = false;
        animalSelecionadoBox.className = 'vacinacao-animal-selected active';
        animalSelecionadoBox.textContent = 'Animal selecionado.';
      }

      return true;
    }

    if ((animalEncontrado.dataset.status || '') !== 'ativo') {
      mostrarMensagemModal(
        'error',
        `Não é possível registrar vacinação para animal ${(animalEncontrado.dataset.statusTexto || '').toLowerCase()}.`
      );

      return false;
    }

    marcarAnimalSelecionado(animalEncontrado);

    return true;
  }

  function aplicarProximaDose(botao) {
    resetarFormularioCadastro();

    const animalSelecionado = selecionarAnimalPorId(botao.dataset.animalId);

    if (!animalSelecionado) {
      abrirModal(modalCadastrarVacinacao);
      return;
    }

    preencherCampo('vacina', botao.dataset.vacina);
    preencherCampo('data_aplicacao', obterDataAtualSistema());
    preencherCampo('quantidade', '');
    preencherCampo('proxima_dose', '');

    mostrarMensagemModal(
      'success',
      'Próxima dose preparada. Informe a dose aplicada e salve o registro.'
    );

    abrirModal(modalCadastrarVacinacao);
  }

  esconderListaAnimais();

  if (inputPesquisaAnimal) {
    inputPesquisaAnimal.addEventListener('input', filtrarAnimaisVacinacao);
  }

  animaisVacinacao.forEach((animal) => {
    animal.addEventListener('click', () => {
      selecionarAnimal(animal);
    });
  });

  if (abrirModalCadastrarVacinacao && modalCadastrarVacinacao) {
    abrirModalCadastrarVacinacao.addEventListener('click', () => {
      resetarFormularioCadastro();

      abrirModal(modalCadastrarVacinacao);
    });
  }

  document
    .querySelectorAll('[data-close-modal="modalCadastrarVacinacao"]')
    .forEach((elemento) => {
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

      if (typeof validarCadastroVacinacao !== 'function') {
        mostrarMensagemModal(
          'error',
          'Não foi possível validar o formulário. Atualize a página e tente novamente.'
        );
        return;
      }

      const erroValidacao =
        validarCadastroVacinacao();

      if (erroValidacao) {
        mostrarMensagemModal('error', erroValidacao);
        return;
      }

      const submitButton =
        formCadastrarVacinacao.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.textContent : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Salvando...';
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
          submitButton.textContent = textoOriginalBotao;
        }
      }
    });
  }
});
