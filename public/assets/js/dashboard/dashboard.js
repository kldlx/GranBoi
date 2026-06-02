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

/* MENU */

const menuItems =
document.querySelectorAll('.menu-item');

const dashboardSection =
document.getElementById('dashboardSection');

const gadoSection =
document.getElementById('gadoSection');

menuItems.forEach(item => {

  item.addEventListener('click', () => {

    menuItems.forEach(menu => {
      menu.classList.remove('active');
    });

    item.classList.add('active');

    const text =
    item.innerText.trim();

    /* RESET */

    dashboardSection.classList.remove('active');
    gadoSection.classList.remove('active');

    /* SHOW */

    if(text === 'Dashboard'){

      dashboardSection.classList.add('active');

    }

    if(text === 'Gado'){

      gadoSection.classList.add('active');

    }

  });

});