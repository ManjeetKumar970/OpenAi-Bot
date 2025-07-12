<?php 
function sanitizeUserInput(string $input): string
{
    static $patterns = null; 

    if ($patterns === null) {
        $configPath = __DIR__ . '/../sanitizer.php';
        $config     = require $configPath;
        $patterns   = $config['sensitivePatterns'];
    }

    $input = strtolower($input);

    foreach ($patterns as $pattern) {
        $input = preg_replace($pattern, '[SENSITIVE REDACTED]', $input);
    }

    return htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

