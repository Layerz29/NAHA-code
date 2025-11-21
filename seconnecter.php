
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>



  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

  <!-- Styles (on réutilise la même feuille que l’accueil) -->
  <link rel="stylesheet" href="accueil-style.css" />
</head>
<body class="auth-page">

<!-- Topbar (même que accueil) -->
<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="accueil.php">
      <span class="brand__logo">🍃</span>
      <span class="brand__text">NAHA</span>
    </a>

    <nav class="menu">
      <a class="pill" href="accueil.php">Accueil</a>
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
    <a class="link is-active" href="seconnecter.php">Se connecter</a>
    <a class="btn" href="sinscrire.php">S’inscrire</a>
  <?php endif; ?>
</div>

</header>

<main class="auth-main">
  <div class="container">
    <h1 class="auth-title">Connexion à ton espace <span>NAHA</span></h1>
    <p class="auth-subtitle">Rejoins ton tableau de bord et reprends ton suivi sportif.</p>
    <p class="auth-subtitle">Connecte toi pour pouvoir suivre tes données.</p>

    <div class="auth-card">
      <!-- Affichage d’un message d’erreur serveur optionnel -->
      <?php if (!empty($_GET['err'])): ?>
        <div class="auth-alert">
          <?php echo htmlspecialchars($_GET['err'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
      <?php endif; ?>

      <form id="loginForm" class="auth-form" novalidate>
          <div class="field">
            <label for="mail">Email</label>
            <input id="mail" type="email" name="mail" placeholder="tonemail@exemple.com">
            <p id="err-mail" class="field-error-msg"></p>
          </div>

          <div class="field">
            <label for="pswrd">Mot de passe</label>
            <div class="password-wrap">
              <input id="pswrd" type="password" name="pswrd" placeholder="••••••••">
              <button class="show-pass" type="button">👁️</button>
            </div>
            <p id="err-pswrd" class="field-error-msg"></p>
          </div>

          <button class="btn btn-primary auth-submit" type="submit">Se connecter</button>

          <p id="loginFeedback" style="margin-top:10px; font-weight:600;"></p>
      </form>


      <p class="auth-small">Pas de compte ? <a href="sinscrire.php" class="link">Inscris-toi</a></p>
    </div>
  </div>
</main>
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

<script>
// ===== EMAIL LIVE CHECK =====
const email = document.querySelector('#mail');
const errMail = document.querySelector('#err-mail');

email.addEventListener('input', () => {
    let val = email.value;

    // auto-correction
    if (val.endsWith("gmail.") || val.endsWith("outlook.") || val.endsWith("hotmail.")) {
        email.value = val + "com";
        val = email.value;
    }

    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!pattern.test(val)) {
        email.classList.add('input-error');
        errMail.textContent = "Format d’email incorrect";
    } else {
        email.classList.remove('input-error');
        errMail.textContent = "";
    }
});

// ===== PASSWORD LIVE CHECK =====
const pass = document.querySelector('#pswrd');
const errPass = document.querySelector('#err-pswrd');

pass.addEventListener('input', () => {
    if (pass.value.length < 2) {
        pass.classList.add('input-error');
        errPass.textContent = "Mot de passe trop court (min 2 caractères)";
    } else {
        pass.classList.remove('input-error');
        errPass.textContent = "";
    }
});


// ===== SHOW / HIDE PASSWORD =====
document.querySelector('.show-pass').addEventListener('click', () => {
    pass.type = pass.type === "password" ? "text" : "password";
});

// ===== AJAX LOGIN =====
document.querySelector('#loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const feedback = document.querySelector('#loginFeedback');
    const btn = document.querySelector('.auth-submit');
    const form = document.querySelector('#loginForm');

    // blocage si erreur front
    if (email.classList.contains('input-error') ||
        pass.classList.contains('input-error') ||
        email.value.trim() === "" ||
        pass.value.trim() === "")
    {
        feedback.style.color = "#dc2626";  // rouge
        feedback.textContent = "Corrige les erreurs avant de continuer";
        form.classList.add("shake");
        setTimeout(() => form.classList.remove("shake"), 350);
        return;
    }

    // loader
    btn.classList.add("btn-loading");

    const data = new FormData();
    data.append("mail", email.value);
    data.append("pswrd", pass.value);

    const res = await fetch("login_api.php", {
        method: "POST",
        body: data
    });

    const json = await res.json();

    btn.classList.remove("btn-loading");

    if (!json.success) {
        feedback.style.color = "#dc2626";  // 🔴 rouge erreur
        feedback.textContent = json.msg;

        form.classList.add("shake");
        setTimeout(() => form.classList.remove("shake"), 350);
    }
    else {
        feedback.style.color = "#22c55e";  // 🟢 vert succès
        feedback.textContent = json.msg;

        setTimeout(() => {
            window.location.href = json.redirect;
        }, 700);
    }
});

</script>


</body>
</html>
