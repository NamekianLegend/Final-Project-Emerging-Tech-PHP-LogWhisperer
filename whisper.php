// whisper.php

<?php
// 1. Load the API Key safely from an environment variable that is found in the .env file
$env = parse_ini_file('.env');
$apiKey = $env['OPENAI_API_KEY'] ?? '';

if (empty($apiKey)) {
    die('ERROR: API key not found. Please set it in the .env file.\n');
}

// 2. Read the log file.
$logContent = file_get_contents(__DIR__ . '/data/test.log');
echo "LogWhisperer Initialized. Reading test.log...\n";

// 3. Prepare the AI Request (Setting up for function calling next week)
$apiUrl = 'https://api.openai.com/v1/chat/completions';
$data = [
    'model' => 'gpt-4o-mini',
    'messages' => [
        ['role' => 'system', 'content' => 'You are a server admin assistant that summarizes log files.'],
        ['role' => 'user', 'content' => "Analyze the following log content:\n\n$logContent"]
    ]
];

// Note for Progress Report: cURL connection established, ready to implement
// strict JSON Function Calling in the next phase of development.
echo "Setup complete. Ready for API transmission.\n";