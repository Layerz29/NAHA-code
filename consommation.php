<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<?php
session_start();
require_once('bdd.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);
$bdd = getBD();

if(!isset($_SESSION['utilisateur'])){
    header('location: seconnecter.php');
    exit;
}
$id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produit'], $_POST['quantite'], $_POST['date'])) {
    $produit = $_POST['produit'];
    $quantite = (float)$_POST['quantite'];
    $date = $_POST['date'];

    $sql = "INSERT INTO consommation (id_utilisateur, id_produit, quantite, date_conso)
            VALUES (:id_utilisateur, :id_produit, :quantite, :date_conso)";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        'id_utilisateur' => $id_utilisateur,
        'id_produit' => $produit,
        'quantite' => $quantite,
        'date_conso' => $date
    ]);
}

$produits = $bdd->query("SELECT * FROM produits ORDER BY nom_produit ASC")->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT c.id_conso, p.nom_produit AS produit, p.energie_kcal, c.quantite, c.date_conso
        FROM consommation c
        JOIN produits p ON c.id_produit = p.id_produit
        WHERE c.id_utilisateur = :id_utilisateur
        ORDER BY c.date_conso DESC
        LIMIT 10";
$stmt = $bdd->prepare($sql);
$stmt->execute(['id_utilisateur' => $id_utilisateur]);
$consommations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Consommation</title>
</style>
</style>
</head>
<body>
    <header>
        <div><strong>NAHA</strong></div>
        <nav>
            <a href="acceuil.php">Accueil</a>
            <a href="consommation.php">Consommation</a>
            <a href="activite.php">Activité</a>
            <a href="profil.php">Profil</a>
        </nav>

        <div>Bonjour, <?php echo htmlspecialchars($_SESSION['utilisateur']['prenom']); ?>!</div>
        <a href="deconnexion.php" style="color : white;">Déconnexion</a>
        </div>
    </header>

    <div>
        <h2>Ajouter une consommation</h2>
        <form method="post">
            <label for="produit">Produit :</label>
            <select name="produit" id="produit" required>
                <option value="">--Sélectionner un produit--</option>
                <?php foreach($produits as $prod): ?>
                    <option value="<?php echo $prod['id_produit']; ?>"><?php echo htmlspecialchars($prod['nom_produit']); ?>(<?= $prod['energie_kcal'] ?> kcal)</option>
                <?php endforeach; ?>
            </select>

            <label for="quantite">Quantité (g) ou (ml) :</label>
            <input type="number" name="quantite" id="quantite" min="1" required>

            <label for="date">Date de consommation :</label>
            <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>

            <button type="submit">Ajouter</button>
        </form>

        <h2>Dernières consommations</h2>
        <table>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Calories</th>
                <th>Date</th>
            </tr>
            <?php if (empty($consommations)): ?>
                <tr><td colspan="4">Aucune consommation enregistrée.</td></tr>
                <?php else : ?>
                    <?php foreach($consommations as $conso): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($conso['produit']); ?></td>
                            <td><?php echo htmlspecialchars($conso['quantite']); ?></td>
                            <td><?php echo htmlspecialchars($conso['kcal'] * $conso['quantite'] / 100); ?> kcal</td>
                            <td><?php echo htmlspecialchars($conso['date_conso']); ?></td>
                        </tr>
                    <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
