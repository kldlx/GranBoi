const togglePassword =
document.getElementById('togglePassword');

const password =
document.getElementById('password');

const loginForm =
document.querySelector('.login-form');

/* TOGGLE PASSWORD */

togglePassword.addEventListener('click', () => {

  const type =
  password.getAttribute('type') === 'password'
  ? 'text'
  : 'password';

  password.setAttribute('type', type);

  togglePassword.innerHTML =
  type === 'password'
  ? '<i class="ri-eye-line"></i>'
  : '<i class="ri-eye-off-line"></i>';

});

/* LOGIN VALIDATION */

loginForm.addEventListener('submit', (event) => {

  event.preventDefault();

  const email =
  document.querySelector('input[type="email"]').value;

  const passwordValue =
  password.value;

  /* LOGIN FAKE */

  const validEmail =
  'admin@granboi.com';

  const validPassword =
  '1234';

  if(
    email === validEmail &&
    passwordValue === validPassword
  ){

    window.location.href =
    '../dashboard/dashboard.html';

  }else{

    alert(
      'E-mail ou senha inválidos!'
    );

  }

});