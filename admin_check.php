<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

// Check if admin is authenticated
$conn = get_db();

if (!isset($_SESSION['admin_authenticated']) || !$_SESSION['admin_authenticated']) {
    send_error('Not authenticated', 401);
    exit;
}

$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    send_error('Invalid session', 401);
    exit;
}

// Verify session token in database
$session_token = $_SESSION['session_token'] ?? null;
if (!$session_token) {
    send_error('Invalid session token', 401);
    exit;
}

$stmt = $conn->prepare('SELECT admin_session_id, user_id FROM admin_sessions WHERE session_token = ? AND is_active = 1 AND expires_at > NOW()');
if (!$stmt) {
    send_error('Database error', 500);
    exit;
}

$stmt->bind_param('s', $session_token);
$stmt->execute();
$result = $stmt->get_result();
$session = $result->fetch_assoc();
$stmt->close();

if (!$session) {
    // Session expired or invalid
    session_destroy();
    send_error('Session expired', 401);
    exit;
}

send_json([
    'authenticated' => true,
    'admin_id' => (int)$session['user_id'],
    'message' => 'Admin authenticated'
]);
