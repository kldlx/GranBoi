const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

if (menuToggle && sidebar) {
  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });
}

document.addEventListener('click', (event) => {

  if (!menuToggle || !sidebar) {
    return;
  }

  const isInsideSidebar = sidebar.contains(event.target);
  const isMenuButton = menuToggle.contains(event.target);

  if(
    window.innerWidth <= 992 &&
    !isInsideSidebar &&
    !isMenuButton
  ){

    sidebar.classList.remove('active');

  }

});


const saveButton = document.querySelector('.save-btn');

if (saveButton) {
  saveButton.addEventListener('click', () => {
    alert('Perfil atualizado com sucesso!');
  });
}

const passwordInput = document.getElementById('profilePassword');
const passwordToggle = document.getElementById('toggleProfilePassword');

if (passwordInput && passwordToggle) {
  passwordToggle.addEventListener('click', () => {
    const showingPassword = passwordInput.type === 'text';

    passwordInput.type = showingPassword ? 'password' : 'text';
    passwordToggle.title = showingPassword ? 'Mostrar senha' : 'Ocultar senha';
    passwordToggle.setAttribute('aria-label', passwordToggle.title);
    passwordToggle.innerHTML = showingPassword
      ? '<i class="ri-eye-line"></i>'
      : '<i class="ri-eye-off-line"></i>';
  });
}
