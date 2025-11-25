<?php
function getBD() {
  try{

    $dsn = "mysql:host=localhost;dbname=seconnecter;charset=utf8";
    $user = "root";
    $pass = "";  

    $bdd = new PDO($dsn; $user; $pass);

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $bdd;

}catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
  }
}
?>