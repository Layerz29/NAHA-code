<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ===== CSRF pour l'AJAX sécurisée ===== */
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

/* ===== Endpoint AJAX pour le feedback ===== */
if (isset($_GET['ajax']) && $_GET['ajax'] === 'feedback') {
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée.']);
        exit;
    }

    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Token CSRF invalide.']);
        exit;
    }

    $message = trim($_POST['message'] ?? '');
    if ($message === '' || mb_strlen($message) > 600) {
        echo json_encode(['ok' => false, 'error' => 'Message vide ou trop long.']);
        exit;
    }

    // Si tu veux, ici tu pourras plus tard enregistrer en BDD
    // en mode INSERT INTO feedback (id_utilisateur, message, created_at) ...
    // pour l’instant on fait juste un retour propre.

    $userName = 'Invité';
    if (!empty($_SESSION['utilisateur']['prenom'])) {
        $userName = $_SESSION['utilisateur']['prenom'];
    }

    echo json_encode([
        'ok' => true,
        'msg' => 'Merci pour ton retour, ' . htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') . ' 🙌'
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NAHA — Le Projet</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

  <!-- Styles globaux + page projet -->
  <link rel="stylesheet" href="accueil-style.css" />
  <link rel="stylesheet" href="projet-style.css" />
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
      <a class="pill is-active" href="projet.php">Le Projet</a>
      <a class="pill" href="consommation.php">Consommation</a>
    </nav>

    <div class="auth">
      <?php if (isset($_SESSION['utilisateur'])): ?>
        <span class="auth-user">
          👤 <?= htmlspecialchars($_SESSION['utilisateur']['prenom'].' '.$_SESSION['utilisateur']['nom'], ENT_QUOTES, 'UTF-8') ?>
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

<main class="projet-page">
  <!-- Hero -->
  <section class="projet-hero">
    <div class="container projet-hero__inner">
      <p class="projet-tag">Le Projet</p>
      <h1 class="projet-title">Le Projet NAHA</h1>
      <p class="projet-subtitle">
        NAHA t’aide à équilibrer <strong>nutrition</strong>, <strong>sport</strong> et <strong>mental</strong>
        pour atteindre tes objectifs — durablement.
      </p>
    </div>
  </section>

  <div class="divider"></div>

  <!-- Vision -->
  <section class="projet-section">
    <div class="container">
      <h2 class="section-title">Notre vision</h2>
      <div class="vision-grid">
        <div class="vision-text">
          <p>
            Chez <strong>NAHA</strong>, on part d’un constat simple :
          </p>
          <ul>
            <li>la plupart des sportifs galèrent à trouver un équilibre entre alimentation, sport et motivation ;</li>
            <li>les applis existantes sont souvent trop compliquées ou pas adaptées à la vraie vie ;</li>
            <li>le suivi des calories est soit trop flou, soit trop extrême.</li>
          </ul>
          <p>
            Notre objectif : te donner un <strong>outil clair, moderne et motivant</strong> pour suivre ton activité, tes apports,
            et mieux comprendre ton corps jour après jour.
          </p>
        </div>

        <div class="vision-card">
          <h3>Ce qu’on veut pour toi</h3>
          <ul>
            <li>Un suivi simple, sans prise de tête.</li>
            <li>Des stats lisibles, pas des murs de chiffres.</li>
            <li>Un équilibre entre performance, santé et kiff.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- Piliers -->
  <section class="projet-section">
    <div class="container">
      <h2 class="section-title">Les piliers de NAHA</h2>
      <div class="pillars-grid">
        <article class="pillar-card">
          <div class="pillar-icon">🥗</div>
          <h3>Analyse ton alimentation</h3>
          <p>
            Une base d’aliments claire pour comprendre ce que tu manges, sans te noyer dans les détails.
          </p>
        </article>

        <article class="pillar-card">
          <div class="pillar-icon">📊</div>
          <h3>Lis tes stats facilement</h3>
          <p>
            Des graphes propres, des tendances, pas de jargon. L’idée c’est que tu comprennes en 5 secondes.
          </p>
        </article>

        <article class="pillar-card">
          <div class="pillar-icon">🔥</div>
          <h3>Garde la motivation</h3>
          <p>
            Un suivi qui valorise la constance, pas la perfection. L’important, c’est le progrès, pas le 0 défaut.
          </p>
        </article>
      </div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- Timeline / Parcours utilisateur -->
  <section class="projet-section">
    <div class="container">
      <h2 class="section-title">Comment NAHA t’accompagne</h2>
      <ol class="steps">
        <li>
          <span class="step-badge">1</span>
          <div>
            <h3>Tu crées ton compte</h3>
            <p>Quelques infos, pas plus. On préfère la simplicité à la fiche d’état civil.</p>
          </div>
        </li>
        <li>
          <span class="step-badge">2</span>
          <div>
            <h3>Tu suis tes journées</h3>
            <p>Aliments, sports, ressenti : tu renseignes ce qui compte pour toi, à ton rythme.</p>
          </div>
        </li>
        <li>
          <span class="step-badge">3</span>
          <div>
            <h3>Tu regardes les tendances</h3>
            <p>Le tableau de bord et le calculateur t’aident à ajuster petit à petit, sans extrêmes.</p>
          </div>
        </li>
      </ol>
    </div>
  </section>

  <div class="divider"></div>

  <!-- Feedback avec formulaire AJAX sécurisé -->
  <section class="projet-section projet-feedback">
    <div class="container">
      <h2 class="section-title">Ton avis compte</h2>
      <p class="feedback-intro">
        Dis-nous en deux mots ce que tu aimerais voir dans NAHA (fonction, graphique, idée…).
        On ne promet pas tout, mais on lit tout. 🤝
      </p>

      <form id="feedback-form" class="feedback-form" autocomplete="off">
        <textarea
          id="feedback-message"
          name="message"
          rows="4"
          maxlength="600"
          placeholder="Exemple : un mode ‘match day’, un suivi de sommeil, des rappels, etc."
          required
        ></textarea>
        <input type="hidden" name="csrf" value="<?=
          htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8');
        ?>">
        <button type="submit" class="btn big feedback-btn">
          Envoyer mon idée
        </button>
      </form>

      <p id="feedback-status" class="feedback-status" aria-live="polite"></p>
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

<script src="projet-script.js" defer></script>
</body>
</html>
