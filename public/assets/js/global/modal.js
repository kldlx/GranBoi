// public/assets/js/modal.js

const modalVacinacao = document.getElementById('modalVacinacao');

const abrirModal = document.getElementById('abrirModalVacinacao');

const fecharModal = document.getElementById('fecharModalVacinacao');

const cancelarModal = document.getElementById('cancelarModalVacinacao');


// ABRIR MODAL
abrirModal.addEventListener('click', () => {
  modalVacinacao.classList.add('active');
});


// FECHAR MODAL
function fecharModalFunction() {
  modalVacinacao.classList.remove('active');
}

fecharModal.addEventListener('click', fecharModalFunction);

cancelarModal.addEventListener('click', fecharModalFunction);


// FECHAR CLICANDO FORA
window.addEventListener('click', (event) => {

  if (event.target.classList.contains('modal-overlay')) {
    fecharModalFunction();
  }

});


// FECHAR COM ESC
document.addEventListener('keydown', (event) => {

  if (event.key === 'Escape') {
    fecharModalFunction();
  }

});