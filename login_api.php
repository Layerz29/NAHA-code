<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once "bdd.php";
$bdd = getBD();

$mail   = $_POST['mail']   ?? '';
$pswrd  = $_POST['pswrd']  ?? '';

if (!$mail || !$pswrd) {
    echo json_encode([
        "success" => false,
        "msg" => "Remplis tous les champs !"
    ]);
    exit;
}

$stmt = $bdd->prepare("SELECT * FROM utilisateur WHERE mail = ?");
$stmt->execute([$mail]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode([
        "success" => false,
        "msg" => "Cet email n’existe pas dans la base."
    ]);
    exit;
}

if (!password_verify($pswrd, $user["mdp"])) {
    echo json_encode([
        "success" => false,
        "msg" => "Mot de passe incorrect."
    ]);
    exit;
}

$_SESSION['utilisateur'] = $user;

echo json_encode([
    "success" => true,
    "msg"     => "Connexion réussie !",
    "redirect"=> "tableau.php"
]);
exit;
