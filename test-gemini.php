<?php

// Test Gemini API - List Models
require __DIR__.'/vendor/autoload.php';

$apiKey = 'AIzaSyBpgeLfA8k6lo9FLPt_6FS6yapsZ1tacyM';
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Response:\n";

$data = json_decode($response, true);
if (isset($data['models'])) {
    foreach ($data['models'] as $model) {
        if (strpos($model['name'], 'gemini') !== false) {
            echo "- {$model['name']}\n";
            if (isset($model['supportedGenerationMethods'])) {
                echo "  Methods: " . implode(', ', $model['supportedGenerationMethods']) . "\n";
            }
        }
    }
} else {
    echo $response;
}
echo "\n";
