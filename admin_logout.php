<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_error('Only POST allowed', 405);
    exit;
}

$session_token = $_SESSION['session_token'] ?? null;

if ($session_token) {
    $conn = get_db();
    $stmt = $conn->prepare('UPDATE admin_sessions SET is_active = 0 WHERE session_token = ?');
    if ($stmt) {
        $stmt->bind_param('s', $session_token);
        $stmt->execute();
        $stmt->close();
    }
}

// Destroy session
session_destroy();

// Clear cookie
setcookie('admin_session', '', time() - 3600, '/', '', false, true);

send_json([
    'authenticated' => false,
    'message' => 'Logged out successfully'
]);
