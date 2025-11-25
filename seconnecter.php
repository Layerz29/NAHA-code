
<?php
session_start();

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="accueil-style.css?v=<?php echo time(); ?>" >
<link rel="stylesheet" href="auth-style.css?v=<?php echo time(); ?>" />

  </head>
  <body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="accueil.php">
            <span class="brand-logo"></span>
            <span class="brand-text">NAHA</span>
        </a>

        <nav class="menu">
            <a class="pill" href="accueil.php">Accueil</a>
            <a class="pill" href="tableau.php">Tableau de bord</a>
            <a class="pill" href="calculateur.php">Calculateur</a>
            <a class="pill" href="projet.php">Le Projet</a>
            <a class="pill" href="consommation.php">Consommation</a>
            <a class="pill" href="contact.php">Contact</a>
        </nav>

        <div class="nav-actions">
            <a href="seconnecter.php" class="btn btn-small btn-ghost active">Se connecter</a>
            <a href="sinscrire.php" class="btn btn-small btn-primary">S’inscrire</a>
        </div>
    </div>
</header>

<main class="auth-container">
  <div class="auth-card">
    <h1 class="auth-title">Connexion</h1>

    <?php if (isset($_GET['err'])): ?>
        <p class="auth-error">
          <?= htmlspecialchars($_GET['err']) ?>
        </p>
    <?php endif; ?>
    <form action="connex.php" method="post" class="auth-form">
    
        <label for="mail" >Adresse e-mail</label>
        <input type="email" name="mail" id="mail" required />

        <label for="mdp" >Mot de passe</label>
        <input type="password" name="mdp" id="mdp" required />

      <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
</form>
  
<p class="auth-alt">
  Pas encore de compte ? <a href="sinscrire.php">Inscrivez-vous</a>
</p>
</div>
</main>
</body>
</html>