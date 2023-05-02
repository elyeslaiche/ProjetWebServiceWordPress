<?php

define('CLIENT_ID', '8c9426efdfa64888967e134c1b5b032c');
define('CLIENT_SECRET', 'f7993950aea54e1c8868f93ed4de4def');


function get_access_token()
{
    // Define the Spotify API endpoint
    $endpoint = "https://accounts.spotify.com/api/token";

    // Define the POST data to send to the API
    $data = array(
        'grant_type' => 'client_credentials',
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
    );

    // Encode the POST data as URL-encoded format
    $data = http_build_query($data);

    // Define the options for the stream context
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
            "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data,
        ),
    );

    // Create the stream context with the options
    $context = stream_context_create($options);

    // Send the POST request to the Spotify API endpoint and retrieve the response
    $response = file_get_contents($endpoint, false, $context);

    // Decode the response JSON into an associative array
    $response_data = json_decode($response, true);

    // Extract the access token from the response data
    $access_token = $response_data['access_token'];

    return $access_token;
}

$access_token = get_access_token();

// Define the Spotify API search endpoint
$search_endpoint = 'https://api.spotify.com/v1/search';

// Define the search query
$query = $_GET['value'];

// Define the search types
$types = 'artist,album,track';

// Define the options for the stream context to send the GET request to the search endpoint
$search_options = array(
    'http' => array(
        'method' => 'GET',
        'header' => "Authorization: Bearer ".$access_token."\r\n" .
        "Content-Type: application/json\r\n",
    ),
);

// Create the URL for the search endpoint with the query and types parameters
$search_url = $search_endpoint . '?' . http_build_query(
    array(
        'q' => $query,
        'type' => $types,
    )
);

// Create the stream context with the options
$search_context = stream_context_create($search_options);

// Send the GET request to the Spotify API search endpoint and retrieve the response
$search_response = file_get_contents($search_url, false, $search_context);

// Decode the response JSON into an associative array
$search_data = json_decode($search_response, true);

echo "Search Results for '$query':\n\n";

// Print the track results
if (isset($search_data['tracks']['items'])) {
    echo "Tracks:\n";
    foreach ($search_data['tracks']['items'] as $track) {
        echo "\t" . $track['name'] . " - " . $track['artists'][0]['name'] . "\n";
    }
    echo "\n";
}

// Print the album results
if (isset($search_data['albums']['items'])) {
    echo "Albums:\n";
    foreach ($search_data['albums']['items'] as $album) {
        echo "\t" . $album['name'] . " - " . $album['artists'][0]['name'] . "\n";
    }
    echo "\n";
}

// Print the artist results
if (isset($search_data['artists']['items'])) {
    echo "Artists:\n";
    foreach ($search_data['artists']['items'] as $artist) {
        echo "\t" . $artist['name'] . "\n";
    }
    echo "\n";
}

?>