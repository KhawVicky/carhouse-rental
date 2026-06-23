// User Scroll For Navbar
// Add custom JavaScript here
function userScroll() {
    const navbar = document.querySelector('.navbar');
  
    window.addEventListener('scroll', () => {
      if (window.scrollY > 80) {
        navbar.classList.add('bg-dark-opacity');
      } else {
        navbar.classList.remove('bg-dark-opacity');
      }
    });
  }
  document.addEventListener('DOMContentLoaded', userScroll);

  document.addEventListener('DOMContentLoaded', function() {
    const inputGroups = document.querySelectorAll('.input-group');

    inputGroups.forEach(function(inputGroup) {
        const inputField = inputGroup.querySelector('.form-control');
        const inputGroupTexts = inputGroup.querySelectorAll('.input-group-text');
     
        inputField.addEventListener('focus', function() {
            inputGroup.classList.add('custom-border');
            inputGroupTexts.forEach(function(text) {
                text.classList.add('input-group-text-focus');
            });
        });

        inputField.addEventListener('blur', function() {
            inputGroup.classList.remove('custom-border');
            inputGroupTexts.forEach(function(text) {
                text.classList.remove('input-group-text-focus');
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
  const togglePasswordIcons = document.querySelectorAll('.toggle-password');

  togglePasswordIcons.forEach(function(icon) {
      icon.addEventListener('click', function() {
          const inputField = icon.parentElement.querySelector('input');
          const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
          inputField.setAttribute('type', type);
          icon.querySelector('i').classList.toggle('fa-eye-slash');
          icon.querySelector('i').classList.toggle('fa-eye');
      });
  });
});

