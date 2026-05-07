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

/* REPORT BUTTONS */

const reportButtons =
document.querySelectorAll('.report-btn');

reportButtons.forEach(button => {

  button.addEventListener('click', () => {

    alert('Relatório gerado com sucesso!');

  });

});

/* DOWNLOAD BUTTONS */

const downloadButtons =
document.querySelectorAll('.download-btn');

downloadButtons.forEach(button => {

  if(
    !button.classList.contains('disabled')
  ){

    button.addEventListener('click', () => {

      alert('Download iniciado!');

    });

  }

});