<?php
// ----------------------------------------------------
// Vérification session + chargement BDD
// ----------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "bdd.php";
$bdd = getBD();

// ----------------------------------------------------
// Définition d'un avatar par défaut
// ----------------------------------------------------
$avatar = "assets/img/default-avatar.jpg";
$user = null;

// ----------------------------------------------------
// Si l'utilisateur est connecté → charger ses données
// ----------------------------------------------------
if (isset($_SESSION['utilisateur']['id_utilisateur'])) {

    $req = $bdd->prepare("SELECT nom, prenom, avatar FROM utilisateurs WHERE id_utilisateur=?");
    $req->execute([$_SESSION['utilisateur']['id_utilisateur']]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    // Si avatar existe en BDD → on l'utilise
    if (!empty($user['avatar'])) {
        $avatar = $user['avatar'];
    }
}
?>

<!-- ----------------------------------------------------
     HEADER VISUEL DU SITE NAHA
----------------------------------------------------- -->
<header class="topbar">
    <div class="container topbar__inner">

        <!-- Logo + Nom du site -->
        <a class="brand" href="accueil.php">
            <span class="brand__logo">🍃</span>
            <span class="brand__text">NAHA</span>
        </a>

        <!-- Menu principal -->
        <nav class="menu">
            <a class="pill" href="accueil.php">Accueil</a>
            <a class="pill" href="tableau.php">Tableau de bord</a>
            <a class="pill" href="calculateur.php">Calculateur</a>
            <a class="pill" href="projet.php">Le Projet</a>
            <a class="pill" href="consommation.php">Consommation</a>
            <a class="pill" href="contact.php">Contact</a>

            <?php if ($user): ?>
                <a class="pill" href="profil.php">Mon Profil</a>
            <?php endif; ?>
        </nav>

        <!-- Auth / utilisateur -->
        <div class="auth">

            <?php if ($user): ?>
                
                <!-- Avatar + Prénom + Nom -->
                <span class="auth-user">
                    
                    <img src="<?= htmlspecialchars($avatar) ?>"
                         style="
                            width:32px;
                            height:32px;
                            border-radius:50%;
                            object-fit:cover;
                            vertical-align:middle;
                            margin-right:5px;
                         ">
                    
                    <span class="name-only">
                    <?= htmlspecialchars($user['prenom']." ".$user['nom'], ENT_QUOTES, 'UTF-8') ?>
                   </span>

                    <span class="auth-tag"></span>
                    <div class="dropdown-menu">
                     <a href="profil.php">Mon Profil</a>
                      <a href="parametres.php">Paramètres</a>
                      <a href="deconnexion.php">Déconnexion</a>
                   </div>
                </span>
                

                <!-- Bouton déconnexion -->
                <a class="btn-ghost" href="deconnexion.php">Déconnexion</a>

            <?php else: ?>

                <!-- Si non connecté -->
                <a class="link" href="seconnecter.php">Se connecter</a>
                <a class="btn" href="sinscrire.php">S’inscrire</a>

            <?php endif; ?>

        </div>

    </div>
</header>


<script>
const trigger = document.querySelector(".name-only");
const menu = document.querySelector(".dropdown-menu");

// Ouvrir / fermer avec animation
trigger.addEventListener("click", () => {
    if (menu.classList.contains("show")) {
        menu.classList.remove("show");
        setTimeout(() => menu.style.display = "none", 200);
    } else {
        menu.style.display = "block";
        setTimeout(() => menu.classList.add("show"), 10);
    }
});

// Fermer si clic à l’extérieur
document.addEventListener("click", (e) => {
    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
        if (menu.classList.contains("show")) {
            menu.classList.remove("show");
            setTimeout(() => menu.style.display = "none", 200);
        }
    }
});
</script>
