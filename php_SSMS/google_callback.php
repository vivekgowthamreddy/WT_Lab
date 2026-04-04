<?php
// google_callback.php
session_start();
require_once 'env_loader.php';
include 'db.php';
loadEnv(__DIR__ . '/.env');

// Validate Anti-Forgery State Token
if (!isset($_GET['code']) || !isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
    die("<div style='color:red; font-family:sans-serif;'>⚠️ Invalid OAuth State / Potential CSRF Attack Sequence Blocked. <a href='login.php'>Go back</a></div>");
}

$client_id = getenv('GOOGLE_CLIENT_ID');
$client_secret = getenv('GOOGLE_CLIENT_SECRET');
$redirect_uri = getenv('GOOGLE_REDIRECT_URL');
$code = $_GET['code'];

// 1. Exchange OAuth code for Access Token natively via cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'grant_type' => 'authorization_code',
    'code' => $code
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$tokenData = json_decode($response, true);

if (!isset($tokenData['access_token'])) {
    die("<div style='color:red; font-family:sans-serif;'>⚠️ Failed to retrieve access token structure. Check your .ENV credentials carefully. <a href='login.php'>Go back</a></div>");
}

$access_token = $tokenData['access_token'];

// 2. Map User Info via Google API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/oauth2/v3/userinfo");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
$userInfo = curl_exec($ch);
curl_close($ch);

$userData = json_decode($userInfo, true);

if (!isset($userData['email'])) {
    die("<div style='color:red; font-family:sans-serif;'>⚠️ Failed to fetch structural user data. <a href='login.php'>Go back</a></div>");
}

// 3. Register or Login User securely utilizing Database Check Map
$email = htmlspecialchars($userData['email']);
$googleName = htmlspecialchars($userData['name']);
$googleId = $userData['sub'];

$stmt = mysqli_prepare($conn, "SELECT id, username, role FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    // Authenticate and mount session natively
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
} else {
    // Automatically register Google user mapping securely backing default role
    $role = 'student'; 
    $dummyHash = password_hash(bin2hex(random_bytes(10)), PASSWORD_DEFAULT); // Secure hashed randomness backing manual DB blocks
    
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $googleName, $email, $dummyHash, $role);
    mysqli_stmt_execute($stmt);
    
    $_SESSION['user_id'] = mysqli_insert_id($conn);
    $_SESSION['username'] = $googleName;
    $_SESSION['role'] = $role;
}

// 4. Divert Traffic accurately based on mapped Role
if ($_SESSION['role'] === 'admin') {
    header("Location: dashboard_admin.php");
} else {
    header("Location: dashboard_student.php");
}
exit();
?>
