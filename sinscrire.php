
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>



<?php
// sinscrire.php
$nom    = $_GET['n']   ?? '';
$prenom = $_GET['p']   ?? '';
$adr    = $_GET['adr'] ?? '';
$num    = $_GET['num'] ?? '';
$mail   = $_GET['mail']?? '';
$err    = $_GET['err'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>NAHA — Inscription</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">

  <!-- Style global NAHA (le même que sur accueil.php) -->
  <link rel="stylesheet" href="accueil-style.css?v=<?php echo time(); ?>">

</head>

<body>

<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="#top">
      <span class="brand__logo">🍃</span>
      <span class="brand__text">NAHA</span>
    </a>

    <nav class="menu">
      <a class="pill is-active" href="accueil.php">Accueil</a>
      <a class="pill" href="tableau.php">Tableau de bord</a>
      <a class="pill" href="calculateur.php">Calculateur</a>
      <a class="pill" href="projet.php">Le Projet</a>
      <a class="pill" href="consommation.php">Consommation</a>
      <a class="pill" href="contact.php">Contact</a>
    </nav>

    <div class="auth">
      <?php if (isset($_SESSION['utilisateur'])): ?>
        <span class="auth-user">
          👤 <?php echo htmlspecialchars($_SESSION['utilisateur']['prenom'].' '.$_SESSION['utilisateur']['nom'], ENT_QUOTES, 'UTF-8'); ?>
          <span class="auth-tag">Connecté</span>
        </span>
        <a class="btn-ghost" href="deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a class="link <?php echo basename($_SERVER['PHP_SELF']) === 'seconnecter.php' ? 'is-active' : ''; ?>" href="seconnecter.php">Se connecter</a>
        <a class="btn-signup" href="sinscrire.php">S’inscrire</a>


      <?php endif; ?>
    </div>

</header>
<main class="auth-main">
  <div class="container">

    <h1 class="auth-title">Créer ton compte <span>NAHA</span></h1>
    <p class="auth-subtitle">Rejoins la team et commence ton suivi personnalisé.</p>
    <p class="auth-subtitle">Ton espace te permet de suivre ta progression au quotidien.</p>

    <div class="auth-card">

      <?php if (!empty($err)): ?>
        <div class="auth-alert">
          <?= htmlspecialchars($err) ?>
        </div>
      <?php endif; ?>

      <form id="signupForm" class="auth-form" novalidate>

          <div class="field">
              <label for="nom">Nom</label>
              <input id="nom" type="text" name="nom">
              <p class="field-error-msg" id="err-nom"></p>
          </div>

          <div class="field">
              <label for="prenom">Prénom</label>
              <input id="prenom" type="text" name="prenom">
              <p class="field-error-msg" id="err-prenom"></p>
          </div>

          <div class="field">
              <label for="adr">Adresse</label>
              <input id="adr" type="text" name="adr">
          </div>

          <div class="field">
              <label for="num">Téléphone</label>
              <input id="num" type="text" name="num">
          </div>

          <div class="field">
              <label for="mail">Email</label>
              <input id="mail" type="email" name="mail">
              <p class="field-error-msg" id="err-mail"></p>
          </div>

          <div class="field">
              <label for="pswrd1">Mot de passe</label>
              <div class="password-wrap">
                  <input id="pswrd1" type="password" name="pswrd1">
                  <button type="button" class="show-pass">👁️</button>
              </div>
              <p class="field-error-msg" id="err-pswrd1"></p>
          </div>

          <div class="field">
              <label for="pswrd2">Confirmer le mot de passe</label>
              <input id="pswrd2" type="password" name="pswrd2">
              <p class="field-error-msg" id="err-pswrd2"></p>
          </div>

          <button type="submit" class="btn btn-primary auth-submit">
              S’inscrire
          </button>

          <p id="signupFeedback" style="margin-top:10px; font-weight:600;"></p>

      </form>


      <p class="auth-small">
        Déjà un compte ? <a href="seconnecter.php" class="link">Connecte-toi</a>
      </p>

    </div>
  </div>
</main>

<script>
// ==========================
// Sélecteurs
// ==========================
const nom = document.querySelector('#nom');
const prenom = document.querySelector('#prenom');
const adr = document.querySelector('#adr');
const num = document.querySelector('#num');
const mail = document.querySelector('#mail');
const pass1 = document.querySelector('#pswrd1');
const pass2 = document.querySelector('#pswrd2');

const errNom = document.querySelector('#err-nom');
const errPrenom = document.querySelector('#err-prenom');
const errMail = document.querySelector('#err-mail');
const errPass1 = document.querySelector('#err-pswrd1');
const errPass2 = document.querySelector('#err-pswrd2');

const feedback = document.querySelector('#signupFeedback');


// ==========================
// VALIDATION NOM & PRÉNOM
// ==========================
const nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s-]{2,}$/;

nom.addEventListener('input', () => {
    if (!nameRegex.test(nom.value.trim())) {
        nom.classList.add('input-error');
        errNom.textContent = "Nom invalide (lettres uniquement, min 2).";
    } else {
        nom.classList.remove('input-error');
        errNom.textContent = "";
    }
});

prenom.addEventListener('input', () => {
    if (!nameRegex.test(prenom.value.trim())) {
        prenom.classList.add('input-error');
        errPrenom.textContent = "Prénom invalide (lettres uniquement, min 2).";
    } else {
        prenom.classList.remove('input-error');
        errPrenom.textContent = "";
    }
});


