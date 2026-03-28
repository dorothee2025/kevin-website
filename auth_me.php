<?php
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_error('Only GET allowed', 405);
}
$payload = require_auth();
$user = get_user_by_id((int)$payload['uid']);
if (!$user) {
    send_error('User not found', 404);
}
send_json(['user' => $user]);
