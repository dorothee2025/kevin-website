<?php
session_start();
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_error('Only POST allowed', 405);
}

$input = parse_input();
$username = trim($input['username'] ?? '');
$email = trim(strtolower($input['email'] ?? ''));
$password = trim($input['password'] ?? '');

if (!$username || !$email || !$password) {
    send_error('username, email and password are required', 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    send_error('Invalid email format', 422);
}
if (strlen($password) < 6) {
    send_error('Password must be at least 6 characters', 422);
}

$conn = get_db();
$stmt = $conn->prepare('SELECT user_id FROM users WHERE username = ? OR email = ? LIMIT 1');
$stmt->bind_param('ss', $username, $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    $stmt->close();
    send_error('Username or email already exists', 409);
}
$stmt->close();

$hash = password_hash($password, PASSWORD_DEFAULT);
$role = 'user';
$profile_image = trim($input['profile_image'] ?? null);

$stmt = $conn->prepare('INSERT INTO users (username, email, password_hash, role, profile_image) VALUES (?, ?, ?, ?, ?)');
if (!$stmt) {
    send_error('Failed to prepare insert statement', 500);
}
$stmt->bind_param('sssss', $username, $email, $hash, $role, $profile_image);
if (!$stmt->execute()) {
    send_error('Failed to create user', 500);
}
$user_id = $stmt->insert_id;
$stmt->close();

// Set session variables for newly registered user
$_SESSION['user_id'] = $user_id;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['role'] = $role;

$user = get_user_by_id($user_id);

send_json([
    'success' => true,
    'authenticated' => true,
    'user' => $user
], 201);
