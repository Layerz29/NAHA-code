<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'bdd.php';
$bdd = getBD();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: seconnecter.php');
    exit;
}

/* ================== AJAX ================== */
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json; charset=utf-8');
    $action = $_GET['ajax'];

    // --- Produits ---
    if ($action === 'produits') {
        $sql = "SELECT id_produit, nom_produit, energie_kcal
                FROM produits
                ORDER BY nom_produit";
        echo json_encode($bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // --- Sports ---
    if ($action === 'sports') {
        $sql = "SELECT id_sport, nom_sport, MET, kcal_h_70kg
                FROM sports
                ORDER BY nom_sport";
        echo json_encode($bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // --- Log conso + sport ---
    if ($action === 'log') {
        $idUser    = (int) $_SESSION['utilisateur']['id_utilisateur'];
        $idProduit = $_POST['id_produit'] ?? null;
        $quantite  = $_POST['quantite'] ?? null;
        $idSport   = $_POST['id_sport'] ?? null;
        $duree     = $_POST['duree'] ?? null;

        try {
            $bdd->beginTransaction();

            if ($idProduit && $quantite > 0) {
                $sql = "INSERT INTO consommation (id_utilisateur, id_produit, quantite, date_conso)
                        VALUES (:u, :p, :q, NOW())";
                $st  = $bdd->prepare($sql);
                $st->execute([
                    'u' => $idUser,
                    'p' => $idProduit,
                    'q' => $quantite
                ]);
            }

            if ($idSport && $duree > 0) {
                $sql = "INSERT INTO activite (id_utilisateur, id_sport, date_sport, duree_minutes)
                        VALUES (:u, :s, NOW(), :d)";
                $st  = $bdd->prepare($sql);
                $st->execute([
                    'u' => $idUser,
                    's' => $idSport,
                    'd' => $duree
                ]);
            }

            $bdd->commit();
            echo json_encode(['ok' => true]);
        } catch (Exception $e) {
            $bdd->rollBack();
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'unknown action']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NAHA — Consommation</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="accueil-style.css">
  <link rel="stylesheet" href="consommation-style.css">
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
      <a class="pill" href="calculateur.php">Calculateur</a>
      <a class="pill" href="projet.php">Le Projet</a>
      <a class="pill is-active" href="consommation.php">Consommation</a>
      <a class="pill" href="contact.php">Contact</a>
    </nav>

    <div class="auth">
      <span class="auth-user">
        👤 <?= htmlspecialchars($_SESSION['utilisateur']['prenom']." ".$_SESSION['utilisateur']['nom'], ENT_QUOTES, 'UTF-8') ?>
        <span class="auth-tag">CONNECTÉ</span>
      </span>
      <a class="btn-ghost" href="deconnexion.php">Déconnexion</a>
    </div>
  </div>
</header>

<main class="page-cons">
  <!-- Hero -->
  <section class="cons-hero">
    <div class="container">
      <h1 class="cons-title">Mon journal nutrition & sport</h1>
      <p class="cons-sub">
        Ajoute rapidement tes repas et tes séances. NAHA enregistre tout
        et met à jour ton tableau de bord automatiquement.
      </p>
    </div>
  </section>

  <!-- Carte principale -->
  <section class="cons-main">
    <div class="container cons-container">
      <div class="cons-card">

        <h2>Journal rapide</h2>
        <p class="cons-intro">
          Choisis un aliment et/ou une activité, indique la quantité ou la durée,
          puis clique sur <strong>« Enregistrer dans ma journée »</strong>.
        </p>

        <!-- PRODUIT -->
        <div class="subcard">
          <div class="subcard-header">
            <h3>Produit</h3>
            <span class="subtag">Calories ingérées</span>
          </div>

          <div class="field">
            <label for="prod-select">Aliment</label>
            <select id="prod-select">
              <option value="">Chargement...</option>
            </select>
          </div>

          <div class="field">
            <label for="prod-qte">Quantité (g)</label>
            <input type="number" id="prod-qte" value="100" min="0" step="10">
          </div>

          <p class="mini">
            ≈ <span id="prod-kcal">0</span> kcal
          </p>
        </div>

        <!-- SPORT -->
        <div class="subcard">
          <div class="subcard-header">
            <h3>Sport</h3>
            <span class="subtag subtag--blue">Calories dépensées</span>
          </div>

          <div class="field">
            <label for="sport-select">Sport / activité</label>
            <select id="sport-select">
              <option value="">Chargement...</option>
            </select>
          </div>

          <div class="field">
            <label for="sport-duree">Durée (minutes)</label>
            <input type="number" id="sport-duree" value="60" min="0" step="5">
          </div>

          <p class="mini">
            ≈ <span id="sport-kcal">0</span> kcal dépensées
          </p>
        </div>

        <button id="btn-log" class="btn big full">
          Enregistrer dans ma journée
        </button>
        <p id="log-msg" class="log-msg"></p>



      </div>
    </div>
  </section>

  <!-- Étapes + CTA vers tableau -->
  <section class="cons-steps">
    <div class="container">

      <h2 class="steps-title">Ce que NAHA fait pour toi</h2>
      <p class="steps-sub">
        Chaque action que tu ajoutes ici met ton tableau de bord à jour automatiquement.
      </p>

      <div class="steps-grid">

        <div class="step-item">
          <span class="step-num">1</span>
          <h3>J’ajoute mes aliments</h3>
          <p>NAHA calcule les calories ingérées en temps réel à partir de la quantité renseignée.</p>
        </div>

        <div class="step-item">
          <span class="step-num">2</span>
          <h3>Je renseigne mon activité</h3>
          <p>Les dépenses caloriques sont ajoutées à ta journée selon ton sport et ta durée.</p>
        </div>

        <div class="step-item">
          <span class="step-num">3</span>
          <h3>Mon suivi est mis à jour</h3>
          <p>Solde calorique, progrès, graphiques : ton tableau de bord se met à jour automatiquement.</p>
        </div>

      </div>

      <div class="steps-cta">
        <a href="tableau.php" class="btn steps-btn">Voir mon tableau de bord</a>
      </div>

    </div>
  </section>
</main>

<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__left">
      <p class="mini-quote">“Le futur c’est loin, j’attends pas assis”.</p>
    </div>
    <div class="footer__right">
      <div class="legal">© 2025 NAHA — Données : Open Food Facts &amp; Compendium MET</div>
    </div>
  </div>
</footer>

<script src="consommation-script.js"></script>
</body>
</html>
