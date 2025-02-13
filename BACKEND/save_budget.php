<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require 'config.php'; // Uključi konfiguraciju za bazu podataka

$data = json_decode(file_get_contents('php://input'), true);

$korisnik_id = $data['korisnik_id'] ?? '';
$kategorija_id = $data['kategorija_id'] ?? '';
$iznos = $data['iznos'] ?? '';
$tip = $data['tip'] ?? '';
$opis = $data['opis'] ?? '';

if (!$korisnik_id || !$kategorija_id || !$iznos || !$tip) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Unesi podatke u tablicu transakcije
$query = $pdo->prepare("INSERT INTO transakcije (korisnik_id, kategorija_id, iznos, tip, opis) VALUES (?, ?, ?, ?, ?)");
if ($query->execute([$korisnik_id, $kategorija_id, $iznos, $tip, $opis])) {
    echo json_encode(['success' => true, 'message' => 'Transaction saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save transaction.']);
}
?>