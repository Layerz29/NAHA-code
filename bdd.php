<?php
function getBD() {
    try {
        $bdd = new PDO("mysql:host=localhost;port=8889;dbname=naha;charset=utf8", "root", "root");
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>
