<?php
header('Content-Type: application/json');
session_start();
$config = include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests allowed']);
    exit;
}

if (empty($_POST['user-message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No message provided']);
    exit;
}

$userMessage = trim($_POST['user-message']);
$maxLength = $config['chat_settings']['max_message_length'] ?? 2000;

if (strlen($userMessage) > $maxLength) {
    http_response_code(413);
    echo json_encode(['error' => 'Message too long']);
    exit;
}

// Rate limiting (10 requests per 60 sec)
$rateLimit = 10;
$rateWindow = 60;

if (!isset($_SESSION['requests'])) $_SESSION['requests'] = [];
$_SESSION['requests'] = array_filter($_SESSION['requests'], fn($t) => $t > time() - $rateWindow);

if (count($_SESSION['requests']) >= $rateLimit) {
    http_response_code(429);
    echo json_encode(['error' => 'Rate limit exceeded']);
    exit;
}
$_SESSION['requests'][] = time();

$payload = [
    'model' => $config['openrouter']['default_model'],
    'messages' => [
        ['role' => 'user', 'content' => $userMessage]
    ]
];

$options = [
    'http' => [
        'header'  => implode("\r\n", [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $config['openrouter']['api_key'],
            'HTTP-Referer: http://localhost',
            'X-Title: Chatbot'
        ]),
        'method'  => 'POST',
        'content' => json_encode($payload),
        'timeout' => $config['chat_settings']['timeout'],
        'ignore_errors' => true
    ]
];

$response = file_get_contents($config['openrouter']['api_url'], false, stream_context_create($options));

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'API call failed']);
    exit;
}

$data = json_decode($response, true);

if (!isset($data['choices'][0]['message'])) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Unexpected API response',
        'debug' => $data
    ]);
    exit;
}

$reply = $data['choices'][0]['message'];
echo json_encode([
    'role' => $reply['role'],
    'content' => $reply['content']
]);
