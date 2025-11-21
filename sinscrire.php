
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

      <form action="inscription.php" method="post" class="auth-form">

        <div class="field">
          <label for="nom">Nom</label>
          <input id="nom" type="text" name="n" value="<?= htmlspecialchars($nom) ?>" required>
        </div>

        <div class="field">
          <label for="prenom">Prénom</label>
          <input id="prenom" type="text" name="p" value="<?= htmlspecialchars($prenom) ?>" required>
        </div>

        <div class="field">
          <label for="adr">Adresse</label>
          <input id="adr" type="text" name="adr" value="<?= htmlspecialchars($adr) ?>">
        </div>

        <div class="field">
          <label for="num">Téléphone</label>
          <input id="num" type="text" name="num" value="<?= htmlspecialchars($num) ?>">
        </div>

        <div class="field">
          <label for="mail">Email</label>
          <input id="mail" type="email" name="mail" value="<?= htmlspecialchars($mail) ?>" required>
        </div>

        <div class="field">
          <label for="pswrd1">Mot de passe</label>
          <div class="password-wrap">
            <input id="pswrd1" type="password" name="pswrd1" required>
            <button class="show-pass" type="button">👁️</button>
          </div>
        </div>

        <div class="field">
          <label for="pswrd2">Confirmer le mot de passe</label>
          <input id="pswrd2" type="password" name="pswrd2" required>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">S’inscrire</button>

      </form>

      <p class="auth-small">
        Déjà un compte ? <a href="seconnecter.php" class="link">Connecte-toi</a>
      </p>

    </div>
  </div>
</main>


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
