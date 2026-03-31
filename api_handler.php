<?php
// api_handler.php

// api_handler.php
function sendToGroq($apiUrl, $apiKey, $data) {
    $options = [
        'http' => [
            'method'  => 'POST',
            // Use a string for headers to avoid common stream_context issues
            'header'  => "Content-Type: application/json\r\n" .
                         "Authorization: Bearer $apiKey\r\n",
            'content' => json_encode($data),
            'ignore_errors' => true // Allows you to see the error body if it fails
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    return $response ? json_decode($response, true) : ["error" => "Transmission failed"];
}