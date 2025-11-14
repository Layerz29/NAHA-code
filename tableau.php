<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'bdd.php';
$bdd = getBD();

// obligé d’être connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: seconnecter.php');
    exit;
}

$idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];

try {
    /* === Calories ingérées aujourd’hui === */
    $sqlIn = "
        SELECT SUM(p.energie_kcal * c.quantite / 100) AS kcal_in
        FROM consommation c
        JOIN produits p ON p.id_produit = c.id_produit
        WHERE c.id_utilisateur = :u
          AND DATE(c.date_conso) = CURDATE()
    ";
    $stmtIn = $bdd->prepare($sqlIn);
    $stmtIn->execute(['u' => $idUser]);
    $kcalIn = (int)($stmtIn->fetchColumn() ?: 0);

    /* === Calories dépensées aujourd’hui ===
       -> on utilise sports.kcal_h_70kg * (duree_minutes/60)
    */
    $sqlOut = "
        SELECT SUM(s.kcal_h_70kg * (a.duree_minutes / 60)) AS kcal_out
        FROM activite a
        JOIN sports s ON s.id_sport = a.id_sport
        WHERE a.id_utilisateur = :u
          AND DATE(a.date_sport) = CURDATE()
    ";

    $stmtOut = $bdd->prepare($sqlOut);
    $stmtOut->execute(['u' => $idUser]);
    $kcalOut = (int)($stmtOut->fetchColumn() ?: 0);

    $solde = $kcalIn - $kcalOut;

    /* === Dernières activités pour la liste à droite === */
    $sqlLast = "
        SELECT a.date_sport,
               a.duree_minutes AS duree_min,
               s.nom_sport,
               s.kcal_h_70kg * (a.duree_minutes / 60) AS kcal
        FROM activite a
        JOIN sports s ON s.id_sport = a.id_sport
        WHERE a.id_utilisateur = :u
        ORDER BY a.date_sport DESC
        LIMIT 5
    ";

    $stmtLast = $bdd->prepare($sqlLast);
    $stmtLast->execute(['u' => $idUser]);
    $lastActs = $stmtLast->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // TEMPORAIRE pour debug : tu verras le message au lieu d'une page blanche
    die('Erreur SQL : ' . $e->getMessage());
}
?>

<?php /* NAHA — Tableau de bord */ ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NAHA — Tableau de bord</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

  <!-- Ta feuille de style commune (déjà existante) -->
  <link rel="stylesheet" href="accueil-style.css" />
  <!-- Styles spécifiques dashboard -->
  <link rel="stylesheet" href="tableau-style.css" />
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
      <a class="pill is-active" href="tableau.php">Tableau de bord</a>
      <a class="pill" href="calculateur.php">Calculateur</a>
      <a class="pill" href="accueil.php#projet">Le Projet</a>
      <a class="pill" href="consommation.php">Consommation</a>
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
  </div>
</header>

<main class="dash">

  <section class="dash-hero">
    <div class="container">
      <h1 class="dash-title" data-animate="fade-up">Mon suivi journalier</h1>
      <p class="dash-sub" data-animate="fade-up">Un coup d’œil sur tes progrès — nutrition, sport, équilibre</p>

      <div class="kpis" data-animate="fade-up">
        <!-- Ingressées -->
        <article class="kpi">
          <div class="kpi__icon">🔥</div>
          <div class="kpi__title">Calories ingérées</div>
          <div class="kpi__num" data-counter="<?= $kcalIn ?>">0</div>
          <div class="kpi__delta is-up">Aujourd’hui</div>
        </article>

        <!-- Dépensées -->
        <article class="kpi">
          <div class="kpi__icon">🏋️‍♂️</div>
          <div class="kpi__title">Calories dépensées</div>
          <div class="kpi__num" data-counter="<?= $kcalOut ?>">0</div>
          <div class="kpi__delta is-down">Aujourd’hui</div>
        </article>

        <!-- Solde -->
        <article class="kpi">
          <div class="kpi__icon">🧮</div>
          <div class="kpi__title">Solde calorique</div>
          <div class="kpi__num" data-counter="<?= $solde ?>">0</div>
          <div class="kpi__delta <?= $solde >= 0 ? 'is-up' : 'is-down' ?>">
            <?= $solde >= 0 ? '+' : '' ?><?= $solde ?> kcal
          </div>
        </article>
      </div><!-- /kpis -->
    </div><!-- /container -->

    <div class="scroll-progress"></div>
  </section>

  <!-- GRID CHARTS -->
  <section class="dash-grid">
    <div class="container grid">
      <!-- Bar chart -->
      <div class="card" data-animate="fade-up">
        <div class="card__head">
          <h3>Calories / semaine</h3>
          <span class="badge">Derniers 7 jours</span>
        </div>
        <div class="card__body">
          <canvas data-chart="bars-week" height="220"></canvas>
        </div>
      </div>

      <!-- Donut macros -->
      <div class="card" data-animate="fade-up">
        <div class="card__head">
          <h3>Répartition macros</h3>
          <span class="badge">Jour</span>
        </div>
        <div class="card__body donut-wrap">
          <canvas data-chart="donut-macros" height="220"></canvas>
          <ul class="legend">
            <li><span class="dot dot--prot"></span> Protéines</li>
            <li><span class="dot dot--glu"></span> Glucides</li>
            <li><span class="dot dot--lip"></span> Lipides</li>
          </ul>
        </div>
      </div>

      <!-- Line activités -->
      <div class="card" data-animate="fade-up">
        <div class="card__head">
          <h3>Activité cardio (min)</h3>
          <span class="badge">Semaine</span>
        </div>
        <div class="card__body">
          <canvas data-chart="line-cardio" height="220"></canvas>
        </div>
      </div>

      <!-- Liste récente -->
      <div class="card" data-animate="fade-up">
        <div class="card__head">
          <h3>Dernières activités</h3>
          <span class="badge">Auto</span>
        </div>

        <ul class="list">
          <?php if (empty($lastActs)): ?>
            <li>
              <div class="list__left">
                <span class="list__icon">ℹ️</span>
                <div>
                  <div class="list__title">Aucune activité enregistrée</div>
                  <div class="list__sub">Utilise le calculateur pour ajouter un sport ✨</div>
                </div>
              </div>
            </li>
          <?php else: ?>
            <?php foreach ($lastActs as $act): ?>
              <li>
                <div class="list__left">
                  <span class="list__icon">🏃‍♂️</span>
                  <div>
                    <div class="list__title">
                      <?= htmlspecialchars($act['nom_sport'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div class="list__sub">
                      <?= (int)$act['duree_min'] ?> min •
                      <?= (int)round($act['kcal']) ?> kcal
                    </div>
                  </div>
                </div>
                <time>
                  <?= date('d/m H:i', strtotime($act['date_activite'])) ?>
                </time>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="dash-cta" data-animate="fade-up">
    <div class="container cta__inner">
      <div>
        <h3>Garde le flow 🔥</h3>
        <p>Utilise le calculateur, fixe tes objectifs et suis tes progrès chaque semaine.</p>
      </div>
      <a class="btn big" href="consommation.php">Ajouter une conso</a>
    </div>
  </section>

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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script defer src="tableau-script.js"></script>
</body>
</html>
