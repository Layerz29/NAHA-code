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
      <a class="pill" href="contact.php">Contact</a>
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
            <p class="vision-intro">
                NAHA répond à des besoins très concrets : mieux se repérer dans sa consommation,
                comprendre ses dépenses énergétiques et garder la motivation sur le long terme.
            </p>

            <div class="vision-cards">
                <article class="vision-card">
                    <h3 class="vision-title">Besoins &amp; problèmes</h3>
                    <p class="vision-caption">
                        À quel(s) besoin(s) ou problème(s) rencontrés par les usagers notre solution répond ?
                    </p>
                    <p>
                        Aujourd’hui, la santé est impactée par plusieurs facteurs dont la nutrition et le sport.
                        Beaucoup d’utilisateurs n’ont pas de repères sur leurs consommations caloriques
                        et leurs dépenses journalières. NAHA vient poser un cadre clair et lisible.
                    </p>
                </article>

                <article class="vision-card">
                    <h3 class="vision-title">Usagers</h3>
                    <p class="vision-caption">
                        Quels sont les différents usagers que notre solution va cibler ?
                    </p>
                    <p>
                        Le projet s’adresse à des personnes qui veulent se remettre au sport, à des sportifs
                        aguerris avec des objectifs personnels, mais aussi à celles et ceux qui cherchent
                        des conseils de bien-être et des outils simples pour améliorer leur quotidien.
                    </p>
                </article>

                <article class="vision-card">
                    <h3 class="vision-title">Solutions existantes</h3>
                    <p class="vision-caption">
                        Qu’est-ce qui existe aujourd’hui et en quoi NAHA est différent ?
                    </p>
                    <p>
                        Se documenter reste la solution la plus pertinente, mais c’est long, technique
                        et souvent décourageant. Tout retenir est quasi impossible, et garder seulement
                        l’essentiel demande de l’expérience. NAHA rend ces informations
                        <strong>accessibles et actionnables pour tous</strong>, peu importe le niveau de pratique.
                    </p>
                </article>
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

    <!-- Parcours utilisateur en cartes -->
    <section class="projet-section">
        <div class="container">
            <h2 class="section-title">Comment NAHA t’accompagne</h2>
            <p class="steps-intro">
                L’idée est simple : tu crées ton espace, tu suis ce que tu fais, et tu lis les tendances
                pour ajuster tranquillement ton mode de vie.
            </p>

            <div class="steps-cards">
                <article class="step-card">
                    <div class="step-chip">1</div>
                    <h3 class="step-title">Tu crées ton compte</h3>
                    <p class="step-text">
                        Quelques infos, pas plus. On préfère la simplicité à la fiche d’état civil.
                    </p>
                </article>

                <article class="step-card">
                    <div class="step-chip">2</div>
                    <h3 class="step-title">Tu suis tes journées</h3>
                    <p class="step-text">
                        Aliments, sports, ressenti : tu renseignes ce qui compte pour toi, à ton rythme.
                    </p>
                </article>

                <article class="step-card">
                    <div class="step-chip">3</div>
                    <h3 class="step-title">Tu regardes les tendances</h3>
                    <p class="step-text">
                        Le tableau de bord et le calculateur t’aident à ajuster petit à petit, sans extrêmes.
                    </p>
                </article>
            </div>
        </div>
    </section>


    <div class="divider"></div>

    <!-- 🔥 Nouvelle section : Notre équipe -->
    <section class="projet-section team-section">
        <div class="container">
            <h2 class="section-title">Notre équipe</h2>
            <p class="team-intro">
                NAHA, c’est un projet construit par une petite équipe de passionnés de sport, de data et de web.
            </p>

            <div class="team-grid">
                <article class="team-card">
                    <div class="team-avatar">
                        <!-- Plus tard tu pourras mettre : <img src="images/arthur.jpg" alt="Photo de Arthur Feschet"> -->
                        <span class="team-initials">AF</span>
                    </div>
                    <h3>Arthur Feschet</h3>
                    <p class="team-role">Développement & architecture</p>
                </article>

                <article class="team-card">
                    <div class="team-avatar">
                        <!-- <img src="images/noah.jpg" alt="Photo de Noah Chayrigues"> -->
                        <span class="team-initials">NC</span>
                    </div>
                    <h3>Noah Chayrigues</h3>
                    <p class="team-role">Produit, data & expérience utilisateur</p>
                </article>

                <article class="team-card">
                    <div class="team-avatar">
                        <!-- <img src="images/ahmed.jpg" alt="Photo de Ahmed Bekakria"> -->
                        <span class="team-initials">AB</span>
                    </div>
                    <h3>Ahmed Bekakria</h3>
                    <p class="team-role">Back-end & base de données</p>
                </article>

                <article class="team-card">
                    <div class="team-avatar">
                        <!-- <img src="images/haitham.jpg" alt="Photo de Haitham Alfakhry"> -->
                        <span class="team-initials">HA</span>
                    </div>
                    <h3>Haitham Alfakhry</h3>
                    <p class="team-role">Front-end & intégration</p>
                </article>
            </div>
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
                <label for="feedback-message"></label><textarea
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