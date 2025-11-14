<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>



<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NAHA — Connexion</title>

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
      <a class="pill" href="accueil.php#dash">Tableau de bord</a>
      <a class="pill" href="accueil.php#calc">Calculateur</a>
      <a class="pill" href="accueil.php#projet">Le Projet</a>
      <a class="pill" href="accueil.php#conso">Consommation</a>
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

      <form class="auth-form" action="connex.php" method="post" novalidate>
        <div class="field">
          <label for="mail">Email</label>
          <input id="mail" type="email" name="mail" placeholder="tonemail@exemple.com"
                 value="<?php if(isset($_GET['mail'])) echo htmlspecialchars($_GET['mail'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="field">
          <label for="pswrd">Mot de passe</label>
          <div class="password-wrap">
            <input id="pswrd" type="password" name="pswrd" placeholder="••••••••" required>
            <button class="show-pass" type="button" aria-label="Afficher le mot de passe">👁️</button>
          </div>
        </div>

        <button class="btn btn-primary auth-submit" type="submit">Se connecter</button>

        <div class="auth-meta">
          <a href="#" class="link">Mot de passe oublié ?</a>
        </div>
      </form>

      <p class="auth-small">Pas de compte ? <a href="sinscrire.php" class="link">Inscris-toi</a></p>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__left">
      <div class="cols">
        <div class="col">
          <h4>Use cases</h4>
          <a href="#">UI design</a><a href="#">UX design</a><a href="#">Wireframing</a>
          <a href="#">Diagramming</a><a href="#">Brainstorming</a>
          <a href="#">Online whiteboard</a><a href="#">Team collaboration</a>
        </div>
        <div class="col">
          <h4>Explore</h4>
          <a href="#">Design</a><a href="#">Prototyping</a><a href="#">Development features</a>
          <a href="#">Design systems</a><a href="#">Collaboration features</a>
          <a href="#">Design process</a><a href="#">Figma</a>
        </div>
        <div class="col">
          <h4>Resources</h4>
          <a href="#">Blog</a><a href="#">Best practices</a><a href="#">Colors</a>
          <a href="#">Color wheel</a><a href="#">Support</a>
          <a href="#">Developers</a><a href="#">Resource library</a>
        </div>
      </div>
    </div>

    <div class="footer__right">
      <div class="illus"></div>
      <p class="mini-quote">“Le futur c’est loin, j’attends pas assis”.</p>
    </div>
  </div>

  <div class="legal">© 2025 NAHA — Données : Open Food Facts & Compendium MET</div>
</footer>

<script>
  // Afficher/masquer le mot de passe
  document.addEventListener('click', (e) => {
    if (e.target.matches('.show-pass')) {
      const inp = document.querySelector('#pswrd');
      inp.type = inp.type === 'password' ? 'text' : 'password';
    }
  });
</script>
</body>
</html>
