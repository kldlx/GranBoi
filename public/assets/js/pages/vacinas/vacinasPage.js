document.addEventListener('DOMContentLoaded', () => {
  const inputPesquisa = document.getElementById('pesquisaVacinacao');
  const linhasVacinacao = document.querySelectorAll('.vacinacao-row');
  const linhaSemResultado = document.getElementById('vacinacaoSearchEmpty');

  if (!inputPesquisa || linhasVacinacao.length === 0) {
    return;
  }

  inputPesquisa.addEventListener('input', () => {
    const termo = inputPesquisa.value.trim().toLowerCase();

    let totalVisivel = 0;

    linhasVacinacao.forEach((linha) => {
      const textoLinha = linha.textContent.toLowerCase();

      if (textoLinha.includes(termo)) {
        linha.style.display = '';
        totalVisivel++;
      } else {
        linha.style.display = 'none';
      }
    });

    if (linhaSemResultado) {
      linhaSemResultado.style.display = totalVisivel === 0 ? '' : 'none';
    }
  });
});