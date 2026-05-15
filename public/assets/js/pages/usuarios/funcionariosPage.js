document.addEventListener('DOMContentLoaded', () => {
  const inputPesquisa = document.getElementById('pesquisaFuncionario');
  const linhasFuncionario = document.querySelectorAll('.funcionario-row');
  const linhaSemResultado = document.getElementById('funcionarioSearchEmpty');
  const botoesFiltro = document.querySelectorAll('.funcionario-filter-btn');
  const formulariosReativar = document.querySelectorAll('.funcionario-reativar-form');

  let filtroStatusAtual = 'todos';

  function filtrarFuncionarios() {
    const termo = inputPesquisa ? inputPesquisa.value.trim().toLowerCase() : '';

    let totalVisivel = 0;

    linhasFuncionario.forEach((linha) => {
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

  function mostrarMensagemPagina(tipo, mensagem) {
    const mensagemExistente = document.querySelector('.funcionario-message');

    if (mensagemExistente) {
      mensagemExistente.remove();
    }

    const pageActions = document.querySelector('.funcionario-page-actions');

    if (!pageActions) {
      return;
    }

    const div = document.createElement('div');

    div.className =
      tipo === 'success'
        ? 'funcionario-message funcionario-message-success'
        : 'funcionario-message funcionario-message-error';

    div.innerHTML = `
      <i class="${tipo === 'success' ? 'ri-checkbox-circle-line' : 'ri-error-warning-line'}"></i>
      <span>${mensagem}</span>
    `;

    pageActions.insertAdjacentElement('beforebegin', div);

    setTimeout(() => {
      div.remove();
    }, 3500);
  }

  if (inputPesquisa) {
    inputPesquisa.addEventListener('input', filtrarFuncionarios);
  }

  botoesFiltro.forEach((botao) => {
    botao.addEventListener('click', () => {
      botoesFiltro.forEach((item) => {
        item.classList.remove('active');
      });

      botao.classList.add('active');

      filtroStatusAtual = botao.dataset.statusFilter || 'todos';

      filtrarFuncionarios();
    });
  });

  formulariosReativar.forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const submitButton = form.querySelector('button[type="submit"]');
      const textoOriginalBotao = submitButton ? submitButton.innerHTML : '';

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="ri-loader-4-line"></i>';
      }

      try {
        const formData = new FormData(form);

        const response = await fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagemPagina(
            'error',
            data.mensagem || 'Erro ao reativar funcionário.'
          );
          return;
        }

        mostrarMensagemPagina(
          'success',
          data.mensagem || 'Funcionário reativado com sucesso.'
        );

        setTimeout(() => {
          window.location.reload();
        }, 700);

      } catch (error) {
        mostrarMensagemPagina(
          'error',
          'Erro de comunicação com o servidor. Tente novamente.'
        );
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.innerHTML = textoOriginalBotao;
        }
      }
    });
  });
});