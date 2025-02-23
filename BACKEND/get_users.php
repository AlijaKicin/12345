<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include 'config.php'; // Uključi konfiguraciju za bazu

try {
    // Pripremi SQL upit za dohvat svih korisnika
    $stmt = $pdo->query("SELECT * FROM korisnici");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Provjeri da li postoje korisnici
    if ($users) {
        echo json_encode(['success' => true, 'data' => $users]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No users found.']);
    }
} catch (PDOException $e) {
    // Uhvati grešku ako dođe do problema s bazom
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>