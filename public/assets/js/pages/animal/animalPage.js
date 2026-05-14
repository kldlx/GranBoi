document.addEventListener('DOMContentLoaded', () => {
  const inputPesquisa = document.getElementById('pesquisaAnimal');
  const linhasAnimal = document.querySelectorAll('.animal-row');
  const linhaSemResultado = document.getElementById('animalSearchEmpty');
  const botoesFiltro = document.querySelectorAll('.animal-filter-btn');

  let filtroStatusAtual = 'todos';

  function filtrarAnimais() {
    const termo = inputPesquisa ? inputPesquisa.value.trim().toLowerCase() : '';

    let totalVisivel = 0;

    linhasAnimal.forEach((linha) => {
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
    inputPesquisa.addEventListener('input', filtrarAnimais);
  }

  botoesFiltro.forEach((botao) => {
    botao.addEventListener('click', () => {
      botoesFiltro.forEach((item) => {
        item.classList.remove('active');
      });

      botao.classList.add('active');

      filtroStatusAtual = botao.dataset.statusFilter || 'todos';

      filtrarAnimais();
    });
  });
});