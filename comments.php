<?php
require_once __DIR__ . '/helpers.php';
$conn = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['content_type'] ?? '';
    $content_id = intval($_GET['content_id'] ?? 0);
    if (!$type || !in_array($type, ['video', 'news'], true) || !$content_id) {
        send_error('content_type and content_id required', 422);
    }
    $stmt = $conn->prepare('SELECT c.*, u.username, u.profile_image FROM comments c JOIN users u ON c.user_id = u.user_id WHERE c.content_type = ? AND c.content_id = ? AND c.status = "Approved" AND c.is_deleted = 0 ORDER BY c.created_at DESC');
    $stmt->bind_param('si', $type, $content_id);
    $stmt->execute();
    $comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    send_json(['comments' => $comments]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = require_auth();
    $input = parse_input();
    $type = $input['content_type'] ?? '';
    $content_id = intval($input['content_id'] ?? 0);
    $text = trim($input['comment_text'] ?? '');
    if (!$type || !in_array($type, ['video', 'news'], true) || !$content_id || !$text) {
        send_error('content_type, content_id and comment_text are required', 422);
    }
    $stmt = $conn->prepare('INSERT INTO comments (content_type, content_id, user_id, comment_text, status) VALUES (?, ?, ?, ?, "Approved")');
    $user_id = intval($user['uid']);
    $stmt->bind_param('siis', $type, $content_id, $user_id, $text);
    if (!$stmt->execute()) {
        send_error('Failed to post comment', 500);
    }
    $inserted_id = $stmt->insert_id;
    $stmt->close();

    $counter = $type === 'video' ? 'videos' : 'news';
    $idColumn = $type === 'video' ? 'video_id' : 'news_id';
    $stmt = $conn->prepare("UPDATE $counter SET comments_count = comments_count + 1 WHERE $idColumn = ?");
    $stmt->bind_param('i', $content_id);
    $stmt->execute();
    $stmt->close();

    send_json(['message' => 'Comment posted', 'comment_id' => $inserted_id], 201);
}

send_error('Method not allowed', 405);
