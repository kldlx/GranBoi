document.addEventListener('DOMContentLoaded', () => {

  const BASE_URL = document.getElementById('relatorioBaseUrl')?.value ?? '';

  /* ── abas ── */
  const tabs    = document.querySelectorAll('.relatorio-tab');
  const conteudos = document.querySelectorAll('.relatorio-tab-content');

  // restaurar aba ativa da URL hash
  const hashAtual = location.hash.replace('#', '') || 'rebanho';
  ativarAba(hashAtual);

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const id = tab.dataset.tab;
      ativarAba(id);
      history.replaceState(null, '', `#${id}`);
    });
  });

  function ativarAba(id) {
    tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === id));
    conteudos.forEach(c => c.classList.toggle('active', c.id === `tab-${id}`));
  }

  /* ── filtro de vacinação via AJAX ── */
  const btnFiltrar  = document.getElementById('btnFiltrarVacinacao');
  const tbody       = document.getElementById('vacinacaoTableBody');
  const contador    = document.getElementById('vacinacaoContador');
  const msgFiltro   = document.getElementById('vacinacaoFiltroMsg');

  function setMsg(tipo, texto) {
    if (!msgFiltro) return;
    msgFiltro.hidden = false;
    msgFiltro.className = `relatorio-filtro-msg ${tipo}`;
    msgFiltro.textContent = texto;
  }

  function clearMsg() {
    if (!msgFiltro) return;
    msgFiltro.hidden = true;
  }

  if (btnFiltrar) {
    btnFiltrar.addEventListener('click', async () => {
      const inicio = document.getElementById('data_inicio')?.value;
      const fim    = document.getElementById('data_fim')?.value;

      if (!inicio || !fim) {
        setMsg('error', 'Selecione as duas datas para filtrar.');
        return;
      }

      if (inicio > fim) {
        setMsg('error', 'A data inicial não pode ser maior que a data final.');
        return;
      }

      clearMsg();
      setMsg('loading', 'Carregando...');
      btnFiltrar.disabled = true;

      try {
        const url = `${BASE_URL}/relatorios?data_inicio=${inicio}&data_fim=${fim}`;
        const res = await fetch(url, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const data = await res.json();

        if (!data.sucesso) {
          setMsg('error', data.mensagem || 'Erro ao filtrar.');
          return;
        }

        tbody.innerHTML = data.html;
        clearMsg();

        const total = data.total;
        if (contador) {
          contador.textContent = `${total} registro${total !== 1 ? 's' : ''} encontrado${total !== 1 ? 's' : ''}`;
        }

      } catch {
        setMsg('error', 'Erro de comunicação com o servidor.');
      } finally {
        btnFiltrar.disabled = false;
      }
    });

    // filtrar também ao pressionar Enter nos campos de data
    ['data_inicio', 'data_fim'].forEach(id => {
      document.getElementById(id)?.addEventListener('keydown', e => {
        if (e.key === 'Enter') btnFiltrar.click();
      });
    });
  }

});
