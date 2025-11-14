document.addEventListener('DOMContentLoaded', () => {
  const feedbackForm = document.getElementById('feedback-form');
  const feedbackMsg  = document.getElementById('feedback-status');

  // Sécurité de base : si le form existe
  if (feedbackForm) {
    feedbackForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const formData = new FormData(feedbackForm);
      const message  = (formData.get('message') || '').toString().trim();

      if (!message) {
        feedbackMsg.textContent = 'Écris au moins une petite phrase 😉';
        feedbackMsg.style.color = '#b91c1c';
        return;
      }

      feedbackMsg.textContent = 'Envoi en cours...';
      feedbackMsg.style.color = '#4b5563';

      fetch('projet.php?ajax=feedback', {
        method: 'POST',
        body: formData,
      })
        .then(res => res.json())
        .then(data => {
          if (data.ok) {
            feedbackMsg.textContent = data.msg || 'Merci pour ton retour 🙌';
            feedbackMsg.style.color = '#15803d';
            feedbackForm.reset();
          } else {
            feedbackMsg.textContent = data.error || 'Erreur lors de l’envoi.';
            feedbackMsg.style.color = '#b91c1c';
          }
        })
        .catch(err => {
          console.error(err);
          feedbackMsg.textContent = 'Erreur réseau. Réessaie dans un instant.';
          feedbackMsg.style.color = '#b91c1c';
        });
    });
  }

  // Option sympa : smooth scroll si jamais tu rajoutes des ancres
  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const id = link.getAttribute('href');
      if (id && id.length > 1) {
        const target = document.querySelector(id);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    });
  });
});
