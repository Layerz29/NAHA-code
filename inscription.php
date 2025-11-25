<?php
session_start();
require_once 'bdd.php';

$bdd = getBD();

if(
  empty($_POST['nom']) ||
  empty($_POST['prenom']) ||
  empty($_POST['mail']) ||
  empty($_POST['adresse']) ||
  empty($_POST['numero']) ||
  empty($_POST['mdp1']) ||
  empty($_POST['mdp2'])
) {
  die("Tous les champs doivent être remplis.");
}

$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$mail = htmlspecialchars($_POST['mail']);
$adresse = htmlspecialchars($_POST['adresse']);
$numero = htmlspecialchars($_POST['numero']);

$hash = password_hash($_POST['mdp1'], PASSWORD_BCRYPT);

$sql = "INSERT INTO utilisateurs(nom, prenom, numero, adresse, mail, pswrd)
        VALUES(:nom, :prenom, :numero, :adresse, :mail, :pswrd)";

$stmt = $bdd->prepare($sql);
$stmt->execute([
  'nom' => $nom,
  'prenom' => $prenom,
  'numero' => $numero,
  'adresse' => $adresse,
  'mail' => $mail,
  'pswrd' => $hash
]);

header("Location: seconnecter.php");
exit;
