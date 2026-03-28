<?php
session_start();
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_error('Only POST allowed', 405);
}

$input = parse_input();
$usernameOrEmail = trim($input['username'] ?? '');
$password = trim($input['password'] ?? '');

if (!$usernameOrEmail || !$password) {
    send_error('username/email and password are required', 422);
}

$conn = get_db();
$stmt = $conn->prepare('SELECT user_id, username, email, password_hash, role, profile_image, is_active FROM users WHERE (username = ? OR email = ?) LIMIT 1');
if (!$stmt) {
    send_error('Failed to prepare statement', 500);
}
$stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($password, $user['password_hash'])) {
    send_error('Invalid credentials', 401);
}

if (!$user['is_active']) {
    send_error('Account is inactive', 403);
}

// Set session variables for logged-in user
$_SESSION['user_id'] = (int)$user['user_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];

send_json([
    'success' => true,
    'authenticated' => true,
    'user' => [
        'user_id' => (int)$user['user_id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'profile_image' => $user['profile_image'],
        'role' => $user['role'],
    ],
]);
