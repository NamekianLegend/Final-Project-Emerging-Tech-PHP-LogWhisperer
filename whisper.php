<?php
// whisper.php
require_once 'api_handler.php';

//STARTUP BANNER — Bright Green
echo "\033[92m====================================================================\033[0m\n";
echo "\033[92m🟢 SYSTEM STATUS: ONLINE\033[0m\n";
echo "\033[92m🚀 Launching LogWhisperer\033[0m\n";

for ($i = 0; $i < 3; $i++) {
    echo "\033[92m.\033[0m";
    usleep(400000);
}
echo "\n";

echo "\033[92m====================================================================\033[0m\n\n";

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
    // Force the model to return a JSON object
    'response_format' => ['type' => 'json_object'], 
    'messages' => [
        [
            'role' => 'system', 
            'content' => 'You are a server admin assistant. You MUST respond ONLY with a valid JSON object containing exactly these four keys: "error_detected" (a short summary), "severity" (e.g., Low, Medium, High, Critical), "cause" (why it happened), and "solution" (how to fix it).'
        ],
        [
            'role' => 'user', 
            'content' => "Analyze the following log content:\n\n$logContent"
        ]
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

// 4. Get and Parse the API Response
$result = sendToGroq($apiUrl, $apiKey, $data);
$aiResponseText = $result['choices'][0]['message']['content'] ?? '{}';

// Decode the JSON string into a PHP associative array
$parsedData = json_decode($aiResponseText, true);

// Extract the variables (with fallbacks just in case the AI hallucinates)
$aiError    = $parsedData['error_detected'] ?? 'Failed to extract error summary.';
$aiSeverity = $parsedData['severity'] ?? 'UNKNOWN';
$aiCause    = $parsedData['cause'] ?? 'Failed to extract cause.';
$aiSolution = $parsedData['solution'] ?? 'Failed to extract solution.';


// Cyan — Log Content
echo "\033[36m====================================================================\033[0m\n";
echo "\033[36m📄 Log File Content:\033[0m\n";
// Print the full log content
echo $logContent . "\n";
echo "\033[36m====================================================================\033[0m\n\n";

// Yellow — Error + Severity
echo "\033[33m====================================================================\033[0m\n";
echo "\033[33m🚨 ERROR DETECTED:\033[0m\n";
echo wordwrap($aiError, 65, "\n") . "\n\n"; // Wordwrap keeps it neat in the terminal
echo "\033[33m⚠️ SEVERITY:\033[0m " . strtoupper($aiSeverity) . "\n";
echo "\033[33m====================================================================\033[0m\n\n";

// Green — Cause + Solution
echo "\033[32m====================================================================\033[0m\n";
echo "\033[32m🔍 CAUSE:\033[0m\n";
echo wordwrap($aiCause, 65, "\n") . "\n\n";
echo "\033[32m🛠️ SOLUTION:\033[0m\n";
echo wordwrap($aiSolution, 65, "\n") . "\n";
echo "\033[32m====================================================================\033[0m\n\n";

echo "\033[90m====================================================================\033[0m\n";
echo "\033[90m🔚 End of Report — LogWhisperer v1.0\033[0m\n";
echo "\033[90m====================================================================\033[0m\n";
