<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require 'vendor/autoload.php'; // Učitaj OpenAI biblioteku

use OpenAI\Client;

// Učitaj API ključ iz api.php
$config = include 'api.php';
$openaiApiKey = $config['openai_api_key'];

if (!$openaiApiKey) {
    echo json_encode(['reply' => 'API ključ nije postavljen!']);
    exit;
}

$client = OpenAI::client($openaiApiKey);

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Molimo unesite poruku.']);
    exit;
}

try {
    $response = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',  // Odabir modela OpenAI
        'messages' => [
            ['role' => 'system', 'content' => 'You are a financial assistant helping users manage their budget.'],
            ['role' => 'user', 'content' => $userMessage],
        ],
    ]);

    echo json_encode(['reply' => $response['choices'][0]['message']['content']]);
} catch (Exception $e) {
    echo json_encode(['reply' => 'Greška u AI odgovoru: ' . $e->getMessage()]);
}
?>
