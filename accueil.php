<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NAHA — Accueil</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="accueil-style.css" />
</head>
<body>

<!-- Topbar -->
<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="#top">
      <span class="brand__logo">🍃</span>
      <span class="brand__text">NAHA</span>
    </a>

    <nav class="menu">
      <a class="pill is-active" href="#top">Accueil</a>
      <a class="pill" href="tableau.php">Tableau de bord</a>
      <a class="pill" href="calculateur.php">Calculateur</a>
      <a class="pill" href="projet.php">Le Projet</a>
      <a class="pill" href="consommation.php">Consommation</a>
    </nav>

<div class="auth">
  <?php if (isset($_SESSION['utilisateur'])): ?>
    <span class="auth-user">
      👤 <?= htmlspecialchars($_SESSION['utilisateur']['prenom'].' '.$_SESSION['utilisateur']['nom']) ?>
      <span class="auth-tag">Connecté</span>
    </span>
    <a class="btn-ghost" href="deconnexion.php">Déconnexion</a>
  <?php else: ?>
    ...
  <?php endif; ?>
</div>



  </div>
</header>

<main id="top">
  <!-- HERO (parallaxe soft + progress bar) -->
  <section class="hero" data-parallax>
    <div class="container hero__inner" data-animate="fade-up">
      <h1 class="hero__title">NAHA</h1>
      <p class="hero__quote">“Les grands accomplissements sont réussis non par la force, mais par la persévérance.”<br><span>Samuel Johnson</span></p>

      <div class="hero__cta">
        <a class="btn big" href="sinscrire.php">Commencer</a>
        <a class="btn ghost" href="#features">Découvrir</a>
      </div>
    </div>
    <div class="scroll-progress"></div>
  </section>

  <div class="divider"></div>

  <!-- NOTRE MISSION -->
  <section class="mission" data-animate="fade-up" id="projet">
    <div class="container">
      <h2 class="title">Notre mission</h2>

      <div class="mission__row" data-animate="fade-right">
        <div class="mission__text">
          <p>
            Chez <strong>NAHA</strong>, on veut aider chaque sportif à mieux se comprendre, à progresser jour après jour et à garder la motivation.<br>
            Nos outils statistiques sont faits pour t’accompagner, simplement, dans ton évolution.
          </p>
          <ul class="ticks">
            <li>Suivi clair de tes séances</li>
            <li>Visualisations utiles et simples</li>
            <li>Conseils actionnables chaque semaine</li>
          </ul>
        </div>

        <div class="mission__art" data-animate="fade-left">
          <div class="chart-card">
            <canvas id="chart-perf" height="160" data-lazy-chart="bar"></canvas>
          </div>
          <div class="chart-row">
            <div class="chart-card small">
              <canvas id="chart-gauge" height="110" data-lazy-chart="gauge"></canvas>
            </div>
            <div class="chart-card small">
              <canvas id="chart-mini" height="110" data-lazy-chart="mini"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="mission__row mission__row--alt" data-animate="fade-up">
        <div class="mission__art">
          <div class="chart-card soft">
            <canvas id="chart-green" height="130" data-lazy-chart="area"></canvas>
          </div>
        </div>

        <div class="mission__quote">
          <p>“Chaque calorie compte, chaque effort te rapproche de ta meilleure version.<br>
            La donnée, c’est notre langage — la persévérance, notre philosophie.”</p>
        </div>
      </div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- KPIs (compteurs animés) -->
  <section class="kpis" id="dash" data-animate="fade-up">
    <div class="container kpis__grid">
      <div class="kpi">
        <div class="kpi__num" data-counter="1250">0</div>
        <div class="kpi__label">Séances suivies</div>
      </div>
      <div class="kpi">
        <div class="kpi__num" data-counter="87">0</div>
        <div class="kpi__label">Programmes actifs</div>
      </div>
      <div class="kpi">
        <div class="kpi__num" data-counter="98">0</div>
        <div class="kpi__label">Satisfaction (%)</div>
      </div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- FEATURES -->
  <section class="features" id="features" data-animate="fade-up">
    <div class="container">
      <h3 class="features__title">Découvrez notre calculateur performant et<br>des entraînements personnalisés</h3>

      <div class="features__grid">
        <a class="cta" href="#calc">Calculateur</a>
        <a class="cta cta--right" href="#contact">Contactez nous !</a>
        <a class="cta" href="#dash">Tableau de bord</a>
        <a class="cta cta--right" href="#train">Entraînement</a>
      </div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- Newsletter AJAX soft -->
  <section class="newsletter" id="contact" data-animate="fade-up">
    <div class="container newsletter__card">
      <h3>Reste dans le flow 📈</h3>
      <p>Reçois 1 tip data & perf par semaine. Pas de spam, juré.</p>
      <form id="news-form" class="news-form" action="api/newsletter.php" method="post">
        <input type="email" name="email" placeholder="tonemail@exemple.com" required>
        <button class="btn" type="submit">S’abonner</button>
      </form>
      <div id="news-msg" class="news-msg" role="status" aria-live="polite"></div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- EQUIPE -->
  <section class="team" id="team" data-animate="fade-up">
    <div class="container">
      <h2 class="title title--spaced">DÉCOUVREZ&nbsp;&nbsp;NOTRE ÉQUIPE</h2>
      <div class="team__list">
        <span data-animate="pop">Haitham</span><span data-animate="pop">Ahmed</span><span data-animate="pop">Noah</span><span data-animate="pop">Arthur</span>
      </div>
    </div>
  </section>

  <!-- Back to top -->
  <button class="to-top" aria-label="Remonter">↑</button>
</main>

<!-- FOOTER -->
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
<script src="accueil-script.js"></script>
</body>
</html>
