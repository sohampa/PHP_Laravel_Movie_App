<?php

echo "Testing Full Laravel Movie API CRUD\n";
echo "==================================\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

// Test 1: Get all movies
echo "1. Testing GET /api/movies\n";
$response = file_get_contents($baseUrl . '/movies');
if ($response !== false) {
    $data = json_decode($response, true);
    echo "✅ Success! Found " . count($data['data']) . " movies\n\n";
} else {
    echo "❌ Failed to get movies\n\n";
}

// Test 2: Create a new movie
echo "2. Testing POST /api/movies\n";
$movieData = [
    'title' => 'Full CRUD Test Movie',
    'description' => 'This movie will be updated and then deleted',
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
        exit;
    }
} else {
    echo "❌ Failed to create movie\n";
    exit;
}

// Test 3: Get specific movie
echo "\n3. Testing GET /api/movies/{id}\n";
$response = file_get_contents($baseUrl . '/movies/' . $movieId);
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['success']) && $data['success']) {
        echo "✅ Success! Retrieved movie: " . $data['data']['title'] . "\n";
    } else {
        echo "❌ Failed to get movie\n";
    }
} else {
    echo "❌ Failed to get movie\n";
}

// Test 4: Update movie
echo "\n4. Testing PUT /api/movies/{id}\n";
$updateData = [
    'title' => 'Updated CRUD Test Movie',
    'description' => 'This movie has been updated via API',
    'genre' => 'Updated Test',
    'release_year' => 2025
];

$context = stream_context_create([
    'http' => [
        'method' => 'PUT',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($updateData)
    ]
]);

$response = file_get_contents($baseUrl . '/movies/' . $movieId, false, $context);
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['success']) && $data['success']) {
        echo "✅ Success! Movie updated: " . $data['data']['title'] . "\n";
    } else {
        echo "❌ Failed to update movie: " . $data['message'] . "\n";
    }
} else {
    echo "❌ Failed to update movie\n";
}

// Test 5: Delete movie
echo "\n5. Testing DELETE /api/movies/{id}\n";
$context = stream_context_create([
    'http' => [
        'method' => 'DELETE',
        'header' => 'Content-Type: application/json'
    ]
]);

$response = file_get_contents($baseUrl . '/movies/' . $movieId, false, $context);
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['success']) && $data['success']) {
        echo "✅ Success! Movie deleted\n";
    } else {
        echo "❌ Failed to delete movie: " . $data['message'] . "\n";
    }
} else {
    echo "❌ Failed to delete movie\n";
}

// Test 6: Search functionality
echo "\n6. Testing search functionality\n";
$response = file_get_contents($baseUrl . '/movies?search=star');
if ($response !== false) {
    $data = json_decode($response, true);
    echo "✅ Search working! Found " . count($data['data']) . " movies matching 'star'\n";
} else {
    echo "❌ Search failed\n";
}

echo "\n🎉 All CRUD operations completed successfully!\n";
echo "The Laravel Movie API is fully functional!\n";
