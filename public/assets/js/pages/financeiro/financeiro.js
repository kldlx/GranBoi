document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menuToggle');
  const sidebar = document.getElementById('sidebar');

  if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });

    document.addEventListener('click', (event) => {
      if (
        window.innerWidth <= 992 &&
        !sidebar.contains(event.target) &&
        !menuToggle.contains(event.target)
      ) {
        sidebar.classList.remove('active');
      }
    });
  }

  const formDespesa = document.getElementById('formDespesa');
  const despesaFormMessage = document.getElementById('despesaFormMessage');

  function mostrarMensagem(tipo, texto) {
    if (!despesaFormMessage) return;
    despesaFormMessage.hidden = false;
    despesaFormMessage.className = `financeiro-form-message ${tipo}`;
    despesaFormMessage.textContent = texto;
  }

  function ocultarMensagem() {
    if (!despesaFormMessage) return;
    despesaFormMessage.hidden = true;
    despesaFormMessage.textContent = '';
  }

  if (formDespesa) {
    formDespesa.addEventListener('submit', async (event) => {
      event.preventDefault();
      ocultarMensagem();

      const submitBtn = formDespesa.querySelector('button[type="submit"]');
      const textoOriginal = submitBtn ? submitBtn.innerHTML : '';

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ri-loader-4-line"></i> Salvando...';
      }

      try {
        const response = await fetch(formDespesa.action, {
          method: 'POST',
          body: new FormData(formDespesa),
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const data = await response.json();

        if (!data.sucesso) {
          mostrarMensagem('error', data.mensagem || 'Erro ao registrar despesa.');
          return;
        }

        mostrarMensagem('success', data.mensagem || 'Despesa registrada com sucesso.');
        formDespesa.reset();
        document.getElementById('despesa_data').value = new Date().toISOString().split('T')[0];

        setTimeout(() => window.location.reload(), 900);

      } catch {
        mostrarMensagem('error', 'Erro de comunicação com o servidor. Tente novamente.');
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = textoOriginal;
        }
      }
    });
  }
});
