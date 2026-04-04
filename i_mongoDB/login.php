<?php
session_start();
require __DIR__ . '/config/db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    die("<div style='font-family:sans-serif; color:red;'>⚠️ Email and password execution required properly seamlessly mapped natively.</div>");
}

// BSON object fetch Native Query explicitly mapping MongoDB object Array logic
$user = $users->findOne(['email' => $email]);

if (!$user) {
    die("<div style='font-family:sans-serif; color:red; padding:20px;'>⚠️ User array structure not tracked natively inside collection list. <a href='index.html'>Go back</a></div>");
}

// Validating the natively hashed strict-string block implicitly
if (!password_verify($password, $user['password'])) {
    die("<div style='font-family:sans-serif; color:red; padding:20px;'>⚠️ Invalid secure mathematical password execution. <a href='index.html'>Go back</a></div>");
}

// Login structurally safe, matched via robust tracking
$_SESSION['user'] = $user['email'];
header("Location: dashboard.php");
exit;
?>
