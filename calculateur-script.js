// calculateur-script.js

document.addEventListener('DOMContentLoaded', () => {
  const sexeBtns   = document.querySelectorAll('.segmented-btn');
  const sexeInput  = document.querySelector('#sexe');
  const form       = document.querySelector('#calc-form');
  const resKcal    = document.querySelector('#res-kcal');
  const resText    = document.querySelector('#res-text');

  const prodSelect = document.querySelector('#prod-select');
  const prodQte    = document.querySelector('#prod-qte');
  const prodKcal   = document.querySelector('#prod-kcal');

  const sportSelect = document.querySelector('#sport-select');
  const sportDuree  = document.querySelector('#sport-duree');
  const sportKcal   = document.querySelector('#sport-kcal');

  const btnLog = document.querySelector('#btn-log');
  const logMsg = document.querySelector('#log-msg');

  /* ===========================
   *  Sexe toggle
   * =========================*/
  sexeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      sexeBtns.forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      sexeInput.value = btn.dataset.sexe;
    });
  });

  /* ===========================
   *  Produits : chargement BDD
   * =========================*/
  fetch('calculateur.php?ajax=produits')
    .then(r => r.json())
    .then(data => {
      prodSelect.innerHTML = '<option value="">Sélectionne un produit…</option>';
      data.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id_produit;
        opt.dataset.kcal = p.energie_kcal; // kcal pour 100 g
        opt.textContent = `${p.nom_produit} (${p.energie_kcal} kcal / 100g)`;
        prodSelect.appendChild(opt);
      });
    })
    .catch(() => {
      prodSelect.innerHTML = '<option value="">Erreur de chargement</option>';
    });

  /* ===========================
   *  Sports : chargement BDD
   * =========================*/
  fetch('calculateur.php?ajax=sports')
    .then(r => r.json())
    .then(data => {
      sportSelect.innerHTML = '<option value="">Choisir une activité…</option>';
      data.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id_sport;
        opt.dataset.kcalH70 = s.kcal_h_70kg; // kcal / h pour 70 kg
        opt.textContent = `${s.nom_sport} (${s.MET} MET)`;
        sportSelect.appendChild(opt);
      });
    })
    .catch(err => {
      console.error('Erreur chargement sports :', err);
      sportSelect.innerHTML = '<option value="">Erreur de chargement</option>';
    });

  /* ===========================
   *  Calcul kcal produit
   * =========================*/
  function updateProdKcal() {
    const opt = prodSelect.selectedOptions[0];
    if (!opt) {
      prodKcal.textContent = '0';
      return;
    }
    const base = parseFloat(opt.dataset.kcal || '0'); // kcal / 100 g
    const qte  = parseFloat(prodQte.value || '0');
    const total = base * qte / 100;
    prodKcal.textContent = Math.round(total);
  }

  prodSelect.addEventListener('change', updateProdKcal);
  prodQte.addEventListener('input', updateProdKcal);

  /* ===========================
   *  Calcul kcal sport
   * =========================*/
  function updateSportKcal() {
    if (!sportSelect || !sportDuree || !sportKcal) return;

    const opt   = sportSelect.selectedOptions[0];
    const duree = parseFloat(sportDuree.value || '0'); // minutes

    if (!opt || !opt.dataset.kcalH70 || !duree) {
      sportKcal.textContent = '≈ 0 kcal dépensées.';
      return;
    }

    const kcalH = parseFloat(opt.dataset.kcalH70 || '0'); // kcal/h (70kg)
    const kcal  = Math.round(kcalH * (duree / 60));

    sportKcal.textContent = `≈ ${kcal} kcal dépensées.`;
  }

  sportSelect.addEventListener('change', updateSportKcal);
  sportDuree.addEventListener('input', updateSportKcal);

  /* ===========================
   *  Calcul besoins caloriques
   * =========================*/
  form.addEventListener('submit', e => {
    e.preventDefault();

    const age      = parseFloat(document.querySelector('#age').value    || '0');
    const taille   = parseFloat(document.querySelector('#taille').value || '0'); // cm
    const poids    = parseFloat(document.querySelector('#poids').value  || '0'); // kg
    const activite = parseFloat(document.querySelector('#activite').value || '1.2');
    const sexe     = sexeInput.value;

    if (!age || !taille || !poids) return;

    let mb;
    if (sexe === 'H') {
      mb = 88.362 + (13.397 * poids) + (4.799 * taille) - (5.677 * age);
    } else {
      mb = 447.593 + (9.247 * poids) + (3.098 * taille) - (4.330 * age);
    }

    const maintenance = Math.round(mb * activite);
    resKcal.textContent = maintenance.toString();
    resText.textContent =
      `Pour maintenir ton poids actuel, vise environ ${maintenance} kcal / jour. ` +
      `Augmente pour prendre du poids, baisse pour en perdre.`;
  });

  btnLog.addEventListener('click', () => {
    const fd = new FormData();
    fd.append('id_produit', prodSelect.value);
    fd.append('quantite', prodQte.value);
    fd.append('id_sport', sportSelect.value);
    fd.append('duree', sportDuree.value);

    fetch('calculateur.php?ajax=log', {
      method: 'POST',
      body: fd
    })
      .then(r => r.json())
      .then(data => {
        console.log('Réponse log :', data); // ← IMPORTANT

        if (data.ok) {
          logMsg.textContent = 'Enregistré ✅';
          logMsg.style.color = 'green';
        } else {
          logMsg.textContent = 'Erreur : ' + (data.error || 'Erreur lors de l’enregistrement.');
          logMsg.style.color = 'red';
        }
      })
      .catch(err => {
        console.error(err);
        logMsg.textContent = 'Erreur réseau.';
        logMsg.style.color = 'red';
      });
  });
