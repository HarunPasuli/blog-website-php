const passwordInfoIcon = document.querySelector('.password-info-icon');
const passwordInfoBox = document.querySelector('.password-info-box');

passwordInfoIcon.addEventListener('mouseenter', () => {
  passwordInfoBox.style.display = 'block';
});

passwordInfoIcon.addEventListener('mouseleave', () => {
  passwordInfoBox.style.display = 'none';
});
