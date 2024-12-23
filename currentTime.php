<?php
// Set the content type to application/json
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Read the raw POST data
$input = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

$results = []; // Initialize an array to store the results

if (isset($data['toolCalls']) && is_array($data['toolCalls'])) {
    foreach ($data['toolCalls'] as $toolCall) {
        if (isset($toolCall['id'])) {
            // Fetch the value of the 'id' key
            $id = $toolCall['id'];
            // Add result to the array
            $results[] = ['toolCallId' => $id, 'result' => 'Current Time is ' . date('H:i:s')];
        } else {
            $results[] = ['error' => 'ID key not found in this toolCall'];
        }
    }

    // Return the results as a JSON response
    echo json_encode(['results' => $results]);
} else {
    echo json_encode(['error' => 'No toolCalls data received']);
}
?>
