document.addEventListener('DOMContentLoaded', () => {
  const inputPesquisa = document.getElementById('pesquisaVacinacao');
  const linhasVacinacao = document.querySelectorAll('.vacinacao-row');
  const linhaSemResultado = document.getElementById('vacinacaoSearchEmpty');
  const botoesFiltro = document.querySelectorAll('.vacinacao-filter-btn');

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
});