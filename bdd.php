<?php
function getBD() {
  $tries = [
    ['host'=>'127.0.0.1','port'=>3306], // MAMP Windows (Apache 80, MySQL 3306)
    ['host'=>'127.0.0.1','port'=>8889], // MAMP macOS par défaut
  ];
  $lastErr = null;
  foreach ($tries as $t) {
    try {
      $dsn = "mysql:host={$t['host']};port={$t['port']};dbname=naha;charset=utf8mb4";
      $pdo = new PDO($dsn, 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
      return $pdo;
    } catch (PDOException $e) {
      $lastErr = $e;
    }
  }
  die('Erreur de connexion MySQL : '.$lastErr->getMessage());
}