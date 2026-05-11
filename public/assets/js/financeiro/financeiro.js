const menuToggle =
document.getElementById('menuToggle');

const sidebar =
document.getElementById('sidebar');


menuToggle.addEventListener('click', () => {

  sidebar.classList.toggle('active');

});


document.addEventListener('click', (event) => {

  const isInsideSidebar =
  sidebar.contains(event.target);

  const isMenuButton =
  menuToggle.contains(event.target);

  if(
    window.innerWidth <= 992 &&
    !isInsideSidebar &&
    !isMenuButton
  ){

    sidebar.classList.remove('active');

  }

});


const transactionButton =
document.querySelector('.new-transaction-btn');

transactionButton.addEventListener('click', () => {

  alert('Nova transação adicionada!');

});