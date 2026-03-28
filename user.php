<?php
session_start();
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_error('Only GET allowed', 405);
    exit;
}

// Check if user is logged in via session
if (!isset($_SESSION['user_id'])) {
    send_error('Not authenticated', 401);
    exit;
}

$conn = get_db();
$user_id = $_SESSION['user_id'];

// Get user profile info
$stmt = $conn->prepare('SELECT user_id, username, email, profile_image, role FROM users WHERE user_id = ? AND is_active = 1');
if (!$stmt) {
    send_error('Database error', 500);
    exit;
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    // User session exists but user not found in DB - likely deleted
    session_destroy();
    send_error('User not found', 404);
    exit;
}

// Return user profile info
send_json([
    'authenticated' => true,
    'user' => [
        'user_id' => (int)$user['user_id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'profile_image' => $user['profile_image'],
        'role' => $user['role']
    ]
]);
