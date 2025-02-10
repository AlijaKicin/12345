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

include 'config.php';  // Uključi konfiguraciju za bazu

// Dobij JSON podatke iz POST zahtjeva
$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Provjera da li su podaci prazni
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Pripremi SQL upit za dohvat korisnika prema korisničkom imenu
$stmt = $pdo->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();

// Provjeri postoji li korisnik s tim korisničkim imenom
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['lozinka'])) {
    // Ako je lozinka ispravna, prijava je uspješna
    echo json_encode(['success' => true, 'message' => 'Login successful']);
} else {
    // Ako korisnik ne postoji ili lozinka nije ispravna
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
}
?>
