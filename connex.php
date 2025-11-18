<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('bdd.php');
$bdd = getBD();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: seconnecter.php');
    exit;
}

$mail  = trim($_POST['mail'] ?? '');
$pswrd = $_POST['pswrd'] ?? '';

if ($mail === '' || $pswrd === '') {
    header('Location: seconnecter.php?err=' . urlencode('Email ou mot de passe manquant.') . '&mail=' . urlencode($mail));
    exit;
}

$stmt = $bdd->prepare("SELECT id_utilisateur, nom, prenom, mail, pswrd FROM utilisateurs WHERE mail = :mail LIMIT 1");
$stmt->execute(['mail' => $mail]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: seconnecter.php?err=' . urlencode('Compte introuvable.') . '&mail=' . urlencode($mail));
    exit;
}

// Si le mot de passe en base est hashé (bcrypt)
if (preg_match('/^\$2y\$/', $user['pswrd'])) {
    $ok = password_verify($pswrd, $user['pswrd']);
} else {
    // ⚠️ fallback si tu as (temporairement) des mots de passe en clair
    $ok = hash_equals($user['pswrd'], $pswrd);
}

if (!$ok) {
    header('Location: seconnecter.php?err=' . urlencode('Mot de passe incorrect.') . '&mail=' . urlencode($mail));
    exit;
}

// Login OK
$_SESSION['utilisateur'] = [
    'id_utilisateur' => (int)$user['id_utilisateur'],
    'nom' => $user['nom'],
    'prenom' => $user['prenom'],
    'mail' => $user['mail'],
];

header('Location: accueil.php');
exit;