// ==========================
// VALIDATION ADRESSE
// ==========================
adr.addEventListener('input', () => {
    const reg = /^(?=.*[A-Za-z])(?=.*\d).{5,}$/;

    if (!reg.test(adr.value.trim())) {
        adr.classList.add('input-error');
        if (!adr.nextElementSibling || !adr.nextElementSibling.classList.contains("field-error-msg-created")) {
            const p = document.createElement("p");
            p.textContent = "Adresse invalide (doit contenir chiffres + lettres).";
            p.classList.add("field-error-msg", "field-error-msg-created");
            adr.insertAdjacentElement("afterend", p);
        }
    } else {
        adr.classList.remove('input-error');
        if (adr.nextElementSibling && adr.nextElementSibling.classList.contains("field-error-msg-created")) {
            adr.nextElementSibling.remove();
        }
    }
});


// ==========================
// VALIDATION TÉLÉPHONE 10 CHIFFRES
// ==========================
num.addEventListener('input', () => {
    const regex = /^0[0-9]{9}$/;

    if (!regex.test(num.value.trim())) {
        num.classList.add('input-error');
        if (!num.nextElementSibling || !num.nextElementSibling.classList.contains("field-error-msg-created")) {
            const p = document.createElement("p");
            p.textContent = "Numéro invalide (doit commencer par 0 et faire 10 chiffres).";
            p.classList.add("field-error-msg", "field-error-msg-created");
            num.insertAdjacentElement("afterend", p);
        }
    } else {
        num.classList.remove('input-error');
        if (num.nextElementSibling && num.nextElementSibling.classList.contains("field-error-msg-created")) {
            num.nextElementSibling.remove();
        }
    }
});



// ==========================
// VALIDATION EMAIL
// ==========================
mail.addEventListener('input', () => {
    const regex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

    if (!regex.test(mail.value.trim())) {
        mail.classList.add('input-error');
        errMail.textContent = "Email invalide.";
    } else {
        mail.classList.remove('input-error');
        errMail.textContent = "";
    }
});



// ==========================
// MOT DE PASSE (min 6, 1 maj, 1 chiffre)
// ==========================
pass1.addEventListener('input', () => {
    const regex = /^(?=.*[A-Z])(?=.*\d).{6,}$/;

    if (!regex.test(pass1.value.trim())) {
        pass1.classList.add('input-error');
        errPass1.textContent = "Min 6 caractères, 1 majuscule, 1 chiffre.";
    } else {
        pass1.classList.remove('input-error');
        errPass1.textContent = "";
    }

    // update confirmation
    if (pass2.value !== "" && pass2.value !== pass1.value) {
        pass2.classList.add('input-error');
        errPass2.textContent = "Les mots de passe ne correspondent pas.";
    } else {
        pass2.classList.remove('input-error');
        errPass2.textContent = "";
    }
});


// ==========================
// CONFIRMATION MDP
// ==========================
pass2.addEventListener('input', () => {
    if (pass2.value !== pass1.value) {
        pass2.classList.add('input-error');
        errPass2.textContent = "Les mots de passe ne correspondent pas.";
    } else {
        pass2.classList.remove('input-error');
        errPass2.textContent = "";
    }
});


// ==========================
// SHOW / HIDE PASS
// ==========================
document.querySelector('.show-pass').addEventListener('click', () => {
    pass1.type = pass1.type === "password" ? "text" : "password";
});


// ==========================
// AJAX — INSCRIPTION
// ==========================
document.querySelector('#signupForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = document.querySelector('#signupForm');
    const btn = document.querySelector('.auth-submit');

    // Check final
    if (
        nom.classList.contains('input-error') ||
        prenom.classList.contains('input-error') ||
        mail.classList.contains('input-error') ||
        pass1.classList.contains('input-error') ||
        pass2.classList.contains('input-error') ||
        nom.value.trim() === "" ||
        prenom.value.trim() === "" ||
        mail.value.trim() === "" ||
        pass1.value.trim() === "" ||
        pass2.value.trim() === ""
    ) {
        feedback.style.color = "#dc2626";
        feedback.textContent = "Corrige les erreurs avant de continuer";
        form.classList.add("shake");
        setTimeout(() => form.classList.remove("shake"), 350);
        return;
    }

    // Loader
    btn.classList.add("btn-loading");

    const data = new FormData(form);

    const res = await fetch("signup_api.php", {
        method: "POST",
        body: data
    });

    const json = await res.json();

    btn.classList.remove("btn-loading");

    if (!json.success) {
        feedback.style.color = "#dc2626";
        feedback.textContent = json.msg;
        form.classList.add("shake");
        setTimeout(() => form.classList.remove("shake"), 350);

    } else {
        feedback.style.color = "#22c55e";
        feedback.textContent = json.msg;

        // redirect avec connexion auto
        setTimeout(() => {
            window.location.href = "accueil.php";
        }, 900);
    }
});
</script>


  <!-- FOOTER SIMPLE -->
<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__left">
      <p class="mini-quote">“Le futur c’est loin, j’attends pas assis”.</p>
    </div>
    <div class="footer__right">
      <div class="legal">© 2025 NAHA — Données : Open Food Facts & Compendium MET</div>
    </div>
  </div>
</footer>

</body>
</html>
