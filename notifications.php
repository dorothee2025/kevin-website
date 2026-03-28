<?php
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

session_start();

// Check admin authentication first
if (!isset($_SESSION['admin_authenticated']) || !$_SESSION['admin_authenticated']) {
    send_error('Not authenticated', 401);
    exit;
}

$conn = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get recent notifications
    $limit = intval($_GET['limit'] ?? 40);
    $limit = min($limit, 100);

    $stmt = $conn->prepare('
        SELECT n.notification_id, n.content_type, n.content_id, n.title, n.created_at
        FROM notification_log n
        ORDER BY n.created_at DESC
        LIMIT ?
    ');
    if (!$stmt) {
        send_error('Database error', 500);
        exit;
    }

    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = [
            'id' => (int)$row['notification_id'],
            'contentType' => $row['content_type'],
            'content_id' => (int)$row['content_id'],
            'title' => $row['title'],
            'uploadTimestamp' => strtotime($row['created_at']) * 1000
        ];
    }
    $stmt->close();

    send_json(['notifications' => $notifications]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log a new notification
    $input = parse_input();
    $content_type = $input['content_type'] ?? null;
    $content_id = intval($input['content_id'] ?? 0);
    $title = $input['title'] ?? 'New content';

    if (!$content_type || !$content_id) {
        send_error('content_type and content_id required', 422);
        exit;
    }

    $stmt = $conn->prepare('INSERT INTO notification_log (content_type, content_id, title) VALUES (?, ?, ?)');
    if (!$stmt) {
        send_error('Database error', 500);
        exit;
    }

    $stmt->bind_param('sis', $content_type, $content_id, $title);
    if (!$stmt->execute()) {
        send_error('Failed to create notification', 500);
        exit;
    }
    $stmt->close();

    send_json(['success' => true, 'message' => 'Notification created']);

} else {
    send_error('Method not allowed', 405);
}
