
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

  <!-- Style en plus pour le formulaire (si tu veux) -->
  <link rel="stylesheet" href="auth-style.css?v=<?php echo time(); ?>">
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
      <a class="pill" href="#calc">Calculateur</a>
      <a class="pill" href="#projet">Le Projet</a>
      <a class="pill" href="#conso">Consommation</a>
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
        <a class="btn" href="sinscrire.php">S’inscrire</a>
      <?php endif; ?>
    </div>

</header>

  <!-- CONTENU PRINCIPAL -->
  <main class="page">
    <section class="hero">
      <div class="hero-text">
        <h1>Rejoins la team NAHA</h1>
        <p>Inscris-toi pour suivre ta progression et atteindre tes objectifs.</p>
      </div>

      <div class="auth-card">
        <h2>Créer un compte</h2>

        <?php if (!empty($err)): ?>
          <p class="error-msg"><?= htmlspecialchars($err) ?></p>
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
            <input id="pswrd1" type="password" name="pswrd1" required>
          </div>

          <div class="field">
            <label for="pswrd2">Confirmer le mot de passe</label>
            <input id="pswrd2" type="password" name="pswrd2" required>
          </div>

          <button type="submit" class="btn btn-primary btn-full">S'inscrire</button>

          <p class="switch-auth">
            Déjà un compte ?
            <a href="seconnecter.php">Se connecter</a>
          </p>
        </form>
      </div>
    </section>
  </main>

  <!-- FOOTER SIMPLE -->
  <footer class="footer">
    <p>© 2025 NAHA — Données : Open Food Facts & Compendium MET</p>
  </footer>

</body>
</html>
