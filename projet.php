<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NAHA — Le Projet</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="container">
  <header class="bar">
    <div>Le Projet NAHA</div>
    <nav>
      <a href="accueil.php">Accueil</a> |
      <a href="seconnecter.php">Se connecter</a> |
      <a href="sinscrire.php">S’inscrire</a>
    </nav>
  </header>

  <h1>Le Projet</h1>
  <section class="card">
    <p>NAHA est une application web pour suivre la consommation alimentaire et calculer les calories. Front-end: HTML/CSS/JS (Chart.js). Back-end: PHP (PDO). Base de données: MySQL.</p>
    <ul>
      <li>Inscription et connexion (mots de passe hachés)</li>
      <li>Ajout/modification/suppression des consommations</li>
      <li>Tableau de bord avec graphiques</li>
      <li>Calculateur rapide des calories</li>
    </ul>
  </section>
</body>
</html>
