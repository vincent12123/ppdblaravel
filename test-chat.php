<?php

$apiKey = 'AIzaSyBpgeLfA8k6lo9FLPt_6FS6yapsZ1tacyM';
$model = 'gemini-2.0-flash';

$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$payload = [
    'systemInstruction' => [
        'parts' => [
            ['text' => 'Anda adalah asisten PPDB yang membantu menjawab pertanyaan tentang pendaftaran siswa baru.']
        ]
    ],
    'contents' => [
        [
            'parts' => [
                ['text' => 'Apa itu PPDB?']
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 500
    ]
];

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Response:\n";

$decoded = json_decode($response, true);
if (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
    echo "SUCCESS! AI Response:\n";
    echo $decoded['candidates'][0]['content']['parts'][0]['text'] . "\n";
} else {
    echo json_encode($decoded, JSON_PRETTY_PRINT) . "\n";
}
