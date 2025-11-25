<?php
function getBD() {
  try{
    //si vous arrivez pas à vous connecter, vérifier le bon port
    $dsn = "mysql:host=localhost;port=8889;dbname=naha;charset=utf8";
    $user = "root";
    $pass = "root";  

    $bdd = new PDO($dsn, $user, $pass);

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $bdd;

}catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
  }
}
?>