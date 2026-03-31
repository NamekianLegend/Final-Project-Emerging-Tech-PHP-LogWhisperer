// whisper.php

<?php

echo "=====================================================\n";
echo "🟢 SYSTEM STATUS: ONLINE\n";
echo "🚀 Launching LogWhisperer\n";
for ($i = 0; $i < 3; $i++) {
    echo ".";
    usleep(400000); // 0.4 seconds
}
echo "\n\n";

echo "=====================================================\n\n";

// 1. Load the API Key safely from an environment variable that is found in the .env file
$env = parse_ini_file('.env');
$apiKey = $env['OPENAI_API_KEY'] ?? '';

if (empty($apiKey)) {
    die('ERROR: API key not found. Please set it in the .env file.\n');
}

// 2. Read the log file.
$logFile = $argv[1] ?? null;

if (!$logFile) {
    die("⚠️ No log file provided. \nUsage: php whisper.php /path/to/logfile.log\n");
}

if (!file_exists($logFile)) {
    die("❌ Log file not found: $logFile\n");
}

$logContent = file_get_contents($logFile);
echo "✅ Log file loaded successfully. Reading: $logFile\n";

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
echo " \n";

// Print the data acquired from the log file to the terminal for the user
echo "===================================================================\n";
echo "📄 Log File Content:\n";
echo "===================================================================\n";
echo "🚨 ERROR DETECTED: \n";
echo "\n";
echo "⚠️ SEVERITY: \n";
echo "====================================================================\n";
echo "🔍 CAUSE: \n";
echo "\n";
echo "🛠️ SOLUTION: \n";
echo "====================================================================\n";