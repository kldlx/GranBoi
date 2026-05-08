const menuToggle =
document.getElementById('menuToggle');

const sidebar =
document.getElementById('sidebar');

/* SIDEBAR */

menuToggle.addEventListener('click', () => {

  sidebar.classList.toggle('active');

});

/* CLOSE MOBILE */

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

/* SAVE BUTTON */

const saveButton =
document.querySelector('.save-btn');

saveButton.addEventListener('click', () => {

  alert('Perfil atualizado com sucesso!');

});