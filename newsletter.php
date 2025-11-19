<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "bdd.php";
$bdd = getBD();

/* --- Vérification de la requête --- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: accueil.php');
    exit;
}

/* --- Sécurité --- */
$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['newsletter_msg'] = "Email invalide, fréro 😭";
    header("Location: accueil.php#newsletter");
    exit;
}

/* --- Insert en BDD --- */
try {
    $stmt = $bdd->prepare("INSERT IGNORE INTO newsletter_users (email) VALUES (:email)");
    $stmt->execute(['email' => $email]);

    $_SESSION['newsletter_msg'] = "Bien vu ! Tu recevras bientôt tes conseils 🍃🔥";
} catch (Exception $e) {
    $_SESSION['newsletter_msg'] = "Erreur serveur, réessaie 🙏";
}

/* --- Redirection vers l'accueil --- */
header("Location: accueil.php");
exit;
