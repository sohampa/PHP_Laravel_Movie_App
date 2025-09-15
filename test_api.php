<?php

echo "Testing Laravel Movie API\n";
echo "========================\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

// Test 1: Get all movies
echo "1. Testing GET /api/movies\n";
$response = file_get_contents($baseUrl . '/movies');
if ($response !== false) {
    $data = json_decode($response, true);
    echo "✅ Success! Found " . count($data['data']) . " movies\n";
    echo "Response: " . substr($response, 0, 200) . "...\n\n";
} else {
    echo "❌ Failed to get movies\n\n";
}

// Test 2: Create a new movie
echo "2. Testing POST /api/movies\n";
$movieData = [
    'title' => 'Test Movie Laravel',
    'description' => 'This is a test movie created via Laravel API',
    'genre' => 'Test',
    'release_year' => 2024
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($movieData)
    ]
]);

$response = file_get_contents($baseUrl . '/movies', false, $context);
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['success']) && $data['success']) {
        echo "✅ Success! Movie created with ID: " . $data['data']['id'] . "\n";
        $movieId = $data['data']['id'];
    } else {
        echo "❌ Failed to create movie: " . $data['message'] . "\n";
    }
} else {
    echo "❌ Failed to create movie\n";
}

echo "\n3. Testing search functionality\n";
$response = file_get_contents($baseUrl . '/movies?search=test');
if ($response !== false) {
    $data = json_decode($response, true);
    echo "✅ Search working! Found " . count($data['data']) . " movies matching 'test'\n";
} else {
    echo "❌ Search failed\n";
}

echo "\nAPI Test Complete!\n";
echo "You can now use the following endpoints:\n";
echo "- GET http://127.0.0.1:8000/api/movies (list all movies)\n";
echo "- GET http://127.0.0.1:8000/api/movies?search=keyword (search movies)\n";
echo "- POST http://127.0.0.1:8000/api/movies (create movie)\n";
echo "- PUT http://127.0.0.1:8000/api/movies/{id} (update movie)\n";
echo "- DELETE http://127.0.0.1:8000/api/movies/{id} (delete movie)\n";
echo "\nAvailable fields: title, description, genre, release_year\n";
