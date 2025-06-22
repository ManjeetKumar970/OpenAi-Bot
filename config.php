<?php
return [
    'openrouter' => [
        'api_key' => 'your_api_key_here', // Replace with your actual OpenRouter API
        'api_url' => 'https://openrouter.ai/api/v1/chat/completions',
        'default_model' => 'openai/gpt-3.5-turbo'
    ],
    'chat_settings' => [
        'max_message_length' => 2000,
        'timeout' => 30
    ]
];
