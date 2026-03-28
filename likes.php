<?php
require_once __DIR__ . '/helpers.php';
$conn = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['content_type'] ?? '';
    $content_id = intval($_GET['content_id'] ?? 0);
    if (!$type || !in_array($type, ['video', 'news'], true) || !$content_id) {
        send_error('content_type and content_id required', 422);
    }
    $stmt = $conn->prepare('SELECT COUNT(*) AS total_likes FROM likes WHERE content_type = ? AND content_id = ?');
    $stmt->bind_param('si', $type, $content_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    send_json(['likes' => intval($data['total_likes'])]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = require_auth();
    $input = parse_input();
    $type = $input['content_type'] ?? '';
    $content_id = intval($input['content_id'] ?? 0);
    if (!$type || !in_array($type, ['video', 'news'], true) || !$content_id) {
        send_error('content_type and content_id required', 422);
    }

    $user_id = intval($user['uid']);
    $stmt = $conn->prepare('INSERT IGNORE INTO likes (content_type, content_id, user_id) VALUES (?, ?, ?)');
    $stmt->bind_param('sii', $type, $content_id, $user_id);
    if (!$stmt->execute()) {
        send_error('Failed to add like', 500);
    }
    $stmt->close();

    $counterTable = $type === 'video' ? 'videos' : 'news';
    $idColumn = $type === 'video' ? 'video_id' : 'news_id';
    $stmt = $conn->prepare("UPDATE $counterTable SET likes = likes + 1 WHERE $idColumn = ?");
    $stmt->bind_param('i', $content_id);
    $stmt->execute();
    $stmt->close();

    send_json(['message' => 'Liked']);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $user = require_auth();
    $type = $_GET['content_type'] ?? '';
    $content_id = intval($_GET['content_id'] ?? 0);
    if (!$type || !in_array($type, ['video', 'news'], true) || !$content_id) {
        send_error('content_type and content_id required', 422);
    }

    $user_id = intval($user['uid']);
    $stmt = $conn->prepare('DELETE FROM likes WHERE content_type = ? AND content_id = ? AND user_id = ?');
    $stmt->bind_param('sii', $type, $content_id, $user_id);
    $stmt->execute();
    $deleted = $stmt->affected_rows;
    $stmt->close();

    if ($deleted > 0) {
        $counterTable = $type === 'video' ? 'videos' : 'news';
        $idColumn = $type === 'video' ? 'video_id' : 'news_id';
        $stmt = $conn->prepare("UPDATE $counterTable SET likes = GREATEST(likes - 1, 0) WHERE $idColumn = ?");
        $stmt->bind_param('i', $content_id);
        $stmt->execute();
        $stmt->close();
    }

    send_json(['message' => 'Unliked', 'removed' => $deleted > 0]);
}

send_error('Method not allowed', 405);
