<?php
// whisper.php
require_once 'api_handler.php';

//STARTUP BANNER — Bright Green
echo "\033[92m=====================================================\033[0m\n";
echo "\033[92m🟢 SYSTEM STATUS: ONLINE\033[0m\n";
echo "\033[92m🚀 Launching LogWhisperer\033[0m\n";

for ($i = 0; $i < 3; $i++) {
    echo "\033[92m.\033[0m";
    usleep(400000);
}
echo "\n";

echo "\033[92m=====================================================\033[0m\n\n";

// 1. Load API Key
$env = parse_ini_file('.env');
$apiKey = $env['OPENAI_API_KEY'] ?? '';

if (empty($apiKey)) {
    die('ERROR: API key not found. Please set it in the .env file.' . "\n");
}

// 2. Read log file
$logFile = $argv[1] ?? null;

if (!$logFile) {
    // Yellow — No log file provided
    die("\033[33m⚠️ No log file provided.\nUsage: php whisper.php /path/to/logfile.log\033[0m\n");
}

if (!file_exists($logFile)) {
    // Red — Log file not found
    die("\033[31m❌ Log file not found: $logFile\033[0m\n");
}

$logContent = file_get_contents($logFile);
// Green — Log file loaded
echo "\033[32m✅ Log file loaded successfully. Reading: $logFile\033[0m\n";

// 3. Prepare AI request
$apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
$data = [
    'model' => 'llama-3.3-70b-versatile',
    'messages' => [
        ['role' => 'system', 'content' => 'You are a server admin assistant that summarizes log files.'],
        ['role' => 'user', 'content' => "Analyze the following log content:\n\n$logContent"]
    ]
];

echo " \n";
// Blue — Sending to Groq
echo "\033[34m📨 Sending log content to Groq for analysis\033[0m\n";
for ($i = 0; $i < 3; $i++) {
    echo "\033[34m.\033[0m";
    usleep(400000);
}
echo " \n\n";

// Cyan — Log Content
echo "\033[36m====================================================================\033[0m\n";
echo "\033[36m📄 Log File Content:\033[0m\n";
echo "\033[36m====================================================================\033[0m\n";

// Yellow — Error + Severity
echo "\033[33m====================================================================\033[0m\n";
echo "\033[33m🚨 ERROR DETECTED:\033[0m\n\n";
echo "\033[33m⚠️ SEVERITY:\033[0m\n";
echo "\033[33m====================================================================\033[0m\n";

// Green — Cause + Solution
echo "\033[32m====================================================================\033[0m\n";
echo "\033[32m🔍 CAUSE:\033[0m\n\n";
echo "\033[32m🛠️ SOLUTION:\033[0m\n";
echo "\033[32m====================================================================\033[0m\n";

$result = sendToGroq($apiUrl, $apiKey, $data);

echo "\n--- AI Summary ---\n";
echo $result['choices'][0]['message']['content'] ?? 'No response. Error: ' . json_encode($result);
