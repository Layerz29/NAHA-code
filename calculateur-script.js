// calculateur-script.js

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('calc-form');

  const ageInput     = document.getElementById('age');
  const tailleInput  = document.getElementById('taille');
  const poidsInput   = document.getElementById('poids');
  const activiteSel  = document.getElementById('activite');
  const sexeHidden   = document.getElementById('sexe');
  const sexeButtons  = document.querySelectorAll('.segmented-btn');

  const resKcal   = document.getElementById('res-kcal');
  const resText   = document.getElementById('res-text');

  const goalBtns      = document.querySelectorAll('.goal-btn');
  const goalMaintien  = document.getElementById('goal-maintien');
  const goalPerte     = document.getElementById('goal-perte');
  const goalPrise     = document.getElementById('goal-prise');

  let maintenanceKcal = null;

  /* ==========================
     Switch Homme / Femme
     ========================== */
  sexeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      sexeButtons.forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      sexeHidden.value = btn.dataset.sexe; // "H" ou "F"
    });
  });

  /* ==========================
     Soumission du formulaire
     ========================== */
  form.addEventListener('submit', (e) => {
    e.preventDefault(); // pas de reload

    const age      = Number(ageInput.value);
    const taille   = Number(tailleInput.value);
    const poids    = Number(poidsInput.value);
    const activite = Number(activiteSel.value);
    const sexe     = sexeHidden.value || 'H';

    if (!age || !taille || !poids || !activite) {
      resText.textContent = "Complète toutes les infos avant de lancer le calcul.";
      return;
    }

    // Mifflin-St Jeor
    let bmr;
    if (sexe === 'H') {
      bmr = 10 * poids + 6.25 * taille - 5 * age + 5;
    } else {
      bmr = 10 * poids + 6.25 * taille - 5 * age - 161;
    }

    maintenanceKcal = Math.round(bmr * activite);

    resKcal.textContent = maintenanceKcal;
    resText.textContent = "C'est l'estimation de tes besoins journaliers pour rester stable.";

    updateGoals();

    // on stocke côté navigateur
    const data = { age, taille, poids, activite, sexe, maintenanceKcal };
    localStorage.setItem('naha_calc', JSON.stringify(data));
  });

  /* ==========================
     Mise à jour des 3 objectifs
     ========================== */
  function updateGoals() {
    if (!maintenanceKcal) {
      goalMaintien.textContent = "–";
      goalPerte.textContent    = "–";
      goalPrise.textContent    = "–";
      return;
    }

    goalMaintien.textContent = maintenanceKcal + " kcal / jour";
    goalPerte.textContent    = Math.max(maintenanceKcal - 400, 0) + " kcal / jour";
    goalPrise.textContent    = (maintenanceKcal + 300) + " kcal / jour";
  }

  /* ==========================
     Clic sur un objectif
     ========================== */
  goalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (!maintenanceKcal) return;

      goalBtns.forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');

      const name  = btn.dataset.name || "";
      const delta = Number(btn.dataset.delta || 0);
      const target = maintenanceKcal + delta;

      // on affiche dans la petite ligne "Objectif actuel" de la carte active
      const activeText = btn.querySelector('.goal-active-text');
      if (activeText) {
        activeText.textContent = `Objectif actuel — ≈ ${target} kcal / jour`;
      }

      // on vide les autres
      goalBtns.forEach(b => {
        if (b !== btn) {
          const t = b.querySelector('.goal-active-text');
          if (t) t.textContent = '';
        }
      });

      // on garde l’objectif en mémoire (navigateur)
      const goalData = { name, delta };
      localStorage.setItem('naha_goal', JSON.stringify(goalData));
    });
  });

  /* ==========================
     Rechargement depuis localStorage
     ========================== */
  const saved = localStorage.getItem('naha_calc');
  if (saved) {
    try {
      const data = JSON.parse(saved);
      if (data.age)      ageInput.value    = data.age;
      if (data.taille)   tailleInput.value = data.taille;
      if (data.poids)    poidsInput.value  = data.poids;
      if (data.activite) activiteSel.value = data.activite;
      if (data.sexe)     sexeHidden.value  = data.sexe;

      sexeButtons.forEach(b => {
        b.classList.toggle('is-active', b.dataset.sexe === sexeHidden.value);
      });

      if (data.maintenanceKcal) {
        maintenanceKcal = data.maintenanceKcal;
        resKcal.textContent = maintenanceKcal;
        resText.textContent = "Valeur rechargée depuis ta dernière visite.";
        updateGoals();
      }
    } catch (err) {
      console.error("Erreur parse stockage NAHA :", err);
    }
  }

  const savedGoal = localStorage.getItem('naha_goal');
  if (savedGoal && maintenanceKcal) {
    try {
      const g = JSON.parse(savedGoal);
      goalBtns.forEach(b => {
        const isActive = (b.dataset.name === g.name);
        b.classList.toggle('is-active', isActive);
        if (isActive) {
          const delta  = Number(b.dataset.delta || 0);
          const target = maintenanceKcal + delta;
          const t = b.querySelector('.goal-active-text');
          if (t) t.textContent = `Objectif actuel — ≈ ${target} kcal / jour`;
        }
      });
    } catch (err) {
      console.error("Erreur parse objectif NAHA :", err);
    }
  }

  /* ==========================
     Bouton "Enregistrer cet objectif"
     ========================== */
  const saveBtn = document.getElementById('save-goal');
  const saveMsg = document.getElementById('save-goal-msg');

  console.log('saveBtn =', saveBtn);

  function getCurrentGoal() {
    if (!maintenanceKcal) return null;
    const activeBtn = document.querySelector('.goal-btn.is-active');
    if (!activeBtn) return null;

    const name  = activeBtn.dataset.name || '';
    const delta = Number(activeBtn.dataset.delta || 0);
    const target = maintenanceKcal + delta;

    return { name, target };
  }

  if (saveBtn) {
    saveBtn.addEventListener('click', async () => {
      const goal = getCurrentGoal();

      if (!maintenanceKcal || !goal) {
        saveMsg.textContent = "Calcule d'abord tes besoins et choisis un objectif.";
        return;
      }

      // === Version 1 : juste test visuel ===
      // décommente ça pour vérifier que le clic marche
      // alert("Click OK, objectif : " + goal.name + " (" + goal.target + " kcal)");

      saveMsg.textContent = "Enregistrement en cours...";

      const payload = {
        age: Number(ageInput.value),
        taille: Number(tailleInput.value),
        poids: Number(poidsInput.value),
        activite: Number(activiteSel.value),
        sexe: sexeHidden.value || 'H',
        maintenance: maintenanceKcal,
        objectif_nom: goal.name,
        objectif_kcal: goal.target
      };

      try {
        const res = await fetch('save_goal.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

        const json = await res.json();
        if (!res.ok || !json.ok) {
          saveMsg.textContent = json.message || "Erreur lors de l'enregistrement.";
        } else {
          saveMsg.textContent = "Objectif enregistré dans ton tableau de bord ✅";
        }
      } catch (err) {
        console.error(err);
        saveMsg.textContent = "Erreur réseau, réessaie dans un instant.";
      }
    });
  }

});
