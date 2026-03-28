<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

// Get or POST user state
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get current user's state
    if (!isset($_SESSION['user_id'])) {
        send_error('Not authenticated', 401);
        exit;
    }

    $conn = get_db();
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare('SELECT user_state_id, intro_seen, history_hint_dismissed, preferences FROM user_state WHERE user_id = ?');
    if (!$stmt) {
        send_error('Database error', 500);
        exit;
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $state = $result->fetch_assoc();
    $stmt->close();

    if (!$state) {
        // Initialize default state
        $stmt = $conn->prepare('INSERT INTO user_state (user_id, intro_seen, history_hint_dismissed, preferences) VALUES (?, 0, 0, ?)');
        if ($stmt) {
            $prefs = json_encode(['theme' => 'dark']);
            $stmt->bind_param('is', $user_id, $prefs);
            $stmt->execute();
            $stmt->close();
            $state = [
                'intro_seen' => false,
                'history_hint_dismissed' => false,
                'preferences' => json_decode($prefs, true)
            ];
        }
    }

    send_json([
        'state' => [
            'intro_seen' => (bool)$state['intro_seen'],
            'history_hint_dismissed' => (bool)$state['history_hint_dismissed'],
            'preferences' => json_decode($state['preferences'] ?? '{}', true)
        ]
    ]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user state
    if (!isset($_SESSION['user_id'])) {
        send_error('Not authenticated', 401);
        exit;
    }

    $input = parse_input();
    $user_id = $_SESSION['user_id'];
    $conn = get_db();

    // Ensure state record exists
    $stmt = $conn->prepare('INSERT IGNORE INTO user_state (user_id) VALUES (?)');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();
    }

    $updates = [];
    $types = '';
    $params = [];

    if (isset($input['intro_seen'])) {
        $updates[] = 'intro_seen = ?';
        $types .= 'i';
        $params[] = $input['intro_seen'] ? 1 : 0;
    }

    if (isset($input['history_hint_dismissed'])) {
        $updates[] = 'history_hint_dismissed = ?';
        $types .= 'i';
        $params[] = $input['history_hint_dismissed'] ? 1 : 0;
    }

    if (isset($input['preferences'])) {
        $updates[] = 'preferences = ?';
        $types .= 's';
        $params[] = json_encode($input['preferences']);
    }

    if (empty($updates)) {
        send_json(['state' => 'No updates provided']);
        exit;
    }

    $params[] = $user_id;
    $types .= 'i';

    $query = 'UPDATE user_state SET ' . implode(', ', $updates) . ', updated_at = NOW() WHERE user_id = ?';
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        send_error('Database error', 500);
        exit;
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();

    send_json(['success' => true, 'message' => 'State updated']);

} else {
    send_error('Method not allowed', 405);
}
