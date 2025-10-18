<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('bdd.php');

    if(empty($_POST['n']) || empty($_POST['p']) || empty($_POST['adr']) || empty($_POST['num']) ||
    empty($_POST['mail']) || ($_POST['pswrd1']!==$_POST['pswrd2'])){
        
        $url="sinscrire.php?n=". $_POST['n'] .
                "&p=".$_POST['p'] .
                "&adr=" . $_POST['adr'] .
				"&num=" . $_POST['num'] .
				"&mail=". $_POST['mail'];
        
        header("location:$url");
        exit();
    }
    

?>

<?php 

$bdd=getBD();

$nom = $_POST['n'];
$prenom = $_POST['p'];
$adresse = $_POST['adr'];
$numero = $_POST['num'];
$mail = $_POST['mail'];
$pswrd1 = $_POST['pswrd1'];

$check=$bdd->prepare("SELECT mail FROM utilisateurs WHERE mail=?");
$check->execute([$mail]);

if($check ->rowCount()>0){
    header("location:$url");
    exit();
}

$mdpHash = password_hash($pswrd1, PASSWORD_DEFAULT);
$sql="INSERT INTO utilisateurs (nom, prenom, mail, adresse, numero, pswrd)
        VALUES(:nom,:prenom,:mail,:adresse,:numero,:pswrd)";
$stmt=$bdd->prepare($sql);
$stmt->execute(['nom' => $nom,
				'prenom' => $prenom,
				'adresse' => $adresse,
				'numero' => $numero,
				'mail' => $mail,
				'pswrd' => $mdpHash]);



header("location: seconnecter.php");
exit();
?>