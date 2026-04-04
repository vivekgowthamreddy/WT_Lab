<?php
// google_login.php
session_start();
require_once 'env_loader.php';
loadEnv(__DIR__ . '/.env');

$client_id = getenv('GOOGLE_CLIENT_ID');
$redirect_uri = getenv('GOOGLE_REDIRECT_URL');

// Scopes required for authentication payload mapping
$params = [
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'scope' => 'email profile',
    'state' => bin2hex(random_bytes(16)) // CSFR attack mitigation
];

// Secure the state mapping uniquely in session
$_SESSION['oauth_state'] = $params['state'];

$authUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($params);
header('Location: ' . $authUrl);
exit();
?>
