document.addEventListener('DOMContentLoaded', () => {
  const configurarPesquisaTabela = (inputId, rowClass, emptyRowId) => {
    const inputPesquisa = document.getElementById(inputId);
    const linhas = document.querySelectorAll(`.${rowClass}`);
    const linhaSemResultado = document.getElementById(emptyRowId);

    if (!inputPesquisa || linhas.length === 0) {
      return;
    }

    inputPesquisa.addEventListener('input', () => {
      const termo = inputPesquisa.value.trim().toLowerCase();

      let totalVisivel = 0;

      linhas.forEach((linha) => {
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
  };

  configurarPesquisaTabela(
    'pesquisaRacas',
    'cadastros-raca-row',
    'racasSearchEmpty'
  );

  configurarPesquisaTabela(
    'pesquisaLotes',
    'cadastros-lote-row',
    'lotesSearchEmpty'
  );
});