<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'bdd.php';

$bdd = getBD();

// Récup
$nom    = trim($_POST['n']    ?? '');
$prenom = trim($_POST['p']    ?? '');
$adresse= trim($_POST['adr']  ?? '');
$numero = trim($_POST['num']  ?? '');
$mail   = trim($_POST['mail'] ?? '');
$m1     = $_POST['pswrd1']    ?? '';
$m2     = $_POST['pswrd2']    ?? '';

$backUrl = 'sinscrire.php'
         . '?n='   . urlencode($nom)
         . '&p='   . urlencode($prenom)
         . '&adr=' . urlencode($adresse)
         . '&num=' . urlencode($numero)
         . '&mail='. urlencode($mail);

// Validations
if ($nom==='' || $prenom==='' || $mail==='' || $m1==='' || $m2==='') {
  header("Location: $backUrl&err=" . urlencode('Champs manquants'));
  exit;
}
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  header("Location: $backUrl&err=" . urlencode('Email invalide'));
  exit;
}
if ($m1 !== $m2) {
  header("Location: $backUrl&err=" . urlencode('Mots de passe différents'));
  exit;
}

// Mail déjà utilisé ?
$check = $bdd->prepare("SELECT 1 FROM utilisateurs WHERE mail = :mail LIMIT 1");
$check->execute(['mail' => $mail]);
if ($check->fetch()) {
  header("Location: $backUrl&err=" . urlencode('Adresse mail déjà utilisée'));
  exit;
}

// Insert
$hash = password_hash($m1, PASSWORD_DEFAULT);
$sql = "INSERT INTO utilisateurs (nom, prenom, adresse, numero, mail, pswrd)
        VALUES (:nom, :prenom, :adresse, :numero, :mail, :pswrd)";
$stmt = $bdd->prepare($sql);
$stmt->execute([
  'nom' => $nom,
  'prenom' => $prenom,
  'adresse' => $adresse,
  'numero' => $numero,
  'mail' => $mail,
  'pswrd' => $hash
]);

// Redirige vers la connexion
header('Location: seconnecter.php');
exit;