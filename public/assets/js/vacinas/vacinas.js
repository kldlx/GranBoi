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

/* BUTTON */

const vaccineButton =
document.querySelector('.new-vaccine-btn');

vaccineButton.addEventListener('click', () => {

  alert('Nova vacinação adicionada!');

});