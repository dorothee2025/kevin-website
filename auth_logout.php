<?php
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_error('Only POST allowed', 405);
    exit;
}

session_start();

// Destroy user session
session_destroy();

// Clear auth cookie
setcookie('user_auth', '', time() - 3600, '/', '', false, true);

send_json([
    'success' => true,
    'authenticated' => false,
    'message' => 'Logged out successfully'
]);
