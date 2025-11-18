
<?php
header('Content-Type: application/json; charset=utf-8');
$email = trim($_POST['email'] ?? '');
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(['error' => 'Email invalide.']);
  exit;
}
// TODO: ici tu pourras enregistrer en BDD si tu veux.
echo json_encode(['message' => 'Inscription enregistrée ✅']);
