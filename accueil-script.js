// Burger menu (mobile)
const header = document.querySelector('.nav');
const burger = document.querySelector('.burger');

if (burger) {
  burger.addEventListener('click', () => {
    const isOpen = header.classList.toggle('nav--open');
    burger.setAttribute('aria-expanded', String(isOpen));
  });
}

// Active link on click (visuel)
document.querySelectorAll('.links a').forEach(a => {
  a.addEventListener('click', () => {
    document.querySelectorAll('.links a').forEach(x => x.classList.remove('is-active'));
    a.classList.add('is-active');
  });
});

// Juste pour montrer que le JS charge bien
document.addEventListener('DOMContentLoaded', () => {
  console.log('✅ NAHA Accueil chargé');
});

