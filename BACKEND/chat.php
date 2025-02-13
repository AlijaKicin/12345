<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Učitaj API ključ iz api.php
$config = include 'api.php';
$aimlApiKey = $config['aiml_api_key'];

if (!$aimlApiKey) {
    echo json_encode(['reply' => 'API ključ nije postavljen!']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Molimo unesite poruku.']);
    exit;
}

// Postavljanje API URL-a
$apiUrl = "https://api.openai.com/v1/chat/completions";

// Postavljanje system prompt-a
$systemPrompt = "You are a financial assistant helping users manage their budget.";

// Kreiranje podataka za slanje
$requestData = json_encode([
    'model' => 'mistralai/Mistral-7B-Instruct-v0.2', // Postavljanje modela
    'messages' => [
        ['role' => 'system', 'content' => $systemPrompt],
        ['role' => 'user', 'content' => $userMessage]
    ],
    'temperature' => 0.7,
    'max_tokens' => 256
]);

// Postavljanje cURL zahtjeva
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $aimlApiKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $responseData = json_decode($response, true);
    echo json_encode(['reply' => $responseData['choices'][0]['message']['content'] ?? 'Nepoznat odgovor.']);
} else {
    echo json_encode(['reply' => 'Greška u AI odgovoru. Kod: ' . $httpCode]);
}
?>
