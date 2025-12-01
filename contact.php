<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'bdd.php';
$bdd = getBD();

/* ================== CSRF ================== */
if (empty($_SESSION['csrf_contact'])) {
    $_SESSION['csrf_contact'] = bin2hex(random_bytes(32));
}

/* ================== AJAX : traitement du formulaire ================== */
if (isset($_GET['ajax']) && $_GET['ajax'] === 'contact') {
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée.']);
        exit;
    }

    // Vérification CSRF
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf_contact'] ?? '', $token)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Token CSRF invalide. Recharge la page.']);
        exit;
    }

    // Récupération + nettoyage des données
    $nom     = trim($_POST['nom'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $sujet   = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];

    if ($nom === '' || mb_strlen($nom) < 2) {
        $errors['nom'] = 'Ton nom est trop court.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Adresse e-mail invalide.';
    }
    if ($sujet === '' || mb_strlen($sujet) < 3) {
        $errors['sujet'] = 'Sujet trop court.';
    }
    if ($message === '' || mb_strlen($message) < 10) {
        $errors['message'] = 'Ton message est trop court.';
    }

    if (!empty($errors)) {
        echo json_encode(['ok' => false, 'errors' => $errors]);
        exit;
    }

    try {
        // id utilisateur si connecté
        $idUser = null;
        if (isset($_SESSION['utilisateur']['id_utilisateur'])) {
            $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
        }

        if ($idUser === null) {
            // pas connecté -> pas d'id_utilisateur
            $sql = "INSERT INTO contact_message (nom, email, sujet, message, created_at)
                    VALUES (:nom, :email, :sujet, :message, NOW())";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ':nom'     => $nom,
                ':email'   => $email,
                ':sujet'   => $sujet,
                ':message' => $message
            ]);
        } else {
            // connecté -> on stocke aussi l'id_utilisateur
            $sql = "INSERT INTO contact_message (id_utilisateur, nom, email, sujet, message, created_at)
                    VALUES (:idUser, :nom, :email, :sujet, :message, NOW())";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ':idUser'  => $idUser,
                ':nom'     => $nom,
                ':email'   => $email,
                ':sujet'   => $sujet,
                ':message' => $message
            ]);
        }

        echo json_encode([
            'ok'      => true,
            'message' => 'Message bien envoyé, merci !'
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'ok'    => false,
            'error' => 'Erreur serveur.'
            // 'debug' => $e->getMessage()
        ]);
    }
    exit;


}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NAHA — Contact</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">

    <!-- Styles globaux + contact -->
    <link rel="stylesheet" href="accueil-style.css" />
    <link rel="stylesheet" href="contact-style.css" />
</head>
<body>

<?php include "header.php"; ?>


<main class="contact-main">
    <section class="contact-hero">
        <div class="container contact-hero__inner">
            <div>
                <p class="badge">Une question, un bug, une idée ?</p>
                <h1 class="contact-title">Contacte l’équipe NAHA</h1>
                <p class="contact-sub">
                    Donne-nous ton retour sur la plateforme, propose une amélioration ou signale un problème.
                    On lit tous les messages 💬
                </p>
            </div>
        </div>
    </section>

    <section class="contact-section">
        <div class="container contact-grid">
            <div class="contact-card">
                <h2>Écris-nous</h2>
                <p class="contact-card__sub">
                    Remplis ce formulaire, on te répond dès que possible sur ton e-mail.
                </p>

                <form id="contact-form" novalidate>
                    <div class="field">
                        <label for="nom">Nom / Pseudo</label>
                        <input type="text" id="nom" name="nom" autocomplete="name" required />
                        <p class="field-error" data-error-for="nom"></p>
                    </div>

                    <div class="field">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" autocomplete="email" required />
                        <p class="field-error" data-error-for="email"></p>
                    </div>

                    <div class="field">
                        <label for="sujet">Sujet</label>
                        <input type="text" id="sujet" name="sujet" required />
                        <p class="field-error" data-error-for="sujet"></p>
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                        <p class="field-error" data-error-for="message"></p>
                    </div>

                    <input type="hidden" name="csrf" id="csrf"
                           value="<?php echo htmlspecialchars($_SESSION['csrf_contact'], ENT_QUOTES, 'UTF-8'); ?>">

                    <button type="submit" class="btn-primary" id="contact-submit">
                        Envoyer le message
                    </button>

                    <p class="form-feedback" id="form-feedback"></p>
                </form>
            </div>

            <aside class="contact-side">
                <div class="side-card">
                    <h3>Support NAHA</h3>
                    <p>Tu peux nous écrire pour :</p>
                    <ul>
                        <li>proposer une nouvelle fonctionnalité ;</li>
                        <li>signaler un bug ou un souci d’affichage ;</li>
                        <li>poser une question sur ton compte.</li>
                    </ul>
                </div>

                <div class="side-card">
                    <h3>Temps de réponse</h3>
                    <p>
                        On essaie de répondre sous <strong>48h</strong>.<br>
                        Pense à vérifier tes spams si tu ne vois rien.
                    </p>
                </div>
            </aside>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>

<script src="contact-script.js"></script>
</body>
</html>
