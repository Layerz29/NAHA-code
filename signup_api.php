<?php
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');
require_once "bdd.php";

$bdd = getBD();

// Récup POST
$nom    = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$adr    = trim($_POST['adr'] ?? '');
$num    = trim($_POST['num'] ?? '');
$mail   = trim($_POST['mail'] ?? '');
$ps1    = $_POST['pswrd1'] ?? '';
$ps2    = $_POST['pswrd2'] ?? '';

// Validations minimales
if (!$nom || !$prenom || !$mail || !$ps1 || !$ps2) {
    echo json_encode(["success" => false, "msg" => "Tous les champs obligatoires doivent être remplis."]);
    exit;
}

if ($ps1 !== $ps2) {
    echo json_encode(["success" => false, "msg" => "Les mots de passe ne correspondent pas."]);
    exit;
}

// Email déjà utilisé ? (bonne table)
$stmt = $bdd->prepare("SELECT id_utilisateur FROM utilisateurs WHERE mail = ?");
$stmt->execute([$mail]);

if ($stmt->fetch()) {
    echo json_encode(["success" => false, "msg" => "Cet email est déjà utilisé."]);
    exit;
}

// Création compte (bonne table + bons champs)
$hash = password_hash($ps1, PASSWORD_DEFAULT);

$stmt = $bdd->prepare("
    INSERT INTO utilisateurs (nom, prenom, adresse, numero, mail, pswrd)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->execute([$nom, $prenom, $adr, $num, $mail, $hash]);

// Récup ID
$id = $bdd->lastInsertId();

// AUTO-LOGIN complet
$_SESSION['utilisateur'] = [
    "id_utilisateur" => $id,
    "nom" => $nom,
    "prenom" => $prenom,
    "mail" => $mail
];

// Succès + redirection
echo json_encode([
    "success" => true,
    "msg" => "Compte créé avec succès ! Bienvenue 🎉",
    "redirect" => "accueil.php"
]);
exit;
