<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="accueil-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="auth-style.css?v=<?php echo time(); ?>">
</head>
<body>

<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="accueil.php">
            <span class="brand-logo"></span>
            <span class="brand-text">NAHA</span>
        </a>

        <nav class="menu">
            <a class="pill" href="accueil.php">Accueil</a>
            <a class="pill" href="tableau.php">Tableau de bord</a>
            <a class="pill" href="calculateur.php">Calculateur</a>
            <a class="pill" href="projet.php">Le Projet</a>
            <a class="pill" href="consommation.php">Consommation</a>
            <a class="pill" href="contact.php">Contact</a>
        </nav>

        <div class="nav-actions">
            <a href="seconnecter.php" class="btn btn-small btn-ghost active">Se connecter</a>
            <a href="sinscrire.php" class="btn btn-small btn-primary">S’inscrire</a>
        </div>
    </div>
</header>

<main class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Connexion</h1>

        <!-- Zone erreur AJAX -->
        <div id="login-error" style="
            color:#e11d48;
            font-weight:600;
            margin-bottom:10px;
            display:none;
        "></div>

        <form class="auth-form" novalidate>

            <label for="mail">Adresse e-mail</label>
            <input type="email" name="mail" id="mail" required />

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" required />

            <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
        </form>

        <p class="auth-alt">
            Pas encore de compte ? <a href="sinscrire.php">Inscrivez-vous</a>
        </p>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const form = document.querySelector(".auth-form");
    const mail = document.querySelector("#mail");
    const mdp  = document.querySelector("#mdp");
    const errorDiv = document.querySelector("#login-error");
    const submitBtn = form.querySelector("button");

    // Vérification email + mdp
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Animation shake
    function shakeForm() {
        form.classList.add("shake");
        setTimeout(() => form.classList.remove("shake"), 400);
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        errorDiv.style.display = "none";
        errorDiv.textContent = "";

        const emailVal = mail.value.trim();
        const passVal  = mdp.value.trim();

        // Vérif email
        if (!isValidEmail(emailVal)) {
            errorDiv.textContent = "Veuillez entrer une adresse e-mail valide.";
            errorDiv.style.display = "block";
            shakeForm();
            return;
        }

        // Vérif mdp
        if (passVal.length < 1) {
            errorDiv.textContent = "Le mot de passe doit contenir au moins 1 caractère.";
            errorDiv.style.display = "block";
            shakeForm();
            return;
        }

        // Envoi AJAX
        const data = new FormData();
        data.append("mail", emailVal);
        data.append("pswrd", passVal);

        const res = await fetch("login_api.php", {
            method: "POST",
            body: data
        });

        const json = await res.json();

        if (!json.success) {
            errorDiv.textContent = json.msg;
            errorDiv.style.display = "block";
            shakeForm();
            return;
        }

        // Succès → redirection
        window.location.href = json.redirect;
    });
});
</script>

<style>
/* Animation SHAKE */
.shake {
    animation: shake 0.35s;
}
@keyframes shake {
    0% { transform: translateX(0px); }
    20% { transform: translateX(-6px); }
    40% { transform: translateX(6px); }
    60% { transform: translateX(-4px); }
    80% { transform: translateX(4px); }
    100% { transform: translateX(0px); }
}
</style>


</body>
</html>
