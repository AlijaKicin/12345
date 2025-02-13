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

require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? '';

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Entry ID is required.']);
    exit;
}

$query = $pdo->prepare("DELETE FROM transakcije WHERE id = ?");
if ($query->execute([$id])) {
    echo json_encode(['success' => true, 'message' => 'Entry deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete entry.']);
}
?>