document.addEventListener('DOMContentLoaded', () => {

  const BASE = document.getElementById('formDespesa')?.action.replace('/financeiro/salvar-despesa', '') ?? '';

  /* ── helpers ── */
  function showMsg(el, tipo, texto) {
    if (!el) return;
    el.hidden = false;
    el.className = `financeiro-form-message ${tipo}`;
    el.textContent = texto;
  }

  function hideMsg(el) {
    if (!el) return;
    el.hidden = true;
    el.textContent = '';
  }

  function openModal(modal) {
    if (!modal) return;
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
  }

  function closeModal(modal) {
    if (!modal) return;
    modal.hidden = true;
    document.body.style.overflow = '';
  }

  async function postAjax(url, body) {
    const res = await fetch(url, {
      method: 'POST',
      body,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    return res.json();
  }

  /* ── paginação + filtro ── */
  const POR_PAGINA = 8;
  let paginaAtual = 1;
  let filtroAtivo = '';

  const tbody         = document.getElementById('tabelaDespesasBody');
  const filtroInput   = document.getElementById('filtroDespesa');
  const paginacaoWrap = document.getElementById('paginacaoWrap');
  const infoEl        = document.getElementById('paginacaoInfo');
  const btnAnterior   = document.getElementById('paginacaoAnterior');
  const btnProximo    = document.getElementById('paginacaoProximo');
  const contador      = document.getElementById('despesaContador');

  function todasAsLinhas() {
    return tbody ? Array.from(tbody.querySelectorAll('tr[data-filtravel]')) : [];
  }

  function linhasFiltradas() {
    if (!filtroAtivo) return todasAsLinhas();
    return todasAsLinhas().filter(tr =>
      tr.dataset.busca.includes(filtroAtivo)
    );
  }

  function renderPaginacao() {
    if (!tbody) return;
    const linhas = linhasFiltradas();
    const total  = linhas.length;
    const paginas = Math.max(1, Math.ceil(total / POR_PAGINA));

    if (paginaAtual > paginas) paginaAtual = paginas;

    const inicio = (paginaAtual - 1) * POR_PAGINA;
    const fim    = inicio + POR_PAGINA;

    // esconde todas
    todasAsLinhas().forEach(tr => tr.style.display = 'none');
    // mostra as da página atual após filtro
    linhas.forEach((tr, i) => {
      tr.style.display = (i >= inicio && i < fim) ? '' : 'none';
    });

    if (infoEl) infoEl.textContent = total > 0
      ? `${inicio + 1}–${Math.min(fim, total)} de ${total}`
      : '0 registros';

    if (btnAnterior) btnAnterior.disabled = paginaAtual <= 1;
    if (btnProximo)  btnProximo.disabled  = paginaAtual >= paginas;

    if (paginacaoWrap) paginacaoWrap.style.display = total > POR_PAGINA ? 'flex' : 'none';

    if (contador) {
      contador.textContent = `${total} registro${total !== 1 ? 's' : ''}`;
    }
  }

  // Marcar linhas com atributos de filtro
  if (tbody) {
    tbody.querySelectorAll('tr').forEach(tr => {
      if (tr.querySelector('.financeiro-empty')) return;
      tr.setAttribute('data-filtravel', '');
      tr.dataset.busca = tr.textContent.toLowerCase();
    });
    renderPaginacao();
  }

  if (filtroInput) {
    filtroInput.addEventListener('input', () => {
      filtroAtivo = filtroInput.value.toLowerCase().trim();
      paginaAtual = 1;
      renderPaginacao();
    });
  }

  if (btnAnterior) btnAnterior.addEventListener('click', () => { paginaAtual--; renderPaginacao(); });
  if (btnProximo)  btnProximo.addEventListener('click',  () => { paginaAtual++; renderPaginacao(); });

  /* ── cadastrar despesa ── */
  const formDespesa    = document.getElementById('formDespesa');
  const despesaFormMsg = document.getElementById('despesaFormMessage');

  if (formDespesa) {
    formDespesa.addEventListener('submit', async (e) => {
      e.preventDefault();
      hideMsg(despesaFormMsg);

      const btn  = formDespesa.querySelector('button[type="submit"]');
      const orig = btn?.innerHTML;
      if (btn) { btn.disabled = true; btn.innerHTML = '<i class="ri-loader-4-line"></i> Salvando...'; }

      try {
        const data = await postAjax(formDespesa.action, new FormData(formDespesa));
        if (!data.sucesso) { showMsg(despesaFormMsg, 'error', data.mensagem); return; }
        showMsg(despesaFormMsg, 'success', data.mensagem);
        formDespesa.reset();
        document.getElementById('despesa_data').value = new Date().toISOString().split('T')[0];
        setTimeout(() => window.location.reload(), 900);
      } catch {
        showMsg(despesaFormMsg, 'error', 'Erro de comunicação com o servidor.');
      } finally {
        if (btn) { btn.disabled = false; btn.innerHTML = orig; }
      }
    });
  }

  /* ── modal editar ── */
  const modalEditar   = document.getElementById('modalEditarDespesa');
  const formEditar    = document.getElementById('formEditarDespesa');
  const editarFormMsg = document.getElementById('editarFormMessage');

  function fecharEditar() { closeModal(modalEditar); hideMsg(editarFormMsg); }

  document.getElementById('fecharEditarDespesa')?.addEventListener('click', fecharEditar);
  document.getElementById('cancelarEditarDespesa')?.addEventListener('click', fecharEditar);
  document.getElementById('overlayEditarDespesa')?.addEventListener('click', fecharEditar);

  document.querySelectorAll('.financeiro-btn-editar').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('editar_id').value         = btn.dataset.id;
      document.getElementById('editar_descricao').value  = btn.dataset.descricao;
      document.getElementById('editar_categoria').value  = btn.dataset.categoria;
      document.getElementById('editar_valor').value      = btn.dataset.valor;
      document.getElementById('editar_data').value       = btn.dataset.data;
      document.getElementById('editar_observacao').value = btn.dataset.observacao;
      document.getElementById('editar_lote').value       = btn.dataset.lote || '';
      hideMsg(editarFormMsg);
      openModal(modalEditar);
    });
  });

  if (formEditar) {
    formEditar.addEventListener('submit', async (e) => {
      e.preventDefault();
      hideMsg(editarFormMsg);

      const btn  = formEditar.querySelector('button[type="submit"]');
      const orig = btn?.innerHTML;
      if (btn) { btn.disabled = true; btn.innerHTML = '<i class="ri-loader-4-line"></i> Salvando...'; }

      try {
        const data = await postAjax(formEditar.action, new FormData(formEditar));
        if (!data.sucesso) { showMsg(editarFormMsg, 'error', data.mensagem); return; }
        fecharEditar();
        setTimeout(() => window.location.reload(), 300);
      } catch {
        showMsg(editarFormMsg, 'error', 'Erro de comunicação com o servidor.');
      } finally {
        if (btn) { btn.disabled = false; btn.innerHTML = orig; }
      }
    });
  }

  /* ── modal excluir ── */
  const modalExcluir     = document.getElementById('modalExcluirDespesa');
  const confirmarExcluir = document.getElementById('confirmarExcluirDespesa');
  let excluirId = null;

  function fecharExcluir() { closeModal(modalExcluir); excluirId = null; }

  document.getElementById('fecharExcluirDespesa')?.addEventListener('click', fecharExcluir);
  document.getElementById('cancelarExcluirDespesa')?.addEventListener('click', fecharExcluir);
  document.getElementById('overlayExcluirDespesa')?.addEventListener('click', fecharExcluir);

  document.querySelectorAll('.financeiro-btn-excluir').forEach(btn => {
    btn.addEventListener('click', () => {
      excluirId = btn.dataset.id;
      document.getElementById('excluir_descricao_texto').textContent = `"${btn.dataset.descricao}"`;
      openModal(modalExcluir);
    });
  });

  if (confirmarExcluir) {
    confirmarExcluir.addEventListener('click', async () => {
      if (!excluirId) return;
      const orig = confirmarExcluir.innerHTML;
      confirmarExcluir.disabled = true;
      confirmarExcluir.innerHTML = '<i class="ri-loader-4-line"></i> Excluindo...';

      try {
        const fd = new FormData();
        fd.append('id', excluirId);
        const data = await postAjax(`${BASE}/financeiro/excluir-despesa`, fd);
        if (!data.sucesso) { alert(data.mensagem); return; }
        fecharExcluir();
        setTimeout(() => window.location.reload(), 300);
      } catch {
        alert('Erro de comunicação com o servidor.');
      } finally {
        confirmarExcluir.disabled = false;
        confirmarExcluir.innerHTML = orig;
      }
    });
  }

  /* ── ESC fecha modais ── */
  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    if (modalEditar  && !modalEditar.hidden)  fecharEditar();
    if (modalExcluir && !modalExcluir.hidden) fecharExcluir();
  });

});
