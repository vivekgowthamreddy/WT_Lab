<?php
session_start();
require __DIR__ . '/config/db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    die("<div style='font-family:sans-serif; color:red; padding:20px;'>⚠️ Email and password are strictly required syntactically.</div>");
}

// Map MongoDB user document natively checking for conflicts
$existingUser = $users->findOne(['email' => $email]);

if ($existingUser) {
    die("<div style='font-family:sans-serif; color:red; padding:20px;'>⚠️ Identity blocked: User already exists utilizing that email vector mapping. <a href='index.html'>Go back</a></div>");
}

// Standard highly secure PHP Hashing mapping implicitly
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert raw NO-SQL BSON Object logically native explicitly into the Document Array
$users->insertOne([
    'email' => $email,
    'password' => $hashedPassword,
    'createdAt' => new MongoDB\BSON\UTCDateTime()
]);

echo "<div style='font-family:sans-serif; background:#00ED64; padding:20px; font-weight:bold;'>✅ Signup registered safely inside MongoDB Document! <a href='index.html' style='color:#001E2B;'>Go to Login -></a></div>";
?>
