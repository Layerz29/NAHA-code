<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bdd.php';

// obligé d’être connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: seconnecter.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NAHA — Calculateur</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="accueil-style.css" />
  <link rel="stylesheet" href="calculateur-style.css" />
</head>
<body>

<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="accueil.php">
      <span class="brand__logo">🍃</span>
      <span class="brand__text">NAHA</span>
    </a>

    <nav class="menu">
      <a class="pill" href="accueil.php">Accueil</a>
      <a class="pill" href="tableau.php">Tableau de bord</a>
      <a class="pill is-active" href="calculateur.php">Calculateur</a>
      <a class="pill" href="projet.php">Le Projet</a>
      <a class="pill" href="consommation.php">Consommation</a>
      <a class="pill" href="contact.php">Contact</a>

    </nav>

    <div class="auth">
      <span class="auth-user">
        👤 <?= htmlspecialchars($_SESSION['utilisateur']['prenom']." ".$_SESSION['utilisateur']['nom']) ?>
        <span class="auth-tag">Connecté</span>
      </span>
      <a class="btn-ghost" href="deconnexion.php">Déconnexion</a>
    </div>
  </div>
</header>

<main class="page calc-page">
  <section class="calc-hero">
    <div class="container calc-grid">

      <section class="card big">
        <h1>Ton calculateur personnalisé</h1>
        <p class="sub">  Découvre combien ton corps dépense chaque jour, puis laisse NAHA t’aider à organiser
            ton alimentation et tes entraînements autour de cet objectif.</p>

        <form id="calc-form" class="calc-form">
          <div class="form-grid">
            <div class="field">
              <label for="age">Âge</label>
              <input type="number" id="age" min="10" max="99" value="20" />
            </div>
            <div class="field">
              <label for="taille">Taille (cm)</label>
              <input type="number" id="taille" min="120" max="230" value="178" />
            </div>
            <div class="field">
              <label for="poids">Poids (kg)</label>
              <input type="number" id="poids" min="30" max="200" value="72" />
            </div>
            <div class="field">
              <label for="activite">Niveau d’activité</label>
              <select id="activite">
                <option value="1.2">Sédentaire activité faible</option>
                <option value="1.375">Léger 1-2 séances/semaines</option>
                <option value="1.55" selected>Modéré 3-4 séances/semaines</option>
                <option value="1.725">Intense 4-6 séances/semaines</option>
                <option value="1.9">Très intense 7 séances/semaines</option>
              </select>
            </div>
          </div>

          <div class="field">
            <span>Sexe</span>
            <input type="hidden" id="sexe" value="H" />
            <div class="segmented">
              <button type="button" class="segmented-btn is-active" data-sexe="H">Homme</button>
              <button type="button" class="segmented-btn" data-sexe="F">Femme</button>
            </div>
          </div>

          <button type="submit" class="btn big">Calculer mes besoins</button>
        </form>

   <div class="result-card">
     <h2>Résultat</h2>
     <p class="res-main">
       Maintenance : <span id="res-kcal">–</span> kcal / jour
     </p>
     <p class="res-text" id="res-text">
         C’est l’énergie que ton corps dépense chaque jour en moyenne, en fonction de ton âge, ton poids, ta taille et ton niveau d’activité.
     </p>

     <div class="goals">
       <button type="button" class="goal-btn is-active" data-delta="0" data-name="Maintien">
         <span class="goal-label">MAINTIEN</span>
         <span class="goal-kcal" id="goal-maintien">–</span>
         <span class="goal-active-text">Objectif actuel</span>

         <span class="goal-sub">Rester au même poids, sans prise ni perte.</span>
       </button>

       <button type="button" class="goal-btn" data-delta="-400" data-name="Perte de poids">
         <span class="goal-label">PERTE DE POIDS</span>
         <span class="goal-kcal" id="goal-perte">–</span>
         <span class="goal-active-text">Objectif actuel</span>

         <span class="goal-sub">Déficit léger, durable (environ -400 kcal / jour).</span>
       </button>

       <button type="button" class="goal-btn" data-delta="300" data-name="Prise de masse">
         <span class="goal-label">PRISE DE MASSE</span>
         <span class="goal-kcal" id="goal-prise">–</span>
         <span class="goal-active-text">Objectif actuel</span>

         <span class="goal-sub">Excédent contrôlé (+300 kcal / jour pour construire du muscle).</span>
       </button>

     </div>
 <button type="button" class="btn small outline" id="save-goal">
   Enregistrer cet objectif sur mon profil
 </button>
 <p class="mini" id="save-goal-msg"></p>

 <div class="next-steps">
   <h3>Et maintenant, on fait quoi ?</h3>
   <p>Choisis la suite pour mettre ces calories en pratique sur NAHA.</p>

   <div class="next-steps__grid">
     <div class="next-step">
       <h4>Suivre mes calories</h4>
       <p>Note ce que tu manges chaque jour et vois si tu respectes ton objectif.</p>
       <a href="consommation.php" class="cta">Ouvrir mon journal alimentaire</a>
     </div>

     <div class="next-step">
       <h4>Voir mon tableau de bord</h4>
       <p>Visualise l’évolution de ton poids, de tes apports et de tes séances.</p>
       <a href="tableau.php" class="cta">Aller au tableau de bord</a>
     </div>

     <div class="next-step">
       <h4>Mes entraînements</h4>
       <p>Accède à nos idées de séances adaptées à ton objectif.</p>
       <a href="entrainements.php" class="cta">Voir les entraînements</a>
     </div>
   </div>
 </div>


      </section>

    </div>
  </section>
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

<script defer src="calculateur-script.js"></script>
</body>
</html>
