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

$korisnik_id = $_GET['korisnik_id'] ?? '';

if (!$korisnik_id) {
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit;
}

// Dohvati podatke o transakcijama za određenog korisnika
$query = $pdo->prepare("
    SELECT t.id, t.iznos, t.tip, t.opis, t.datum, k.naziv AS kategorija 
    FROM transakcije t
    JOIN kategorije k ON t.kategorija_id = k.id
    WHERE t.korisnik_id = ?
");
$query->execute([$korisnik_id]);
$transakcije = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'data' => $transakcije]);
?>