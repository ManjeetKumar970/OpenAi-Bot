<?php
header('Content-Type: application/json');
session_start();
include_once('ErrorLog.php');
$config = include 'config.php';
$logDir = __DIR__ . '/logs';

$error= new ErrorLog();


// ─────────────────────────────────────────────────────────
// ✅ Validate Request Type
// ─────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests allowed']);
    exit;
}

// ─────────────────────────────────────────────────────────
// ✅ Validate User Message
// ─────────────────────────────────────────────────────────
if (empty($_POST['user-message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No message provided']);
    exit;
}

$userMessage = trim($_POST['user-message']);
$maxLength = $config['chat_settings']['max_message_length'] ?? 2000;
  $error->createErrorLog($userMessage);
    if (strlen($userMessage) > $maxLength) {

        http_response_code(413);
        echo json_encode(['error' => 'Message too long']);
        exit;
    }

// ─────────────────────────────────────────────────────────
// ✅ Rate Limiting (10 requests per minute)
// ─────────────────────────────────────────────────────────
$rateLimit = 10;
$rateWindow = 60; // seconds

if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}
$_SESSION['requests'] = array_filter($_SESSION['requests'], fn($t) => $t > time() - $rateWindow);
if (count($_SESSION['requests']) >= $rateLimit) {
    http_response_code(429);
    echo json_encode(['error' => 'Rate limit exceeded']);
    exit;
}
$_SESSION['requests'][] = time();

// ─────────────────────────────────────────────────────────
// ✅ Config Checks
// ─────────────────────────────────────────────────────────
if (empty($config['openrouter']['api_key']) || empty($config['openrouter']['api_url'])) {
    http_response_code(500);
    echo json_encode(['error' => 'API key or URL not configured']);
    exit;
}

// ─────────────────────────────────────────────────────────
// ✅ Forbidden Word Filter
// ─────────────────────────────────────────────────────────
$forbiddenWords = ['badword1', 'badword2'];
foreach ($forbiddenWords as $word) {
    if (stripos($userMessage, $word) !== false) {
        http_response_code(400);
        echo json_encode(['error' => 'Message contains forbidden content']);
        exit;
    }
}

// ─────────────────────────────────────────────────────────
// ✅ Prepare API Payload
// ─────────────────────────────────────────────────────────
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
            'X-Title: Chatbot'
        ]),
        'method'  => 'POST',
        'content' => json_encode($payload),
        'timeout' => $config['chat_settings']['timeout'],
        'ignore_errors' => true
    ]
];

// ─────────────────────────────────────────────────────────
// ✅ Make API Call
// ─────────────────────────────────────────────────────────
$response = @file_get_contents($config['openrouter']['api_url'], false, stream_context_create($options));

if ($response === false) {
    $error = error_get_last();
    http_response_code(500);
    echo json_encode(['error' => 'API call failed', 'details' => $error['message'] ?? 'Unknown error']);
    exit;
}

// ─────────────────────────────────────────────────────────
// ✅ Parse API Response
// ─────────────────────────────────────────────────────────
$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Invalid JSON from API',
        'debug' => $response
    ]);
    exit;
}

if (!isset($data['choices'][0]['message'])) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Unexpected API response structure',
        'debug' => $data
    ]);
    exit;
}

$reply = $data['choices'][0]['message'];

// ─────────────────────────────────────────────────────────
// ✅ Log to Daily Log File
// ─────────────────────────────────────────────────────────

if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true); // Create directory if missing
}
$logFile = $logDir . '/chatbot_log_' . date('Y-m-d') . '.log';
$logEntry = sprintf(
    "[%s]\nUser: %s\nBot: %s\n\n",
    date('Y-m-d H:i:s'),
    $userMessage,
    $reply['content']
);
file_put_contents($logFile, $logEntry, FILE_APPEND);

// ─────────────────────────────────────────────────────────
// ✅ Return Final JSON Response
// ─────────────────────────────────────────────────────────
echo json_encode([
    'role' => $reply['role'],
    'content' => $reply['content']
]);

