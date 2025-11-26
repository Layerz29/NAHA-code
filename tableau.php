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

// ID de l'utilisateur connecté c'est arthur qui a changé juste cette ligne
$idUser = (int)($_SESSION['utilisateur']['id'] ?? $_SESSION['utilisateur']['id_utilisateur']);

try {
    /* === Données 7 derniers jours pour les graphes === */
    $weekLabels  = [];
    $weekIn      = [];
    $weekOut     = [];
    $weekCardio  = [];

        // on remonte du J-6 à aujourd'hui
        for ($i = 6; $i >= 0; $i--) {
            $d = new DateTime("-$i days");
            $dateStr = $d->format('Y-m-d');

            // lettre du jour en FR
            $jours = [1=>'L','M','M','J','V','S','D'];
            $label = $jours[(int)$d->format('N')];

            // calories ingérées ce jour-là
            $sqlInDay = "
                SELECT SUM(p.energie_kcal * c.quantite / 100) AS kcal_in
                FROM consommation c
                JOIN produits p ON p.id_produit = c.id_produit
                WHERE c.id_utilisateur = :u
                  AND DATE(c.date_conso) = :d
            ";
            $stmtInDay = $bdd->prepare($sqlInDay);
            $stmtInDay->execute(['u' => $idUser, 'd' => $dateStr]);
            $kIn = (int)($stmtInDay->fetchColumn() ?: 0);

            // calories dépensées ce jour-là
            $sqlOutDay = "
                SELECT SUM(s.kcal_h_70kg * (a.duree_minutes / 60)) AS kcal_out
                FROM activite a
                JOIN sports s ON s.id_sport = a.id_sport
                WHERE a.id_utilisateur = :u
                  AND DATE(a.date_sport) = :d
            ";
            $stmtOutDay = $bdd->prepare($sqlOutDay);
            $stmtOutDay->execute(['u' => $idUser, 'd' => $dateStr]);
            $kOut = (int)($stmtOutDay->fetchColumn() ?: 0);

            // minutes de sport dans la journée
            $sqlCardioDay = "
                SELECT SUM(a.duree_minutes) AS minutes
                FROM activite a
                WHERE a.id_utilisateur = :u
                  AND DATE(a.date_sport) = :d
            ";
            $stmtCardioDay = $bdd->prepare($sqlCardioDay);
            $stmtCardioDay->execute(['u' => $idUser, 'd' => $dateStr]);
            $mCardio = (int)($stmtCardioDay->fetchColumn() ?: 0);

            $weekLabels[] = $label;
            $weekIn[]     = $kIn;
            $weekOut[]    = $kOut;
            $weekCardio[] = $mCardio;
        }

        /* === Bilan de la semaine === */
        $totalIn      = array_sum($weekIn);
        $totalOut     = array_sum($weekOut);
        $soldeSem     = $totalIn - $totalOut;
        $totalMinutes = array_sum($weekCardio);

        $moyenneJour = $totalIn > 0 ? round($totalIn / 7) : 0;
        $nbSeances   = 0;

        foreach ($weekCardio as $min) {
            if ($min > 0) {
                $nbSeances++;
            }
        }


    /* === Objectif calorique de l'utilisateur === */
    $sqlGoal = "
        SELECT *
        FROM objectif_utilisateur
        WHERE id_utilisateur = :id
        ORDER BY date_maj DESC
        LIMIT 1
    ";
    $stmtGoal = $bdd->prepare($sqlGoal);
    $stmtGoal->execute(['id' => $idUser]);
    $goal = $stmtGoal->fetch(PDO::FETCH_ASSOC);



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

    /* === Calories dépensées aujourd’hui === */
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

    /* === Liste des aliments consommés aujourd’hui === */
    $sqlFoods = "
        SELECT p.nom_produit, c.quantite,
               ROUND(p.energie_kcal * c.quantite / 100, 0) AS kcal
        FROM consommation c
        JOIN produits p ON p.id_produit = c.id_produit
        WHERE c.id_utilisateur = :u
          AND DATE(c.date_conso) = CURDATE()
    ";
    $stmtFoods = $bdd->prepare($sqlFoods);
    $stmtFoods->execute(['u' => $idUser]);
    $foodsToday = $stmtFoods->fetchAll(PDO::FETCH_ASSOC);
    /* === Activités du jour === */
    $sqlSportToday = "
        SELECT s.nom_sport,
               a.duree_minutes AS duree_min,
               s.kcal_h_70kg * (a.duree_minutes / 60) AS kcal
        FROM activite a
        JOIN sports s ON s.id_sport = a.id_sport
        WHERE a.id_utilisateur = :u
          AND DATE(a.date_sport) = CURDATE()
    ";
    $stmtSportToday = $bdd->prepare($sqlSportToday);
    $stmtSportToday->execute(['u' => $idUser]);
    $sportsToday = $stmtSportToday->fetchAll(PDO::FETCH_ASSOC);



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
    /* === Répartition macros aujourd’hui (prot / glu / lip) === */
    $sqlMacros = "
        SELECT
          SUM(p.proteines * c.quantite / 100) AS prot,
          SUM(p.glucides * c.quantite / 100)  AS glu,
          SUM(p.lipides  * c.quantite / 100)  AS lip
        FROM consommation c
        JOIN produits p ON p.id_produit = c.id_produit
        WHERE c.id_utilisateur = :u
          AND DATE(c.date_conso) = CURDATE()
    ";
    $stmtMacros = $bdd->prepare($sqlMacros);
    $stmtMacros->execute(['u' => $idUser]);
    $rowMacros = $stmtMacros->fetch(PDO::FETCH_ASSOC) ?: [];

    $macros = [
        'prot' => (float)($rowMacros['prot'] ?? 0),
        'glu'  => (float)($rowMacros['glu']  ?? 0),
        'lip'  => (float)($rowMacros['lip']  ?? 0),
    ];


} catch (PDOException $e) {
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
      <a class="pill" href="accueil.php">Le Projet</a>
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
        <a class="btn" href="sinscrire.php">S’inscrire</a>
      <?php endif; ?>
    </div>
  </div>
</header>
<main class="dash">

  <!-- TITRE + SOUS TEXTE -->
  <h1 class="dash-title">Mon suivi journalier</h1>
  <p class="dash-sub">Un coup d’œil sur tes progrès — nutrition, sport, équilibre</p>

  <!-- CONSEIL DU JOUR -->
  <section class="dash-tip">
    <div class="container">
      <div class="tip-card">
        <h3>Conseil du jour 🍃</h3>
        <p><?= htmlspecialchars($conseilJour ?? "Les bons lipides (huile d'olive, œufs, avocat, saumon) gèrent tes hormones, ton énergie et ta récupération.") ?></p>
      </div>
    </div>
  </section>

  <!-- SECTION KPIS -->
  <section class="dash-hero">

    <div class="container">
      <div class="kpis kpis-3">


        <!-- KPI INGEREES -->
        <div class="kpi flip-card">
          <div class="flip-inner">

            <!-- RECTO -->
            <div class="flip-front">
              <div class="kpi__icon">🔥</div>
              <div class="kpi__title">Calories ingérées</div>
              <div class="kpi__num" data-counter="<?= $kcalIn ?>">0</div>
              <div class="kpi__delta is-up">Aujourd’hui</div>
            </div>

            <!-- VERSO -->
            <div class="flip-back">
              <h4>Aliments du jour</h4>
              <?php if (empty($foodsToday)): ?>
                <p>Aucune consommation aujourd’hui.</p>
              <?php else: ?>
                <ul class="flip-list">
                  <?php foreach ($foodsToday as $f): ?>
                    <li>
                      <strong><?= htmlspecialchars($f['nom_produit']) ?></strong>
                      — <?= $f['quantite'] ?> g (<?= $f['kcal'] ?> kcal)
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>

          </div>
        </div>

        <!-- KPI DÉPENSÉES -->
        <div class="kpi flip-card">
          <div class="flip-inner">

            <!-- RECTO -->
            <div class="flip-front">
              <div class="kpi__icon">🏋️‍♂️</div>
              <div class="kpi__title">Calories dépensées</div>
              <div class="kpi__num" data-counter="<?= $kcalOut ?>">0</div>
              <div class="kpi__delta is-down">Aujourd’hui</div>
            </div>

            <!-- VERSO -->
            <div class="flip-back">
              <h4>Activités du jour</h4>
              <?php if (empty($sportsToday)): ?>
                  <p>Aucune activité aujourd’hui.</p>
              <?php else: ?>
                  <ul class="flip-list">
                  <?php foreach ($sportsToday as $act): ?>
                      <li>
                        <strong><?= htmlspecialchars($act['nom_sport']) ?></strong>
                        — <?= (int)$act['duree_min'] ?> min (<?= (int)$act['kcal'] ?> kcal)
                      </li>
                  <?php endforeach; ?>
                  </ul>
              <?php endif; ?>

            </div>

          </div>
        </div>

        <!-- KPI SOLDE -->
        <div class="kpi flip-card">
          <div class="flip-inner">

            <!-- RECTO -->
            <div class="flip-front">
              <div class="kpi__icon">🧮</div>
              <div class="kpi__title">Solde calorique</div>
              <div class="kpi__num" data-counter="<?= $solde ?>">0</div>
              <div class="kpi__delta <?= $solde >= 0 ? 'is-up' : 'is-down' ?>">
                <?= $solde >= 0 ? '+' : '' ?><?= $solde ?> kcal
              </div>
            </div>

            <!-- VERSO -->
            <div class="flip-back">
              <h4>Détails</h4>
              <p>Ingérées : <?= $kcalIn ?> kcal</p>
              <p>Dépensées : <?= $kcalOut ?> kcal</p>

            </div>

          </div>
        </div>

      </div> <!-- FIN .kpis -->
    </div> <!-- FIN .container -->
  </section>

<!-- GRID CHARTS -->
<section class="dash-grid">
  <div class="container grid">

    <?php if (!empty($goal)): ?>
    <div class="card goal-card" data-animate="fade-up">
      <div class="goal-row">
        <div class="goal-left">
          <p class="goal-label">Mon objectif calorique</p>
          <h3 class="goal-type">
            <?= htmlspecialchars($goal['objectif_nom']) ?>
          </h3>
          <p class="goal-text">
            Maintenance estimée :
            <strong><?= (int)$goal['maintenance'] ?> kcal / jour</strong>
          </p>
          <p class="goal-text">
            Dernière mise à jour :
            <?= (new DateTime($goal['date_maj']))->format('d/m/Y') ?>
          </p>
        </div>

        <div class="goal-right">
          <span class="goal-number"><?= (int)$goal['objectif_kcal'] ?></span>
          <span class="goal-unit">kcal / jour</span>
          <a href="calculateur.php" class="goal-link">Modifier dans le calculateur →</a>
        </div>
      </div>
    </div>
    <?php endif; ?>
<!-- 🎯 CARD 2 — OBJECTIF DU JOUR -->
<?php if (!empty($goal)):
    $objectif = (int)$goal['objectif_kcal'];
    $progress = min(200, max(0, round(($kcalIn / $objectif) * 100)));
?>
<div class="card" data-animate="fade-up">
    <div class="card__head">
        <h3>Objectif du jour</h3>
        <span class="badge">Nutrition</span>
    </div>
    <div class="card__body mini-goal">
        <p class="mini-goal-sub">Tu as atteint</p>
        <p class="mini-goal-percent"><?= $progress ?>%</p>

        <p class="mini-goal-sub">
            de ton objectif de <strong><?= $objectif ?> kcal</strong>.
        </p>

        <div class="mini-bar">
            <div class="mini-bar-fill" style="width: <?= $progress ?>%;"></div>
        </div>

        <?php if ($progress < 90): ?>
          <p class="mini-goal-hint">Il te reste encore un peu de marge ✨</p>
        <?php elseif ($progress <= 110): ?>
          <p class="mini-goal-hint">Tu es pile dans la zone, beau taf 💪</p>
        <?php else: ?>
          <p class="mini-goal-hint">Tu as dépassé ton objectif aujourd’hui 😉</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
    <!-- Bar chart -->
    <div class="card" data-animate="fade-up">
      <div class="card__head">
        <h3>Calories / semaine</h3>
        <span class="badge">Derniers 7 jours</span>
      </div>
      <div class="card__body">
        <canvas data-chart="bars-week" height="220"></canvas>
      </div>
   <div class="chart-legend">
        <span><span class="dot legend-out"></span> Ingerées</span>
        <span><span class="dot legend-in"></span> Dépensées</span>
      </div>
    </div>

<!-- 🎯 CARD 1 — DONUT MACROS -->
<div class="card" data-animate="fade-up">
    <div class="card__head">
        <h3>Répartition macros</h3>
        <span class="badge">Jour</span>
    </div>

    <div class="card__body donut-wrap">
        <canvas data-chart="donut-macros" height="220"></canvas>

        <ul class="legend">
          <li><span class="dot dot--prot"></span> Protéine</li>
          <li><span class="dot dot--glu"></span> Glucide</li>
          <li><span class="dot dot--lip"></span> Lipide</li>
        </ul>
    </div>
</div>




<div class="card" data-animate="fade-up">
  <div class="card__head">
    <h3>Bilan de la semaine</h3>
    <span class="badge">7 jours</span>
  </div>

  <div class="card__body bilan-week">
    <ul class="bilan-list">
      <li>
        <span class="bilan-emoji">🔥</span>
        <div>
          <div class="bilan-title">Calories ingérées</div>
          <div class="bilan-num"><?= number_format($totalIn, 0, ',', ' ') ?> kcal</div>
        </div>
      </li>

      <li>
        <span class="bilan-emoji">🏋️‍♂️</span>
        <div>
          <div class="bilan-title">Calories dépensées</div>
          <div class="bilan-num"><?= number_format($totalOut, 0, ',', ' ') ?> kcal</div>
        </div>
      </li>

      <li>
        <span class="bilan-emoji">🧮</span>
        <div>
          <div class="bilan-title">Solde total</div>
          <div class="bilan-num <?= $soldeSem >= 0 ? 'green' : 'red' ?>">
            <?= $soldeSem >= 0 ? '+' : '' ?><?= number_format($soldeSem, 0, ',', ' ') ?> kcal
          </div>
        </div>
      </li>

      <li>
        <span class="bilan-emoji">⏱️</span>
        <div>
          <div class="bilan-title">Minutes de sport</div>
          <div class="bilan-num"><?= $totalMinutes ?> min</div>
        </div>
      </li>

      <li>
        <span class="bilan-emoji">📊</span>
        <div>
          <div class="bilan-title">Moyenne / jour</div>
          <div class="bilan-num"><?= number_format($moyenneJour, 0, ',', ' ') ?> kcal</div>
        </div>
      </li>

      <li>
        <span class="bilan-emoji">💪</span>
        <div>
          <div class="bilan-title">Séances</div>
          <div class="bilan-num"><?= $nbSeances ?></div>
        </div>
      </li>
    </ul>
  </div>
</div>

    <!-- Liste des dernières activités -->
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
                  <?= (int)$act['duree_min'] ?> min • <?= (int)round($act['kcal']) ?> kcal
                </div>
              </div>
            </div>

            <?php
              $dt = strtotime($act['date_sport']);
              $heure = date('H:i', $dt);
              $affiche = ($heure === '00:00') ? date('d/m', $dt) : date('d/m H:i', $dt);
            ?>
            <time><?= $affiche ?></time>
          </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>

  </div> <!-- FIN .grid -->
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
      <p class="mini-quote">“Le futur c’est loin, j’attends pas assis”.</p>
    </div>
    <div class="footer__right">
      <div class="legal">© 2025 NAHA — Données : Open Food Facts & Compendium MET</div>
    </div>
  </div>
</footer>

<script>
  window.NAHA_DASH = {
    weekLabels: <?= json_encode($weekLabels ?? []) ?>,
    weekIn:     <?= json_encode($weekIn ?? []) ?>,
    weekOut:    <?= json_encode($weekOut ?? []) ?>,
    weekCardio: <?= json_encode($weekCardio ?? []) ?>,
    macros: {
      prot: <?= json_encode($macros['prot'] ?? 0) ?>,
      glu:  <?= json_encode($macros['glu']  ?? 0) ?>,
      lip:  <?= json_encode($macros['lip']  ?? 0) ?>
    }
  };
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script defer src="tableau-script.js"></script>

</body>
</html>