<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_error('Only POST allowed', 405);
    exit;
}

$input = parse_input();
$password = trim($input['password'] ?? '');

// Static admin password (in production, use proper admin user from database)
define('ADMIN_PASSWORD', 'kevin@040');
define('ADMIN_SESSION_TIMEOUT', 30 * 60); // 30 minutes

if (!$password || $password !== ADMIN_PASSWORD) {
    send_error('Invalid admin password', 401);
    exit;
}

$conn = get_db();

// Create admin session record
$session_token = bin2hex(random_bytes(32));
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$expires_at = date('Y-m-d H:i:s', time() + ADMIN_SESSION_TIMEOUT);

$stmt = $conn->prepare('INSERT INTO admin_sessions (session_token, ip_address, user_agent, expires_at, is_active) VALUES (?, ?, ?, ?, 1)');
if (!$stmt) {
    send_error('Database error', 500);
    exit;
}

$stmt->bind_param('ssss', $session_token, $ip_address, $user_agent, $expires_at);
if (!$stmt->execute()) {
    send_error('Failed to create session', 500);
    exit;
}
$stmt->close();

// Store in PHP session
$_SESSION['admin_authenticated'] = true;
$_SESSION['session_token'] = $session_token;
$_SESSION['admin_login_time'] = time();

// Also set in cookie for frontend awareness
setcookie('admin_session', $session_token, time() + ADMIN_SESSION_TIMEOUT, '/', '', false, true);

send_json([
    'authenticated' => true,
    'session_token' => $session_token,
    'expires_in' => ADMIN_SESSION_TIMEOUT,
    'message' => 'Admin authenticated successfully'
]);
