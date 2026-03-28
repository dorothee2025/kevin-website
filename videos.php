<?php
require_once __DIR__ . '/helpers.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn = get_db();

if ($method === 'GET') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $stmt = $conn->prepare('SELECT v.*, u.username AS uploader_name, c.name AS category_name FROM videos v LEFT JOIN users u ON v.uploader_id = u.user_id LEFT JOIN categories c ON v.category_id = c.category_id WHERE v.video_id = ? AND v.status <> "Archived" LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $video = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$video) {
            send_error('Video not found', 404);
        }
        send_json(['video' => $video]);
    }
    $status = $_GET['status'] ?? 'Published';
    $limit = max(1, min(100, intval($_GET['limit'] ?? 20)));
    $offset = max(0, intval($_GET['offset'] ?? 0));
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
    $type = $_GET['video_type'] ?? null;

    $sql = 'SELECT v.*, u.username AS uploader_name, c.name AS category_name FROM videos v LEFT JOIN users u ON v.uploader_id = u.user_id LEFT JOIN categories c ON v.category_id = c.category_id WHERE v.status = ?';
    if ($category_id) { $sql .= ' AND v.category_id = ?'; }
    if ($type) { $sql .= ' AND v.video_type = ?'; }
    $sql .= ' ORDER BY v.upload_date DESC LIMIT ? OFFSET ?';

    if ($category_id && $type) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisii', $status, $category_id, $type, $limit, $offset);
    } elseif ($category_id) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siii', $status, $category_id, $limit, $offset);
    } elseif ($type) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $status, $type, $limit, $offset);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $status, $limit, $offset);
    }
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    send_json(['videos' => $results]);
}

if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
    $user = require_role(['admin', 'creator']);
    $input = parse_input();

    if ($method === 'POST') {
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $video_file = trim($input['video_file'] ?? '');
        $thumbnail = trim($input['thumbnail'] ?? '');
        $category_id = isset($input['category_id']) ? intval($input['category_id']) : null;
        $video_type = in_array($input['video_type'] ?? 'general', ['hack', 'coding', 'general'], true) ? $input['video_type'] : 'general';
        $duration = isset($input['duration']) ? intval($input['duration']) : null;
        $status = in_array($input['status'] ?? 'Published', ['Draft', 'Published', 'Archived'], true) ? $input['status'] : 'Published';

        if (!$title || !$description || !$video_file) {
            send_error('title, description and video_file are required', 422);
        }

        $uploader_id = intval($user['uid']);
        $stmt = $conn->prepare('INSERT INTO videos (title, description, video_file, thumbnail, category_id, video_type, duration, status, uploader_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssisisiis', $title, $description, $video_file, $thumbnail, $category_id, $video_type, $duration, $status, $uploader_id);
        if (!$stmt->execute()) {
            send_error('Failed to create video', 500);
        }
        $video_id = $stmt->insert_id;
        $stmt->close();
        send_json(['message' => 'Video created', 'video_id' => $video_id], 201);
    }

    if ($method === 'PUT') {
        $id = intval($input['video_id'] ?? 0);
        if (!$id) {
            send_error('video_id is required', 422);
        }
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $video_file = trim($input['video_file'] ?? '');
        $thumbnail = trim($input['thumbnail'] ?? '');
        $category_id = isset($input['category_id']) ? intval($input['category_id']) : null;
        $video_type = in_array($input['video_type'] ?? 'general', ['hack', 'coding', 'general'], true) ? $input['video_type'] : 'general';
        $duration = isset($input['duration']) ? intval($input['duration']) : null;
        $status = in_array($input['status'] ?? 'Published', ['Draft', 'Published', 'Archived'], true) ? $input['status'] : 'Published';

        $stmt = $conn->prepare('UPDATE videos SET title = ?, description = ?, video_file = ?, thumbnail = ?, category_id = ?, video_type = ?, duration = ?, status = ? WHERE video_id = ?');
        $stmt->bind_param('sssisiiisi', $title, $description, $video_file, $thumbnail, $category_id, $video_type, $duration, $status, $id);
        if (!$stmt->execute()) {
            send_error('Failed to update video', 500);
        }
        $stmt->close();
        send_json(['message' => 'Video updated']);
    }

    if ($method === 'DELETE') {
        $id = intval($_GET['id'] ?? 0);
        if (!$id) {
            send_error('id is required', 422);
        }
        $stmt = $conn->prepare('UPDATE videos SET status = "Archived" WHERE video_id = ?');
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            send_error('Failed to archive video', 500);
        }
        $stmt->close();
        send_json(['message' => 'Video archived']);
    }
}

send_error('Unsupported method', 405);
