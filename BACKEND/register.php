<?php
// Postavljanje CORS zaglavlja odmah na početku
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Ako je zahtjev tipa OPTIONS, odgovori sa statusom 204 i izađi
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require 'config.php'; // Ako koristiš config.php za povezivanje s bazom

// Provjera veze s bazom
if (!isset($pdo)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Dobij podatke iz POST zahtjeva
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Provjeri jesu li svi podaci prisutni
if (!$username || !$password) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Provjeri postoji li korisničko ime
$checkQuery = $pdo->prepare("SELECT id FROM korisnici WHERE korisnicko_ime = ?");
$checkQuery->execute([$username]);
if ($checkQuery->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
    exit;
}

// Hashiraj lozinku i unesi korisnika u bazu
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Unesi korisnika u bazu
$query = $pdo->prepare("INSERT INTO korisnici (korisnicko_ime, lozinka, tip_korisnika_id) VALUES (?, ?, 2)");
if ($query->execute([$username, $passwordHash])) {
    echo json_encode(['success' => true, 'message' => 'Registration successful.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
}
?>
