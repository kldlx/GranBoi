const togglePassword =
document.getElementById('togglePassword');

const password =
document.getElementById('password');


if(togglePassword && password){

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

}