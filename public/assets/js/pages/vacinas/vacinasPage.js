document.addEventListener('DOMContentLoaded', () => {
  const inputPesquisa = document.getElementById('pesquisaVacinacao');
  const linhasVacinacao = document.querySelectorAll('.vacinacao-row');
  const linhaSemResultado = document.getElementById('vacinacaoSearchEmpty');
  const botoesFiltro = document.querySelectorAll('.vacinacao-filter-btn');

  const modalVisualizarVacinacao =
    document.getElementById('modalVisualizarVacinacao');

  const botoesVisualizar =
    document.querySelectorAll('.visualizar-vacinacao-btn');

  const modalEditarVacinacao =
    document.getElementById('modalEditarVacinacao');

  const botoesEditar =
    document.querySelectorAll('.editar-vacinacao-btn');

  const botoesAplicarProximaDose =
    document.querySelectorAll('.aplicar-proxima-dose-btn');

  const formEditarVacinacao =
    document.getElementById('formEditarVacinacao');

  const modalExcluirVacinacao =
    document.getElementById('modalExcluirVacinacao');

  const botoesExcluir =
    document.querySelectorAll('.excluir-vacinacao-btn');

  const formExcluirVacinacao =
    document.getElementById('formExcluirVacinacao');

  const editarPesquisaAnimal =
    document.getElementById('editarPesquisaAnimalVacinacao');

  const editarListaAnimais =
    document.getElementById('editarListaAnimaisVacinacao');

  const editarAnimais =
    document.querySelectorAll('.editar-vacinacao-animal-option');

  const editarAnimalSearchEmpty =
    document.getElementById('editarVacinacaoAnimalSearchEmpty');

  const editarAnimalSelecionadoBox =
    document.getElementById('editarVacinacaoAnimalSelecionado');

  let filtroStatusAtual = 'todos';

  function filtrarVacinacoes() {
    const termo = inputPesquisa ? inputPesquisa.value.trim().toLowerCase() : '';

    let totalVisivel = 0;

    linhasVacinacao.forEach((linha) => {
      const textoLinha = linha.textContent.toLowerCase();
      const statusLinha = linha.dataset.status || '';

      const correspondePesquisa = textoLinha.includes(termo);
      const correspondeStatus =
        filtroStatusAtual === 'todos' || statusLinha === filtroStatusAtual;

      if (correspondePesquisa && correspondeStatus) {
        linha.style.display = '';
        totalVisivel++;
      } else {
        linha.style.display = 'none';
      }
    });

    if (linhaSemResultado) {
      linhaSemResultado.style.display = totalVisivel === 0 ? '' : 'none';
    }
  }

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

  function obterDataAtualSistema() {
    const hoje = new Date();
    const ano = hoje.getFullYear();
    const mes = String(hoje.getMonth() + 1).padStart(2, '0');
    const dia = String(hoje.getDate()).padStart(2, '0');

    return `${ano}-${mes}-${dia}`;
  }

  function configurarModalEdicao(titulo, descricao, textoBotao) {
    const tituloEl = modalEditarVacinacao?.querySelector('.modal-header h2');
    const descricaoEl = modalEditarVacinacao?.querySelector('.modal-header p');
    const botaoSalvar = formEditarVacinacao?.querySelector('button[type="submit"]');

    if (tituloEl) {
      tituloEl.textContent = titulo;
    }

    if (descricaoEl) {
      descricaoEl.textContent = descricao;
    }

    if (botaoSalvar) {
      botaoSalvar.textContent = textoBotao;
    }
  }

  function mostrarMensagemEditar(tipo, mensagem) {
    const messageBox = document.getElementById('editarVacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `vacinacao-modal-message ${tipo}`;
    messageBox.textContent = mensagem;
  }

  function limparMensagemEditar() {
    const messageBox = document.getElementById('editarVacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'vacinacao-modal-message';
    messageBox.textContent = '';
  }

  function mostrarMensagemExcluir(tipo, mensagem) {
    const messageBox = document.getElementById('excluirVacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = false;
    messageBox.className = `vacinacao-modal-message ${tipo}`;
    messageBox.textContent = mensagem;
  }

  function limparMensagemExcluir() {
    const messageBox = document.getElementById('excluirVacinacaoModalMessage');

    if (!messageBox) {
      return;
    }

    messageBox.hidden = true;
    messageBox.className = 'vacinacao-modal-message';
    messageBox.textContent = '';
  }

  function esconderListaEditarAnimais() {
    if (editarListaAnimais) {
      editarListaAnimais.style.display = 'none';
    }

    editarAnimais.forEach((animal) => {
      animal.style.display = 'none';
    });

    if (editarAnimalSearchEmpty) {
      editarAnimalSearchEmpty.style.display = 'none';
    }
  }

  function mostrarListaEditarAnimais() {
    if (editarListaAnimais) {
      editarListaAnimais.style.display = 'flex';
    }
  }

  function filtrarAnimaisEdicao() {
    const termo = editarPesquisaAnimal
      ? editarPesquisaAnimal.value.trim().toLowerCase()
      : '';

    if (!termo) {
      esconderListaEditarAnimais();
      return;
    }

    mostrarListaEditarAnimais();

    let totalVisivel = 0;

    editarAnimais.forEach((animal) => {
      const texto = animal.dataset.search || '';

      if (texto.includes(termo)) {
        animal.style.display = '';
        totalVisivel++;
      } else {
        animal.style.display = 'none';
      }
    });

    if (editarAnimalSearchEmpty) {
      editarAnimalSearchEmpty.style.display = totalVisivel === 0 ? '' : 'none';
    }
  }

  function selecionarAnimalEdicao(botao) {
    limparMensagemEditar();

    const status = botao.dataset.status || '';
    const statusTexto = botao.dataset.statusTexto || status;
    const brinco = botao.dataset.brinco || '-';
    const raca = botao.dataset.raca || 'Raça não informada';

    if (status !== 'ativo') {
      preencherCampo('editar_animal_id', '');

      if (editarAnimalSelecionadoBox) {
        editarAnimalSelecionadoBox.hidden = true;
        editarAnimalSelecionadoBox.textContent = 'Nenhum animal selecionado.';
        editarAnimalSelecionadoBox.className = 'vacinacao-animal-selected';
      }

      editarAnimais.forEach((animal) => {
        animal.classList.remove('active');
      });

      mostrarMensagemEditar(
        'error',
        `Não é possível registrar vacinação para animal ${statusTexto.toLowerCase()}.`
      );

      return;
    }

    preencherCampo('editar_animal_id', botao.dataset.id);

    editarAnimais.forEach((animal) => {
      animal.classList.remove('active');
    });

    botao.classList.add('active');

    if (editarAnimalSelecionadoBox) {
      editarAnimalSelecionadoBox.hidden = false;
      editarAnimalSelecionadoBox.className = 'vacinacao-animal-selected active';
      editarAnimalSelecionadoBox.textContent = `Animal selecionado: #${brinco} - ${raca} (${statusTexto})`;
    }

    if (editarPesquisaAnimal) {
      editarPesquisaAnimal.value = `#${brinco} - ${raca}`;
    }

    esconderListaEditarAnimais();
  }

  function preencherAnimalAtualEdicao(animalId) {
    const animalAtual = Array.from(editarAnimais).find((animal) => {
      return animal.dataset.id === String(animalId);
    });

    if (!animalAtual) {
      preencherCampo('editar_animal_id', animalId);

      if (editarAnimalSelecionadoBox) {
        editarAnimalSelecionadoBox.hidden = false;
        editarAnimalSelecionadoBox.className = 'vacinacao-animal-selected active';
        editarAnimalSelecionadoBox.textContent = 'Animal selecionado.';
      }

      return;
    }

    const brinco = animalAtual.dataset.brinco || '-';
    const raca = animalAtual.dataset.raca || 'Raça não informada';
    const statusTexto = animalAtual.dataset.statusTexto || '-';

    preencherCampo('editar_animal_id', animalAtual.dataset.id);

    editarAnimais.forEach((animal) => {
      animal.classList.remove('active');
    });

    animalAtual.classList.add('active');

    if (editarAnimalSelecionadoBox) {
      editarAnimalSelecionadoBox.hidden = false;
      editarAnimalSelecionadoBox.className = 'vacinacao-animal-selected active';
      editarAnimalSelecionadoBox.textContent = `Animal selecionado: #${brinco} - ${raca} (${statusTexto})`;
    }

    if (editarPesquisaAnimal) {
      editarPesquisaAnimal.value = `#${brinco} - ${raca}`;
    }
  }

  function validarEdicaoVacinacao() {
    const animalId = document.getElementById('editar_animal_id')?.value;
    const vacina = document.getElementById('editar_vacina')?.value.trim();
    const dataAplicacao = document.getElementById('editar_data_aplicacao')?.value;
    const proximaDose = document.getElementById('editar_proxima_dose')?.value;
    const quantidade = document.getElementById('editar_quantidade')?.value.trim();
    const custo = document.getElementById('editar_preco_custo_sanitario')?.value.trim();

    if (!animalId || !vacina || !dataAplicacao) {
      return 'Preencha os campos obrigatórios: animal, vacina e data de aplicação.';
    }

    if (!quantidade) {
      return 'Informe a quantidade/dose aplicada.';
    }

    if (isNaN(quantidade) || Number(quantidade) <= 0) {
      return 'Informe uma quantidade/dose maior que zero.';
    }

    if (custo === '' || custo === undefined) {
      return 'Informe o custo da vacina.';
    }

    const custoNormalizado = custo.replace(/\./g, '').replace(',', '.');
    if (isNaN(custoNormalizado) || Number(custoNormalizado) < 0) {
      return 'Informe um custo da vacina válido.';
    }

    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    const dataAplicacaoObj = new Date(dataAplicacao + 'T00:00:00');

    if (dataAplicacaoObj > hoje) {
      return 'A data de aplicação não pode ser futura.';
    }

    if (proximaDose) {
      const proximaDoseObj = new Date(proximaDose + 'T00:00:00');

      if (proximaDoseObj < dataAplicacaoObj) {
        return 'A próxima dose não pode ser anterior à data de aplicação.';
      }
    }

    return null;
  }

  function abrirDetalhesVacinacao(botao) {
    preencherTexto(
      'detalheVacinacaoAnimal',
      `#${botao.dataset.animal || '-'}`
    );

    preencherTexto(
      'detalheVacinacaoVacina',
      botao.dataset.vacina
    );

    preencherTexto(
      'detalheVacinacaoDose',
      botao.dataset.dose
    );

    preencherTexto(
      'detalheVacinacaoAplicacao',
      botao.dataset.aplicacao
    );

    preencherTexto(
      'detalheVacinacaoProximaDose',
      botao.dataset.proximaDose
    );

    preencherTexto(
      'detalheVacinacaoResponsavel',
      botao.dataset.responsavel
    );

    preencherTexto(
      'detalheVacinacaoStatus',
      botao.dataset.status
    );

    abrirModal(modalVisualizarVacinacao);
  }

  function abrirEdicaoVacinacao(botao) {
    limparMensagemEditar();
    esconderListaEditarAnimais();
    configurarModalEdicao(
      'Editar Vacinação',
      'Atualize os dados do registro sanitário',
      'Salvar Alterações'
    );

    preencherCampo('editar_vacinacao_id', botao.dataset.id);
    preencherCampo('editar_vacina', botao.dataset.vacina);
    preencherCampo('editar_quantidade', botao.dataset.quantidade);
    preencherCampo('editar_preco_custo_sanitario', botao.dataset.custo);
    preencherCampo('editar_data_aplicacao', botao.dataset.dataAplicacao);
    preencherCampo('editar_proxima_dose', botao.dataset.proximaDose);

    preencherAnimalAtualEdicao(botao.dataset.animalId);

    abrirModal(modalEditarVacinacao);
  }

  function abrirAplicacaoProximaDose(botao) {
    limparMensagemEditar();
    esconderListaEditarAnimais();
    configurarModalEdicao(
      'Aplicar Próxima Dose',
      'Atualize o registro atrasado com a nova aplicação',
      'Aplicar Dose'
    );

    preencherCampo('editar_vacinacao_id', botao.dataset.id);
    preencherCampo('editar_vacina', botao.dataset.vacina);
    preencherCampo('editar_quantidade', botao.dataset.quantidade);
    preencherCampo('editar_preco_custo_sanitario', botao.dataset.custo);
    preencherCampo('editar_data_aplicacao', obterDataAtualSistema());
    preencherCampo('editar_proxima_dose', '');

    preencherAnimalAtualEdicao(botao.dataset.animalId);

    mostrarMensagemEditar(
      'success',
      'Informe a data da próxima dose se houver. Ao salvar, este registro será atualizado.'
    );

    abrirModal(modalEditarVacinacao);
  }

  function abrirExclusaoVacinacao(botao) {
    limparMensagemExcluir();

    preencherCampo('excluir_vacinacao_id', botao.dataset.id);

    preencherTexto(
      'excluirVacinacaoVacina',
      botao.dataset.vacina
    );

    preencherTexto(
      'excluirVacinacaoAnimal',
      `#${botao.dataset.animal || '-'}`
    );

    abrirModal(modalExcluirVacinacao);
  }

  esconderListaEditarAnimais();

  if (editarPesquisaAnimal) {
    editarPesquisaAnimal.addEventListener('input', filtrarAnimaisEdicao);
  }

  editarAnimais.forEach((animal) => {
    animal.addEventListener('click', () => {
      selecionarAnimalEdicao(animal);
    });
  });

  if (inputPesquisa) {
    inputPesquisa.addEventListener('input', filtrarVacinacoes);
  }

  botoesFiltro.forEach((botao) => {
    botao.addEventListener('click', () => {
      botoesFiltro.forEach((item) => {
        item.classList.remove('active');
      });

      botao.classList.add('active');

      filtroStatusAtual = botao.dataset.statusFilter || 'todos';

      filtrarVacinacoes();
    });
  });

  botoesVisualizar.forEach((botao) => {
    botao.addEventListener('click', () => {
      abrirDetalhesVacinacao(botao);
    });
  });

  botoesEditar.forEach((botao) => {
    botao.addEventListener('click', () => {
      abrirEdicaoVacinacao(botao);
    });
  });

  botoesAplicarProximaDose.forEach((botao) => {
    botao.addEventListener('click', () => {
      abrirAplicacaoProximaDose(botao);
    });
  });

  botoesExcluir.forEach((botao) => {
    botao.addEventListener('click', () => {
      abrirExclusaoVacinacao(botao);
    });
  });

  document
    .querySelectorAll('[data-close-modal="modalVisualizarVacinacao"]')
    .forEach((elemento) => {
      elemento.addEventListener('click', () => {
        fecharModal(modalVisualizarVacinacao);
      });
    });

  document
    .querySelectorAll('[data-close-modal="modalEditarVacinacao"]')
    .forEach((elemento) => {
      elemento.addEventListener('click', () => {
        fecharModal(modalEditarVacinacao);
      });
    });

  document
    .querySelectorAll('[data-close-modal="modalExcluirVacinacao"]')
    .forEach((elemento) => {
      elemento.addEventListener('click', () => {
        fecharModal(modalExcluirVacinacao);
      });
    });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      fecharModal(modalVisualizarVacinacao);
      fecharModal(modalEditarVacinacao);
      fecharModal(modalExcluirVacinacao);
    }
  });

  if (formEditarVacinacao) {
    formEditarVacinacao.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemEditar();

      const erroValidacao = validarEdicaoVacinacao();

      if (erroValidacao) {
        mostrarMensagemEditar('error', erroValidacao);
        return;
      }

      const submitButton =
        formEditarVacinacao.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.textContent : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Salvando...';
      }

      try {
        const formData = new FormData(formEditarVacinacao);

        const response = await fetch(formEditarVacinacao.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemEditar(
            'error',
            data.mensagem || 'Erro ao atualizar vacinação.'
          );
          return;
        }

        mostrarMensagemEditar(
          'success',
          data.mensagem || 'Vacinação atualizada com sucesso.'
        );

        setTimeout(() => {
          window.location.reload();
        }, 700);

      } catch (error) {
        mostrarMensagemEditar(
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

  if (formExcluirVacinacao) {
    formExcluirVacinacao.addEventListener('submit', async (event) => {
      event.preventDefault();

      limparMensagemExcluir();

      const id = document.getElementById('excluir_vacinacao_id')?.value;

      if (!id) {
        mostrarMensagemExcluir('error', 'Vacinação não informada.');
        return;
      }

      const submitButton =
        formExcluirVacinacao.querySelector('button[type="submit"]');

      const textoOriginalBotao =
        submitButton ? submitButton.textContent : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Excluindo...';
      }

      try {
        const formData = new FormData(formExcluirVacinacao);

        const response = await fetch(formExcluirVacinacao.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemExcluir(
            'error',
            data.mensagem || 'Erro ao excluir vacinação.'
          );
          return;
        }

        mostrarMensagemExcluir(
          'success',
          data.mensagem || 'Vacinação excluída com sucesso.'
        );

        setTimeout(() => {
          window.location.reload();
        }, 700);

      } catch (error) {
        mostrarMensagemExcluir(
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
