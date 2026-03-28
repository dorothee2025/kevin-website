<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if intro has been seen
    $intro_seen = false;

    if (isset($_SESSION['user_id'])) {
        // Authenticated user - check database
        $conn = get_db();
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare('SELECT intro_seen FROM user_state WHERE user_id = ?');
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $state = $result->fetch_assoc();
            $stmt->close();

            if ($state) {
                $intro_seen = (bool)$state['intro_seen'];
            }
        }
    } else {
        // Unauthenticated user - check session
        $intro_seen = isset($_SESSION['intro_seen']) && $_SESSION['intro_seen'];
    }

    send_json(['intro_seen' => $intro_seen]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mark intro as seen
    $input = parse_input();
    $mark_seen = isset($input['seen']) ? (bool)$input['seen'] : true;

    if (isset($_SESSION['user_id'])) {
        // Authenticated user - update database
        $conn = get_db();
        $user_id = $_SESSION['user_id'];

        // Ensure state record exists
        $stmt = $conn->prepare('INSERT IGNORE INTO user_state (user_id) VALUES (?)');
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->close();
        }

        // Update intro_seen
        $stmt = $conn->prepare('UPDATE user_state SET intro_seen = ?, updated_at = NOW() WHERE user_id = ?');
        if ($stmt) {
            $value = $mark_seen ? 1 : 0;
            $stmt->bind_param('ii', $value, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        // Unauthenticated user - set in session
        $_SESSION['intro_seen'] = $mark_seen;
    }

    send_json(['success' => true, 'intro_seen' => $mark_seen]);

} else {
    send_error('Method not allowed', 405);
}
