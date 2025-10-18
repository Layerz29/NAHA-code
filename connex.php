<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('bdd.php');
$bdd = getBD();
$mail=$_POST['mail'] ?? '';
$pswrd=$_POST['pswrd'] ?? '';

if(empty($_POST['mail']) || empty($_POST['pswrd'])){
    header("Location: seconnecter.php?erreur=champs_vides&mail=".$mail);
    exit;
}

$sql="SELECT * FROM utilisateurs WHERE mail=:mail";
$stmt=$bdd->prepare($sql);
$stmt->execute(['mail'=> $mail]);
$utilisateur=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$utilisateur){
    header('location:seconnecter.php?erreur=mail_invalide');
    exit;
}  
if (!password_verify($pswrd, $utilisateur['pswrd'])) {
    echo "Mot de passe incorrect.";
    exit;
}

$_SESSION['utilisateur']=[
    'id'=>$utilisateur['id_utilisateur'],
    'mail'=>$utilisateur['mail'] ,
    'nom'=>$utilisateur['nom'],
    'prenom'=>$utilisateur['prenom'] 
    ];

header('location:acceuil.php');
exit;

?>