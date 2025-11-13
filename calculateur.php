<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bdd.php';
$bdd = getBD();

/* ================== AJAX ================== */
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json; charset=utf-8');
    $action = $_GET['ajax'];

    // --- liste des produits ---
    if ($action === 'produits') {
        $sql = "SELECT id_produit, nom_produit, energie_kcal
                FROM produits
                ORDER BY nom_produit";
        $stmt = $bdd->query($sql);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // --- liste des sports ---
    if ($action === 'sports') {
        $sql = "SELECT id_sport, nom_sport, MET, kcal_h_70kg
                FROM sports
                ORDER BY nom_sport";
        $stmt = $bdd->query($sql);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // --- enregistrement conso + sport ---
    if ($action === 'log') {
        if (!isset($_SESSION['utilisateur'])) {
            echo json_encode(['ok' => false, 'error' => 'not_logged']);
            exit;
        }

        $idUser    = (int) $_SESSION['utilisateur']['id_utilisateur'];
        $idProduit = !empty($_POST['id_produit']) ? (int) $_POST['id_produit'] : null;
        $quantite  = !empty($_POST['quantite'])   ? (int) $_POST['quantite']   : null;
        $idSport   = !empty($_POST['id_sport'])   ? (int) $_POST['id_sport']   : null;
        $duree     = !empty($_POST['duree'])      ? (int) $_POST['duree']      : null;

        try {
            $bdd->beginTransaction();

            // conso
            if ($idProduit && $quantite > 0) {
                $sqlC = "INSERT INTO consommation (id_utilisateur, id_produit, quantite, date_conso)
                         VALUES (:u, :p, :q, NOW())";
                $stC = $bdd->prepare($sqlC);
                $stC->execute([
                    'u' => $idUser,
                    'p' => $idProduit,
                    'q' => $quantite
                ]);
            }

            // sport
            if ($idSport && $duree > 0) {
                $sqlS = "INSERT INTO activite (id_utilisateur, id_sport, date_sport, duree_minutes)
                         VALUES (:u, :s, NOW(), :d)";
                $stS = $bdd->prepare($sqlS);
                $stS->execute([
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

    echo json_encode(['error' => 'action inconnue']);
    exit;
}

// ================== PAGE NORMALE (HTML) ==================

// obligé d’être connecté pour voir la page
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

  <!-- style commun + style calculateur -->
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
      <a class="pill" href="#projet">Le Projet</a>
      <a class="pill" href="consommation.php">Consommation</a>
    </nav>

    <div class="auth">
      <?php if (isset($_SESSION['utilisateur'])): ?>
        <span class="auth-user">
          👤 <?=
            htmlspecialchars(
              $_SESSION['utilisateur']['prenom'].' '.$_SESSION['utilisateur']['nom'],
              ENT_QUOTES,
              'UTF-8'
            )
          ?>
          <span class="auth-tag">Connecté</span>
        </span>
        <a class="btn-ghost" href="deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a class="link" href="seconnecter.php">Se connecter</a>
        <a class="btn" href="sinscrire.php">S’inscrire</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="page calc-page">
  <section class="calc-hero">
    <div class="container calc-grid">

      <!-- Bloc calcul besoins -->
      <section class="card big">
        <h1>Ton calculateur personnalisé</h1>
        <p class="sub">
          Découvre combien ton corps dépense chaque jour, puis ajoute tes aliments et tes sports.
        </p>

        <form id="calc-form" class="calc-form">
          <div class="form-grid">
            <div class="field">
              <label for="age">Âge (années)</label>
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
                <option value="1.2">Sédentaire</option>
                <option value="1.375">Léger (1–3 séances / semaine)</option>
                <option value="1.55" selected>Modéré (3–5 séances / semaine)</option>
                <option value="1.725">Intense (6–7 séances / semaine)</option>
                <option value="1.9">Très intense (2x / jour)</option>
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
            Maintenance estimée : <span id="res-kcal">–</span> kcal / jour
          </p>
          <p id="res-text" class="res-text">
            Renseigne tes infos puis lance le calcul pour voir ta maintenance.
          </p>
        </div>
      </section>

      <!-- Bloc produits + sport -->
      <section class="card side">
        <h2>Journal rapide</h2>

        <!-- produit -->
        <div class="subcard">
          <h3>Produit de la base</h3>
          <div class="field">
            <label for="prod-select">Aliment</label>
            <select id="prod-select">
              <option value="">Chargement...</option>
            </select>
          </div>
          <div class="field">
            <label for="prod-qte">Quantité (g)</label>
            <input type="number" id="prod-qte" min="0" step="10" value="100" />
          </div>
          <p class="mini">
            ≈ <span id="prod-kcal">0</span> kcal.
          </p>
        </div>

        <!-- sport -->
        <div class="subcard">
          <h3>Sports de la base</h3>
          <p>Choisis une activité pour estimer les calories dépensées.</p>

          <div class="field">
            <label for="sport-select">Sport / activité</label>
            <select id="sport-select">
              <option value="">Chargement...</option>
            </select>
          </div>

          <div class="field">
            <label for="sport-duree">Durée (minutes)</label>
            <input type="number" id="sport-duree" min="0" step="5" value="60" />
          </div>

          <p class="mini">
            ≈ <span id="sport-kcal">0</span> kcal dépensées.
          </p>
        </div>

        <button id="btn-log" type="button" class="btn big full">
          Enregistrer dans ma journée
        </button>
        <p id="log-msg" class="log-msg"></p>
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
