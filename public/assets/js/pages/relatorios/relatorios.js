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


const reportButtons =
document.querySelectorAll('.report-btn');

reportButtons.forEach(button => {

  button.addEventListener('click', () => {

    alert('Relatório gerado com sucesso!');

  });

});


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